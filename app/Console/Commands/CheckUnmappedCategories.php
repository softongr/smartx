<?php

namespace App\Console\Commands;

use App\Helpers\CategoryMappingHelper;
use App\Mail\UnmappedCategoryMappingsFound;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckUnmappedCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:check-unmapped';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there are new categories without marketplace mapping';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!CategoryMappingHelper::allCategoryMappingsHaveCategories()) {
            $ids = CategoryMappingHelper::getMappingsWithoutCategories();
            $email  =  Setting::get('email_notification');
            Mail::to($email)->send(
                new UnmappedCategoryMappingsFound($ids)
            );

        }

    }
}
