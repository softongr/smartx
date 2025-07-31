<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | This determines the default currency used when no currency is explicitly set.
    |
    */

    'default_currency' => 'EUR',

    /*
    |--------------------------------------------------------------------------
    | Locale for Formatting
    |--------------------------------------------------------------------------
    |
    | This defines the default locale used for currency formatting.
    | Examples: 'el_GR', 'en_US', 'de_DE'
    |
    */

    'locale' => 'el_GR',

    /*
    |--------------------------------------------------------------------------
    | Convert to Cents
    |--------------------------------------------------------------------------
    |
    | If true, all monetary values will be assumed to be in cents.
    | If false, values are treated as full currency units (e.g. 1.00 = €1.00).
    |
    */

    'convert_to_cents' => false,

    /*
    |--------------------------------------------------------------------------
    | Currency Symbol Position
    |--------------------------------------------------------------------------
    |
    | Position of the currency symbol: 'before' or 'after'
    |
    */

    'symbol_position' => 'after',

    /*
    |--------------------------------------------------------------------------
    | Thousands & Decimal Separator
    |--------------------------------------------------------------------------
    |
    | These define how numbers are formatted for display.
    |
    */

    'thousands_separator' => '.',
    'decimal_separator'   => ',',

];
