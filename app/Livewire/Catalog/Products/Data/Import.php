<?php

namespace App\Livewire\Catalog\Products\Data;

use App\Livewire\OpenAi\Mapper\Product;
use App\Models\Marketplace;
use App\Models\RateVat;
use Livewire\Component;
use Livewire\WithFileUploads;

class Import extends Component
{
    use WithFileUploads; // ✅ ΠΡΟΣΘΗΚΗ

    public $jsonFile;

    public function render()
    {
        return view('livewire.catalog.products.data.import');
    }


    public function save()
    {
        $this->validate([
            'jsonFile' => 'required|file|mimes:json,txt',
        ]);

        $path = $this->jsonFile->getRealPath();
        $content = file_get_contents($path);
        $data = json_decode($content, true);

        if (!is_array($data)) {
            session()->flash('error', 'Μη έγκυρο JSON αρχείο.');
            return;
        }
        $created = 0;
        foreach ($data as $item) {
            $scrapeLink = $item['scrape_link'] ?? null;

            $exists = \App\Models\Product::where('scrape_link', $scrapeLink)->exists();
            if ($exists) {
                continue;
            }
            $fields = [
                'scrape_link'          => $item['scrape_link'],
                'quantity'             => $item['quantity'],
                'ean'                  => $item['ean'] ?? null,
                'marketplace_id'       => 1,
                'wholesale_price'      => $item['wholesale_price'],
                'source_method'        =>'scrape',
                'status'               => 'pending',
                'rate_vat_id'         => RateVat::where('default', true)->value('id')
            ];

            $product = \App\Models\Product::create($fields);

            $activeMarketplaces = Marketplace::where('has_commission', true)->get();

            $marketplacesData = $activeMarketplaces->mapWithKeys(function ($marketplace) {
                return [
                    $marketplace->id => [
                        'price' => 0,
                        'profit_margin'=>0,
                        'safety_price' => null
                    ]
                ];
            });


            $product->marketplacesprices()->sync($marketplacesData);
            $created++;
        }

        session()->flash('success', 'Η εισαγωγή ολοκληρώθηκε.');
    }
}
