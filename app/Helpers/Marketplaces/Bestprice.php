<?php

namespace App\Helpers\Marketplaces;

use App\Models\Product;
use PHPHtmlParser\Dom;

class Bestprice
{
    public function scrape(Product $product)
    {
        $html = $product->html;

        $htmlDomParser = new Dom();
        $htmlDomParser->loadStr($html);
        $notFound = $htmlDomParser->find('#page-404');
        if($notFound->count()){
            return null;
        }

        $save = [];

        $save['name'] = $htmlDomParser->find('.item-title')->text;
        $brandDiv = $htmlDomParser->find('div.item-specs-brand__descr', 0);
        if ($brandDiv) {
            $meta = $brandDiv->find('meta[itemprop=name]', 0);
            if ($meta) {
                $save['brand'] = $meta->getAttribute('content'); // π.χ. "Apple"
            }
        }else{
            $save['brand'] = null;
        }

        $save['box_price'] = null;
        $save['mpn'] = null;

        $dlElements = $htmlDomParser->find('dl[itemprop=additionalProperty]');
        if ($dlElements->count()) {
            foreach ($dlElements as $dl) {
                $nameElement = $dl->find('dt[itemprop=name]', 0);
                $valueElement = $dl->find('dd[itemprop=value]', 0);

                if ($nameElement && $valueElement && trim($nameElement->text) !== '' && trim($valueElement->text) !== '') {
                    $data[] = [
                        'name' => trim($nameElement->text),
                        'value' => trim($valueElement->text),
                    ];
                }

            }

            $save['features'] = $data;
        }else{
            $save['features'] = null;
        }

        $save['total_orders'] =  0;

        // Total reviews
        $reviewsNode = $htmlDomParser->find('.simple-rating__total');
        $save['total_reviews'] = $reviewsNode->count() ? preg_replace("/[^0-9]/", "", $reviewsNode->text) : 0;

        // Rating

        $metaRating = $htmlDomParser->find('meta[property=twitter:data2]', 0);
        if ($metaRating) {
            $content = $metaRating->getAttribute('content'); // π.χ. "4.8 αστέρια"

            // Πάρε μόνο τον αριθμό χρησιμοποιώντας regex
            if (preg_match('/[\d.]+/', $content, $matches)) {
                $save['rating'] = $matches[0]; // π.χ. "4.8"
            }
        }else{
            $save['rating'] = null;
        }

        $imageMeta = $htmlDomParser->find('meta[itemprop=image]', 0);
        if ($imageMeta) {
            $save['main_image'] = $imageMeta->getAttribute('content');
        }

        $save['images'] = [];


        $groups = $htmlDomParser->find('div.prices__group');
        if ($groups->count()) {

            foreach ($groups as $group) {
                // Τιμή από το attribute data-price
                $priceCents = $group->getAttribute('data-price'); // π.χ. "188495"
                if (!$priceCents) continue;
                $price = (float)$priceCents / 100; // Μετατροπή σε ευρώ, π.χ. 1884.95

                // Όνομα καταστήματος
                $merchantLink = $group->find('a.prices__merchant-link em', 0);

                if (!$merchantLink) continue;
                $merchant = trim($merchantLink->text);

                $save['prices'][] = [
                    'shopName' => $merchant,
                    'price' => number_format($price, 2, '.', ''),
                ];
            }

        }
        $lowest_price = $htmlDomParser->find('.product-overview__price');
        if ($lowest_price->count()) {

            $s = (float) str_replace([ '.', ',' ], [ '', '.' ], $lowest_price->text);
            $save['lowest_price'] = $s;
        }else{
            $save['lowest_price'] = null;
        }












        return $save;

        // TODO: Βάλε εδώ τον scraping κώδικα για το marketplace
    }
}
