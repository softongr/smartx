<?php

namespace App\Helpers\Marketplaces;
use PHPHtmlParser\Dom;
use App\Models\Product;

class Gizmos
{
    public function scrape(Product $product)
    {
        $html = $product->html;
        $htmlDomParser = new Dom();
        $htmlDomParser->loadStr($html);
    }
}