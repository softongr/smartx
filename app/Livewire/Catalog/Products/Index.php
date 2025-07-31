<?php

namespace App\Livewire\Catalog\Products;

use App\Helpers\CategoryMappingHelper;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class Index extends Component
{

    public $search;
    public $step = '1';
    public $stepCounts = [];

    use WithPagination;
//    use WithoutUrlPagination;

    public function updatedSearch()
    {
        $this->resetPage();
    }



    public function mount()
    {
        $this->step = request()->get('step', '1'); // παίρνει από URL ή βάζει default
    }



    public function render()
    {

        $this->stepCounts = [
            '1' => Product::whereNull('external_id')->where('step', 1)->count(),
            '2' => Product::whereNull('external_id')->where('step', 2)->count(),
            '3' => Product::whereNull('external_id')->where('step', 3)->count(),
            '4' => Product::whereNull('external_id')->where('step', 4)->count(),
        ];
        $query = Product::whereNull('external_id')
            ->where('step', $this->step);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $search = '%' . $this->search . '%';
                $q->whereRaw('COALESCE(name, "") LIKE ?', [$search])
                    ->orWhereRaw('COALESCE(mpn, "") LIKE ?', [$search])
                    ->orWhereRaw('COALESCE(ean, "") LIKE ?', [$search])
                    ->orWhereRaw('COALESCE(scrape_Link, "") LIKE ?', [$search]);
            });
        }

        $items = $query->latest()->paginate(20);

        return view('livewire.catalog.products.index', [
            'items' => $items,
            'count' => Product::whereNull('external_id')
                ->where('step', $this->step)->count(),
            'stepCounts' => $this->stepCounts,
            'runningProducts' => $this->runningProducts,
            'checkCategoryMapper' => !CategoryMappingHelper::allCategoryMappingsHaveCategories()
        ]);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        session()->flash('success',  __('Deleted Successfully'));
        return redirect()->route('products.index', ['step' => $this->step]);
    }

    public function getRunningProductsProperty()
    {
        $ids = Product::whereNull('external_id')->where('step', $this->step)->pluck('id')->all();

        $keys = collect($ids)->flatMap(function ($id) {
            return [
                "scraping:running:product:$id" => $id,
                "analytics:running:product:$id" => $id,
            ];
        });

        $results = Cache::many($keys->keys()->all());

        $running = collect($results)
            ->filter()
            ->values()
            ->unique()
            ->all();

        return $running;
    }

    public function setAsPlatform($id)
    {
        $product = Product::findOrFail($id);

        if ($product->status === 'pending') {
            $product->status = 'platform';
        }else{
            $product->status = 'pending';
        }
        $product->save();

        session()->flash('success', __('Product promoted to platform and marked as default.'));
    }

    public function exportToJson()
    {
        $products = Product::whereNull('external_id')
            ->where('step', 1)
            ->where('status', 'pending')
            ->get(['quantity', 'ean', 'scrape_link','wholesale_price'])

            ->map(function ($product) {
                return [
                    'quantity'   => $product->quantity,
                    'wholesale_price' => $product->wholesale_price,
                    'link' => $product->scrape_link,
                    'ean' => ($product->ean) ? $product->ean : null,
                ];
            });


        $filename = 'products_export_' . now()->format('Ymd_His') . '.json';

        return response()->streamDownload(function () use ($products) {
            echo $products->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }



}
