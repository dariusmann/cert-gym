<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Run;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CreateCategoryRunPageController
{
    public function __invoke(Request $request): Response
    {
        /** @var Category $rootTaskListCategory */
        $rootTaskListCategory = Category::where('short_code', 'tl-root')->first();

        $childCategories = self::withAllChildren($rootTaskListCategory->getId());

        return Inertia::render('Run/Create/CategoryRun', [
            'categories' => $childCategories
        ]);
    }

    public static function withAllChildren($parentId = null)
    {
        $categories = collect();

        $levelCategories = Category::where('parent_id', $parentId)->get();

        foreach ($levelCategories as $category) {
            $category->children = self::withAllChildren($category->id);
            $categories->push($category);
        }

        return $categories;
    }
}
