<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QuestionAttempt;
use App\Models\User;
use App\ReadModels\CountAttemptByAnsweredCorrectAndCategoryIds;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadTrackingCategoriesAccuracyController extends Controller
{
    private CountAttemptByAnsweredCorrectAndCategoryIds $countAttemptByAnsweredCorrectAndCategoryIds;

    public function __construct(
        CountAttemptByAnsweredCorrectAndCategoryIds $countAttemptByAnsweredCorrectAndCategoryIds
    )
    {
        $this->countAttemptByAnsweredCorrectAndCategoryIds = $countAttemptByAnsweredCorrectAndCategoryIds;
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $taskListCategories = $this->getTaskListCategories();

        $accuracyRate = [];

        foreach ($taskListCategories as $taskListCategory) {
            $subCategoriesIds = $this->getSubTaskListCategories($taskListCategory);

            $wrongAttempts = $this->countAttemptByAnsweredCorrectAndCategoryIds->count(
                false, $subCategoriesIds, $user->getId()
            );
            $rightAttempts = $this->countAttemptByAnsweredCorrectAndCategoryIds->count(
                true, $subCategoriesIds, $user->getId()
            );

            if ($rightAttempts === 0) {
                $accuracyRate[] = 0;
            } else {
                $accuracyRate[] = round($rightAttempts / ($rightAttempts + $wrongAttempts) * 100);
            }
        }

        return new JsonResponse([
            'accuracy_rate' => $accuracyRate,
            'category_labels' => $this->resolveCategoriesLabels($taskListCategories)
        ]);
    }

    public function resolveCategoriesLabels(Collection $categories): array
    {
        $labels = [];

        /** @var Category $category */
        foreach ($categories as $category) {
            $labels[] = $category->getName();
        }

        return $labels;
    }

    private function getTaskListCategories(): Collection
    {
        /** @var Category $rootCategory */
        $rootCategory = Category::where('short_code', 'tl-root')->first();

        return Category::where('parent_id', $rootCategory->getId())->get();
    }

    private function getSubTaskListCategories(Category $category): array
    {
        return Category::where('parent_id', $category->getId())->pluck('id')->toArray();
    }
}
