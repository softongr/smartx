<?php

namespace App;



enum ProductStep: int
{
    case Scrape = 1;
    case Parse = 2;
    case OpenAI = 3;
    case Pricing = 4;

    case Shop = 5;     // Μετακινήθηκε στο 5 για να διατηρηθεί η σειρά
    case Completed = 6;     // Μετακινήθηκε στο 5 για να διατηρηθεί η σειρά


    public function label(): string
    {
        return match ($this) {
            self::Scrape => 'scraping',
            self::Parse => 'parsing',
            self::Pricing => 'pricing',
            self::OpenAI => 'openai',
            self::Shop => 'shop',
            self::Completed => 'completed',
        };
    }
}
