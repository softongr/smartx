<?php

namespace App\Livewire\Marketplaces;

use App\Models\Marketplace;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
class Form extends Component
{

    public $id;
    public $name;
    public $url_pattern;
    public $has_commission=false;
    public $commission=0;
    public $isEdit=false;
    public $minimum_profit_margin=0;
    public  $object;


    public function mount($marketplace=null)
    {
        if($marketplace){
            $this->object                   = Marketplace::findOrFail($marketplace);
            $this->id                      = $this->object->id;
            $this->name                    = $this->object->name;
            $this->url_pattern                    = $this->object->url_pattern;
            $this->has_commission                  = $this->object->has_commission;
            $this->commission                      = $this->object->commission;
            $this->minimum_profit_margin                  = $this->object->minimum_profit_margin;
            $this->isEdit                  = true;
        }

    }

    public function render()
    {
        return view('livewire.marketplaces.form');
    }

    public function save()
    {
        $rules = [
            'name'          => 'required',
            'url_pattern'        => 'required|url',
        ];

        if ($this->has_commission) {
            $rules['commission'] = 'required|numeric|between:1,999.99';
            $rules['minimum_profit_margin'] = 'required|numeric|between:1,999.99';
        } else {
            $this->has_commission = 0;
        }


        $this->validate($rules);
        $class = $this->createHelperClass($this->name);


        $fields = [
            'name'          => $this->name,
            'url_pattern'         => $this->url_pattern,
            'class'  => $class,
            'commission'   => $this->commission,
            'has_commission'   => $this->has_commission,
            'minimum_profit_margin'  => $this->minimum_profit_margin,
        ];


        if ($this->isEdit) {
            $item = Marketplace::findOrFail($this->id);
            $item->fill($fields);
            $item->save();




        }else{
            $item = Marketplace::updateOrCreate($fields);
        }

        $this->id = $item->id;
        Cache::forget('marketplaces_total_count');

        session()->flash('success', $this->isEdit ? __('Updated') : __('Saved'));
        $this->dispatch('refreshMarketplaces');

        return redirect()->route('marketplace.edit', ['marketplace' => $item->id]);

    }

    public function createHelperClass($name)
    {
        $className = ucfirst(Str::camel($name));
        $namespace = "App\\Helpers\\Marketplaces\\{$className}";
        $directory = app_path('Helpers/Marketplaces');
        $filePath = $directory . "/{$className}.php";

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (!File::exists($filePath)) {
            File::put($filePath, $this->getTemplate($className));
        }

        return $namespace;
    }


    private function getTemplate($className)
    {
        return <<<PHP
<?php

namespace App\Helpers\Marketplaces;
use PHPHtmlParser\Dom;
use App\Models\Product;

class {$className}
{
    public function scrape(Product \$product)
    {
        \$html = \$product->html;
        \$htmlDomParser = new Dom();
        \$htmlDomParser->loadStr(\$html);
    }
}
PHP;
    }


    public function toggleHasCommission()
    {
        $this->has_commission    = $this->has_commission;

    }
}
