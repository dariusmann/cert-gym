<?php

use App\Http\Controllers\Docs\PageDocsController;
use App\Http\Controllers\Pages\DashboardController;
use App\Http\Controllers\Pages\Run\ListRunsPageController;
use App\Http\Controllers\Pages\Run\RunExamPageController;
use App\Http\Controllers\Pages\Run\RunPageController;
use App\Http\Controllers\Pages\Run\CreateCategoryRunPageController;
use App\Http\Controllers\Pages\Run\RunRandomPageController;
use App\Http\Controllers\Pages\Run\RunResultPage;
use App\Http\Controllers\Pages\Tracking\TrackingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Questions\Answer\ReadQuestionAttemptAnswerController;
use App\Http\Controllers\Questions\Attempt\CreateQuestionRunAttemptController;
use App\Http\Controllers\Questions\Attempt\CreateQuestionRunExamAttemptController;
use App\Http\Controllers\Questions\Exam\CommitRunExamController;
use App\Http\Controllers\Questions\Exam\ExamStatusController;
use App\Http\Controllers\Questions\Flag\CreateRunQuestionExamFlagController;
use App\Http\Controllers\Questions\ReadQuestionController;
use App\Http\Controllers\Questions\Run\CreateCategoryRunController;
use App\Http\Controllers\Questions\Run\CreateRandomRunController;
use App\Http\Controllers\Questions\Run\CreateExamRunController;
use App\Http\Controllers\Questions\Run\ReadQuestionRunExamController;
use App\Http\Controllers\Tracking\ReadTrackingAccuracyController;
use App\Http\Controllers\Tracking\ReadTrackingOverviewController;
use App\Http\Controllers\Tracking\ReadReadinessScoreController;
use App\Http\Controllers\Questions\Run\ReadUserQuestionRunsController;
use App\Http\Controllers\Tracking\ReadTrackingCategoriesAccuracyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware(['auth', 'verified', 'subscribedCheckout'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/page/run/{runId}/practice', RunPageController::class)->name('page.run.practice');
    Route::get('/page/run/{runId}/exam/practice', RunExamPageController::class)
        ->whereNumber('runId')
        ->name('page.run.exam.practice');
    Route::get('/page/run/{runId}/random/practice', RunRandomPageController::class)->name('page.run.random.practice');
    Route::get('/page/run/category', CreateCategoryRunPageController::class)->name('page.run.category.create');
    Route::get('/page/run/list', ListRunsPageController::class)->name('page.question.run.list');
    Route::get('/page/run/result/{runId}', RunResultPage::class)->name('page.run.result');
    Route::get('/page/tracking', TrackingPageController::class)->name('page.tracking');

    Route::get('/docs', PageDocsController::class)->name('page.docs');

    Route::get('/page/tracking', TrackingPageController::class)->name('page.tracking');
    Route::get('/page/tracking', TrackingPageController::class)->name('page.tracking');

    Route::get('/api/question/{questionId}', ReadQuestionController::class)->name('api.question.read');
    Route::post('/api/question/run/attempt', CreateQuestionRunAttemptController::class)->name('api.question.run.attempt.create');
    Route::post('/api/question/run/exam/attempt', CreateQuestionRunExamAttemptController::class)->name('api.question.run.exam.create');
    Route::post('/api/question/run/exam/flag', CreateRunQuestionExamFlagController::class)->name('api.question.run.exam.flag.create');
    Route::post('/api/question/run/exam/commit', CommitRunExamController::class)->name('api.question.run.exam.commit');

    Route::get('/api/question/attempt/{attemptId}/answers', ReadQuestionAttemptAnswerController::class)->name('api.question.attempt.answers.read');
    Route::post('/api/question/run/category', CreateCategoryRunController::class)->name('api.question.run.category.create');
    Route::get('/api/question/run/random', [CreateRandomRunController::class, 'readRandom'])->name('api.question.random.read');
    Route::post('/api/question/run/exam', CreateExamRunController::class)->name('api.question.run.exam.create');
    Route::get('/api/user/question/run', ReadUserQuestionRunsController::class)->name('api.user.question.run');
    Route::get('/api/question/run/exam/{runId}', ReadQuestionRunExamController::class)->name('api.question.run.exam');
    Route::get('/api/tracking/accuracy', ReadTrackingAccuracyController::class)->name('api.tracking.accuracy.read');
    Route::get('/api/tracking/categories/accuracy', ReadTrackingCategoriesAccuracyController::class)->name('api.tracking.categories.accuracy.read');
    Route::get('/api/tracking/overview', ReadTrackingOverviewController::class)->name('api.tracking.overview.read');
    Route::get('/api/tracking/readinessscore', ReadReadinessScoreController::class)->name('api.tracking.readinessscore.read');
    Route::get('/api/exam/status', ExamStatusController::class)->name('api.exam.status');
});

require __DIR__ . '/auth.php';
