<?php

namespace App\Livewire\Suppliers;

use App\Models\FieldMapping;
use App\Models\Supplier;
use Dflydev\DotAccessData\Data;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Parser\StringWalker;

use Prewk\XmlStringStreamer\Stream\Guzzle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class Mapping1 extends Component
{


    public  $supplier;

    public  $url;

    public int $step = 1;
    public array $fields    = [];
    public array $dbColumns = [];
    public array $mapping   = [];
    protected $queryString = [
        'step' => ['except' => 1],
    ];
    public string $xmlPathInput = '';
    public function mount($supplier=null)
    {




        $this->supplier = Supplier::findOrFail($supplier);

        $this->dbColumns = Schema::getColumnListing('products');
        $hasMapping = \App\Models\FieldMapping::where('supplier_id', $this->supplier->id)->exists();
        if ($hasMapping) {
            $this->step = 3;
            return;
        }

        if (!empty($this->supplier->xml_path)) {
            $this->prepareMapping();
            $this->step = 2;
            return;
        }

        $this->step = 1;




    }

    public function render()
    {
        return view('livewire.suppliers.mapping');
    }




    public function save()
    {
    //    $this->validate();

        $path = 'suppliers/'.$this->supplier->id.'/feed.xml';
        $fullPath     = storage_path('app/'.$path);
        $dir          = dirname($fullPath);


        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        Http::withOptions([
            'sink' => $fullPath,
            'timeout' => 120,
        ])->get($this->supplier->api_url);
        $this->supplier->update(['xml_path' => $path]);

        $this->prepareMapping();
        $this->step = 2;

    }

    protected function prepareMapping()
    {
        $reader = new \XMLReader();
        $reader->open(storage_path('app/'.$this->supplier->xml_path));

        while ($reader->read() && $reader->name !== 'LineItem');
        $xmlString = $reader->readOuterXml();
        $reader->close();
        $element       = new \SimpleXMLElement($xmlString);
        $this->fields  = array_keys((array) $element);

        $existing = FieldMapping::where('supplier_id', $this->supplier->id)
            ->pluck('target_field','source_field')
            ->toArray();

        $this->mapping = [];
        foreach ($this->fields as $field) {
            $this->mapping[$field] = $existing[$field] ?? '';
        }
    }

    public function saveMapping()
    {
//        $this->validate([
//            'mapping.*' => 'required|in:'.implode(',',$this->dbColumns),
//        ]);

        $filtered = array_filter($this->mapping, fn($v) => !empty($v));

        if ($filtered){

            foreach ($filtered as $xmlField => $dbCol) {
                FieldMapping::updateOrCreate(
                    ['supplier_id'=>$this->supplier->id, 'source_field'=>$xmlField],
                    ['target_field'=>$dbCol]
                );
            }
            $this->step = 3;
            return;
        }


        $this->step=2;



    }



    public function editMapping()
    {

        $this->prepareMapping();

        $this->step = 2;
    }

}
