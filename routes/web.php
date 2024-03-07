<?php

use App\Http\Controllers\Pages\Run\RunPageController;
use App\Http\Controllers\Pages\Run\CreateCategoryRunPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Questions\CreateQuestionRunAttemptController;
use App\Http\Controllers\Questions\ReadQuestionAttemptAnswerController;
use App\Http\Controllers\Questions\ReadQuestionController;
use App\Http\Controllers\Questions\Run\CreateCategoryRunController;
use App\Http\Controllers\Questions\RunController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'subscribedCheckout'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/page/run/{runId}/practice', RunPageController::class)->name('page.run.practice');
    Route::get('/page/run/category', CreateCategoryRunPageController::class)->name('page.run.category');
});

Route::middleware('auth')->group(function () {
    Route::get('/api/question/{questionId}', ReadQuestionController::class)->name('api.question.read');
    Route::post('/api/question/run/attempt', CreateQuestionRunAttemptController::class)->name('api.question.run.attempt.create');
    Route::get('/api/question/attempt/{attemptId}/answers', ReadQuestionAttemptAnswerController::class)->name('api.question.attempt.answers.read');
    Route::post('/api/question/run/category', CreateCategoryRunController::class)->name('api.question.run.category.create');
    Route::get('/api/question/run/random', [RunController::class, 'readRandom'])->name('api.question.random.read');
});

require __DIR__ . '/auth.php';
