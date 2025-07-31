<?php

namespace App\Helpers\Marketplaces;
use App\Models\Product;

use PHPHtmlParser\Dom;
use function Symfony\Component\String\b;

class Skroutz
{
    public function scrape(Product $product): ?array
    {




        $html = $product->html;

        $htmlDomParser = new Dom();
        $htmlDomParser->loadStr($html);
        $notFound = $htmlDomParser->find('.error-404');

        if ($notFound->count()) {

            return null;
        }

        $save = [];



            // Όνομα
        $save['name'] = $htmlDomParser->find('.page-title')->text ?? null;
        if (preg_match('/SKR\.page\.brand\s*=\s*"([^"]+)"/', $html, $matches)) {
            $brand = $matches[1];
            $save['brand'] = $brand;
        }else{
            $save['brand'] = null;
        }


        $save['category'] = $htmlDomParser->find('.category-tag')->text ?? null;



        // Τιμή
        $priceNode = $htmlDomParser->find('.dominant-price')[0] ?? null;


        if ($priceNode) {
            $cleanText = strip_tags($priceNode->innerHtml());

            preg_match('/[0-9.]+,[0-9]+/', $cleanText, $matches);



            if (!empty($matches[0])) {
                $priceFloat = (float) str_replace([ '.', ',' ], [ '', '.' ], $matches[0]);
                $save['box_price'] = $priceFloat;
            }
        }

        // MPN
        $mpn = $htmlDomParser->find('meta[itemProp="mpn"]');
        $save['mpn'] = $mpn->count() ? $mpn->getAttribute('content') : null;

        // Χαρακτηριστικά
        $features = $htmlDomParser->find('.spec-details dl');
        $data = [];
        foreach ($features as $feature) {
            if ($feature->find("dt")->count() && $feature->find("dd")->count()) {
                if ($feature->find('dd')->innerHtml() != '-') {
                    $data[] = [
                        'name' => $feature->find("dt")->text,
                        'value' => htmlspecialchars_decode(strip_tags($feature->find('dd')->innerHtml()))
                    ];
                }
            }
        }
        $save['features'] = $data;

        // Total orders
        $ordersNode = $htmlDomParser->find('.promo-card p strong');
        $save['total_orders'] = $ordersNode->count() ? trim($ordersNode->text) : 0;

        // Total reviews
        $reviewsNode = $htmlDomParser->find('.sku-reviews a span');
        $save['total_reviews'] = $reviewsNode->count() ? preg_replace("/[^0-9]/", "", $reviewsNode->text) : 0;



        // Rating
        $ratingNode = $htmlDomParser->find('.rating-average b');
        $save['rating'] = $ratingNode->count() ? $ratingNode->text : null;



        // Εικόνες
        preg_match('/<script[^>]+id="image-gallery-schema"[^>]*>(.*?)<\/script>/is', $html, $matches);
        $jsonRaw = $matches[1] ?? null;
        if ($jsonRaw) {
            $json = json_decode($jsonRaw, true);
            $save['main_image'] = $json['primaryImageOfPage']['contentUrl'] ?? null;
            $save['images'] = collect($json['associatedMedia'] ?? [])->pluck('contentUrl')->filter()->toArray();
        }

        // Shops
        $save['prices'] = [];
        $cards = $htmlDomParser->find('li.card.js-product-card');
        foreach ($cards as $card) {
            $price = str_replace('€', '', $card->find('div.price strong.dominant-price')->text ?? '');
            $shopHref = $card->find('a.shop-products', 0)?->getAttribute('href') ?? '';
            $shopName = '';
            if (preg_match('#/shop/\d+/(.*?)/#', $shopHref, $matches)) {
                $shopName = urldecode($matches[1]);
            }

            if ($price && $shopName) {
                $save['prices'][] = [
                    'price' => $price,
                    'shopName' => $shopName,
                ];
            }
        }

        $metaTag = $htmlDomParser->find('meta[name="twitter:data1"]');
        if ($metaTag->count()) {
            $price = $metaTag->getAttribute('content');
            $s = (float) str_replace([ '.', ',' ], [ '', '.' ], $price);
            $save['lowest_price'] = $s;
        }else{
            $save['lowest_price'] = null;
        }



        return $save;
    }
}
