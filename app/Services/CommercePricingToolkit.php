<?php

namespace App\Services;

class CommercePricingToolkit
{
    /**
     * Υπολογισμός Τιμής Ασφαλείας (Safe Price)
     * Η ελάχιστη τιμή πώλησης (με ΦΠΑ) ώστε να μη μπει μέσα ο έμπορος.
     *
     * Τύπος:
     * S = ( X / (1 - Π) ) * (1 + V)
     *
     * @param float $wholesalePrice Τιμή χονδρικής χωρίς ΦΠΑ (X)
     * @param float $marketplaceCommission Προμήθεια marketplace σε % ή δεκαδικό (π.χ. 13 ή 0.13)
     * @param float $vat ΦΠΑ σε % ή δεκαδικό (π.χ. 24 ή 0.24)
     * @return float Τελική τιμή πώλησης με ΦΠΑ
     */
    public static function calculateSafePrice(float $wholesalePrice, float $marketplaceCommission, float $vat): float
    {
        $marketplaceCommission = self::normalizePercentage($marketplaceCommission);
        $vat = self::normalizePercentage($vat);

        if ($marketplaceCommission >= 1 || $vat >= 1) {
            throw new \InvalidArgumentException("Invalid percentages after normalization.");
        }

        $safePrice = ($wholesalePrice / (1 - $marketplaceCommission)) * (1 + $vat);

        return round($safePrice, 2);
    }

    /**
     * Υπολογισμός Τιμής Στόχου (Target Price)
     * Η τιμή πώλησης που εξασφαλίζει M% καθαρό κέρδος μετά φόρου εισοδήματος Φ.
     *
     * Τύπος:
     * Sστόχος = S * (1 + M / (1 - Φ))
     *
     * @param float $wholesalePrice Τιμή χονδρικής χωρίς ΦΠΑ (X)
     * @param float $desiredNetProfitRate Επιθυμητό καθαρό ποσοστό κέρδους (π.χ. 30 ή 0.30)
     * @param float $marketplaceCommission Προμήθεια marketplace (π.χ. 13 ή 0.13)
     * @param float $vat ΦΠΑ (π.χ. 24 ή 0.24)
     * @param float $incomeTax Φόρος εισοδήματος (π.χ. 20 ή 0.20)
     * @return float Τιμή στόχος με ΦΠΑ
     */
    public static function calculateTargetPrice(
        float $wholesalePrice,
        float $desiredNetProfitRate,
        float $marketplaceCommission,
        float $vat,
        float $incomeTax
    ): float {
        // Κανονικοποίηση ποσοστών
        $desiredNetProfitRate   = self::normalizePercentage($desiredNetProfitRate);
        $marketplaceCommission  = self::normalizePercentage($marketplaceCommission);
        $vat                    = self::normalizePercentage($vat);
        $incomeTax              = self::normalizePercentage($incomeTax);

        // Έλεγχοι
        if ($marketplaceCommission >= 1 || $vat >= 1 || $incomeTax >= 1) {
            throw new \InvalidArgumentException("Invalid percentages after normalization.");
        }

        // Καθαρό κέρδος μετά φόρου
        $netProfitAfterTax = ($desiredNetProfitRate * $wholesalePrice) / (1 - $incomeTax);

        // Καθαρή τιμή πριν ΦΠΑ και προμήθεια
        $baseNet = $wholesalePrice + $netProfitAfterTax;

        // Προμήθεια και ΦΠΑ
        $targetPrice = ($baseNet / (1 - $marketplaceCommission)) * (1 + $vat);

        return round($targetPrice, 2);
    }

    /**
     * Βοηθητική μέθοδος: μετατρέπει ακέραιο ποσοστό (π.χ. 24) σε δεκαδικό (0.24)
     */
    protected static function normalizePercentage(float $value): float
    {
        return $value > 1 ? $value / 100 : $value;
    }

    public static function comparePricesAgainstMine(float $targetPrice, array $prices)

    {
        $bestPrice = null;
        $myPrice = $targetPrice;

        foreach ($prices as $priceData) {
            // Εξασφαλίζουμε ότι η τιμή είναι αριθμός (μετατροπή σε float)
            $shopPrice = (float) $priceData['price'];
            if (!is_numeric($shopPrice) || !is_numeric($myPrice)) {
                continue;  // Αν η τιμή δεν είναι αριθμός, παραλείπουμε αυτή τη σύγκριση
            }

            // Υπολογισμός ποσοστού κέρδους
            $profitMargin = ($shopPrice - $myPrice) / $myPrice * 100;

            // Ελέγχουμε αν το ποσοστό κέρδους είναι μεγαλύτερο ή ίσο από το επιθυμητό
            if ($profitMargin >= 0) {
                // Αν η τιμή του καταστήματος είναι καλύτερη (χαμηλότερη) από τη δική μου, την επιλέγουμε
                if ($bestPrice === null || $shopPrice < $bestPrice) {
                    $bestPrice = $shopPrice;
                }
            }
        }

        // Επιστρέφουμε την καλύτερη τιμή που μπορούμε να επιτύχουμε με το επιθυμητό ποσοστό κέρδους
        return $bestPrice ?? $myPrice; // Αν δεν βρούμε καλύτερη τιμή, επιστρέφουμε τη δική μας τιμή στόχο
    }




    public  static function findBestPriceWithMinProfit(float $targetPrice, array $prices, float $minProfitRate = 20, float $adjustment = 0.10)
    {
        $bestPrice = null;
        $myPrice = $targetPrice; // Η τρέχουσα τιμή του προϊόντος
        $bestShop = null;
        $bestProfitMargin = null; // Αποθήκευση του ποσοστού κέρδους
        $bestPriceBeforeAdjustment = null; // Αποθήκευση της αρχικής καλύτερης τιμής (πριν την προσαρμογή)

        foreach ($prices as $priceData) {
            $shopPrice = (float) $priceData['price'];

            $profitMargin = ($shopPrice - $myPrice) / $myPrice * 100;

            if ($profitMargin >= $minProfitRate) {
                if ($bestPrice === null || $shopPrice < $bestPrice) {
                    $bestPrice = $shopPrice;
                    $bestShop = $priceData['shopName']; // Αποθήκευση του καταστήματος με την καλύτερη τιμή
                    $bestProfitMargin = $profitMargin; // Αποθήκευση του ποσοστού κέρδους
                    $bestPriceBeforeAdjustment = $shopPrice; // Αποθήκευση της αρχικής καλύτερης τιμής
                }
            }
        }

        // Αν δεν βρέθηκε κατάστημα με επαρκές ποσοστό κέρδους, επιστρέφουμε το πρώτο κατάστημα που βρήκαμε
        if ($bestPrice === null) {
            $bestPrice = $prices[0]['price'];
            $bestShop = $prices[0]['shopName'];
            $bestProfitMargin = 0; // Αν δεν βρούμε τίποτα, το ποσοστό κέρδους είναι 0
        }

        // Εφαρμόζουμε την προσαρμογή της τιμής (μείωση κατά 0.10 ευρώ)
        $adjustedPrice = $bestPriceBeforeAdjustment - $adjustment;

        // Υπολογισμός ποσοστού κέρδους για την προσαρμοσμένη τιμή
        $adjustedProfitMargin = ($adjustedPrice - $myPrice) / $myPrice * 100;

        // Αν το ποσοστό κέρδους της προσαρμοσμένης τιμής παραμένει πάνω από το ελάχιστο ποσοστό κέρδους, την επιστρέφουμε
        if ($adjustedProfitMargin >= $minProfitRate) {
            $bestPrice = $adjustedPrice;
            $bestProfitMargin = $adjustedProfitMargin; // Ενημέρωση με το νέο ποσοστό κέρδους
        }

        return [
            'bestPrice' => $bestPrice,
            'bestShop' => $bestShop,
            'bestProfitMargin' => $bestProfitMargin,
        ];
    }

    public static function findPricePositionAndSuggest(
        float $targetPrice,
        array $prices,
        float $undercutAmount = 0.10
    ): ?array {
        // Καθαρίζουμε και φιλτράρουμε τις τιμές
        $cleanedPrices = [];

        foreach ($prices as $entry) {
            if (!isset($entry['price'])) continue;

            // Καθαρισμός τιμής από σύμβολα και κόμμα → τελεία
            $cleanPrice = preg_replace('/[^\d.,]/', '', $entry['price']);
            $cleanPrice = str_replace(',', '.', $cleanPrice);
            $competitorPrice = floatval($cleanPrice);

            if (!is_numeric($competitorPrice) || $competitorPrice <= 0) continue;

            $cleanedPrices[] = [
                'shopName' => $entry['shopName'] ?? 'Unknown',
                'price'    => $competitorPrice
            ];
        }

        // Αν δεν υπάρχουν έγκυρες τιμές
        if (empty($cleanedPrices)) {
            return null;
        }

        // Ταξινόμηση αύξουσα
        usort($cleanedPrices, fn($a, $b) => $a['price'] <=> $b['price']);

        foreach ($cleanedPrices as $index => $entry) {
            if ($entry['price'] > $targetPrice) {
                return [
                    'position'        => $index + 1,
                    'aboveShop'       => $entry['shopName'],
                    'abovePrice'      => $entry['price'],
                    'suggestedPrice'  => round($entry['price'] - $undercutAmount, 2)
                ];
            }
        }

        // Αν η τιμή μας είναι η υψηλότερη
        $last = end($cleanedPrices);

        return [
            'position'        => count($cleanedPrices) + 1,
            'aboveShop'       => $last['shopName'],
            'abovePrice'      => $last['price'],
            'suggestedPrice'  => round($last['price'] + 0.10, 2) // πάνω από τον τελευταίο
        ];
    }

    public static function executePricing(float $wholesalePrice, float $marketplaceCommission, float $vat, float $incomeTax, float $desiredNetProfitRate, array $prices, $minProfitPrice=40)
    {

        $targetPrice = self::calculateTargetPrice($wholesalePrice, $desiredNetProfitRate, $marketplaceCommission, $vat, $incomeTax);
        return self::findBestPriceWithMinProfit($targetPrice, $prices, $minProfitPrice);
    }


    public static function executeDynamicPricing(
        float $wholesalePrice,
        float $marketplaceCommission,
        float $vat,
        float $incomeTax,
        float $minProfitRate,
        array $prices,
        float $adjustment = 0.10
    ): array {
        $minProfitRate = self::normalizePercentage($minProfitRate);
        $marketplaceCommission = self::normalizePercentage($marketplaceCommission);
        $vat = self::normalizePercentage($vat);
        $incomeTax = self::normalizePercentage($incomeTax);

        $safePrice = self::calculateSafePrice($wholesalePrice, $marketplaceCommission, $vat);

        $minNetProfit = ($minProfitRate * $wholesalePrice) / (1 - $incomeTax);
        $baseNet = $wholesalePrice + $minNetProfit;
        $minAcceptablePrice = ($baseNet / (1 - $marketplaceCommission)) * (1 + $vat);

        $cleaned = [];
        foreach ($prices as $entry) {
            $price = isset($entry['price']) ? floatval(str_replace(',', '.', preg_replace('/[^\d.,]/', '', $entry['price']))) : null;
            if (is_numeric($price) && $price > 0) {
                $cleaned[] = [
                    'price' => $price,
                    'shopName' => $entry['shopName'] ?? 'Unknown'
                ];
            }
        }

        usort($cleaned, fn($a, $b) => $a['price'] <=> $b['price']);

        foreach ($cleaned as $index => $competitor) {
            $competitorPrice = $competitor['price'];
            $shop = $competitor['shopName'];

            $suggestedPrice = round($competitorPrice - $adjustment, 2);

            $netIncomeBeforeTax = $suggestedPrice / (1 + $vat) * (1 - $marketplaceCommission);
            $grossProfit = $netIncomeBeforeTax - $wholesalePrice;
            $netProfit = $grossProfit * (1 - $incomeTax);
            $actualProfitRate = $netProfit / $wholesalePrice;

            if ($actualProfitRate >= $minProfitRate) {
                return [
                    'finalPrice' => $suggestedPrice,
                    'position' => $index + 1,
                    'aboveShop' => $shop,
                    'abovePrice' => $competitorPrice,
                    'expectedNetProfitPercent' => round($actualProfitRate * 100, 2),
                    'strategy' => 'undercut_competitor'
                ];
            }
        }

        $last = end($cleaned);

        return [
            'finalPrice' => round($minAcceptablePrice, 2),
            'position' => count($cleaned) + 1,
            'aboveShop' => $last['shopName'] ?? null,
            'abovePrice' => $last['price'] ?? null,
            'expectedNetProfitPercent' => round($minProfitRate * 100, 2),
            'strategy' => 'fallback_min_profit'
        ];
    }



}
