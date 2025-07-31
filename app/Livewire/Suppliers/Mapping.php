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

class Mapping extends Component
{

    public Supplier $supplier;

    public function mount($supplier)
    {

        $this->supplier = Supplier::findOrFail($supplier->id);

    }

    public function render()
    {
        return view('livewire.suppliers.mapping');
    }





}
