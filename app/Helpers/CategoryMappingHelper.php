<?php
namespace App\Helpers;

use App\Models\Category;
use App\Models\CategoryMapping;

class CategoryMappingHelper
{
    /**
     * Επιστρέφει true αν όλες οι κατηγορίες είναι mapped στο marketplace
     */
    public static function allCategoryMappingsHaveCategories(): bool
    {
        return !CategoryMapping::doesntHave('categories')->exists();
    }

    public static function getMappingsWithoutCategories(): array
    {
        return CategoryMapping::doesntHave('categories')->pluck('id')->toArray();
    }
}
