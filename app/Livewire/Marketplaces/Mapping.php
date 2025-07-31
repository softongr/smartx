<?php

namespace App\Livewire\Marketplaces;

use App\Models\Category;
use App\Models\CategoryMapping;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Mapping extends Component
{

    public $search;

    use WithPagination;
    use WithoutUrlPagination;
    public array $categoryInput = [];

    public function mount()
    {


        $this->categoryInput = CategoryMapping::with('categories')->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->categories->pluck('id')->implode(',')]; // π.χ. "1,3,5"
        })->toArray();
    }



    public function render()
    {
        $items = CategoryMapping::query()->doesntHave('categories')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->with(['categories', 'marketplace'])
            ->orderBy('id', 'desc')
            ->paginate(150);

        $count = Cache::remember('category_mappings_total_count', 3600, fn() => CategoryMapping::count());

        return view('livewire.marketplaces.mapping', [
            'items' => $items,
            'count' => $count,

        ]);
    }

    public function saveCategoryMapping($mappingId)
    {
        $idsString = $this->categoryInput[$mappingId] ?? '';

        $ids = collect(explode(',', $idsString))
            ->map(fn($id) => (int) trim($id))
            ->filter(fn($id) => $id > 0)
            ->unique()
            ->values();


        $validCategoryIds = Category::whereIn('id', $ids)->pluck('id')->toArray();
        $ignored = $ids->diff($validCategoryIds);

        $mapping = CategoryMapping::find($mappingId);

        if ($mapping) {
            $mapping->categories()->sync($validCategoryIds);
            if ($ignored->isNotEmpty()) {
                session()->flash('error', __('Some category IDs were invalid and have been ignored: ') . $ignored->implode(', '));

                return;
            }
            session()->flash('success', __('The category mapping has been saved successfully.'));


        } else {
            session()->flash('error', __('Error: Category mapping not found.'));

        }

        return redirect()->route('marketplace.map', ['marketplace' => $mappingId]);
    }
}
