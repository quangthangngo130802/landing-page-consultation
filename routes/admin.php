<?php

use App\Http\Controllers\Admin\AdviseController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BulkActionController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FunctionsController;
use App\Http\Controllers\Admin\HighlightController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\JourneyController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Http\Controllers\Admin\ZaloOaController;
use App\Http\Controllers\AdvisoriesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\TitleFunctionController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'authenticate'])->name('submitLogin');
    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::resource('configs', ConfigController::class);
        Route::resource('issues', IssueController::class);
        Route::post('issues/update-order', [IssueController::class, 'updateOrder'])->name('issues.updateOrder');
        Route::resource('journey', JourneyController::class);
        Route::resource('advise', AdviseController::class);
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::resource('', PostController::class)
            ->parameters(['' => 'post']);

            // Các route SEO riêng
            Route::post('{id}/seo-analysis', [PostController::class, 'getSeoAnalysis'])->name('seo.analysis');
            Route::post('seo-analysis-live', [PostController::class, 'getSeoAnalysisLive'])->name('seo.analysis.live');
        });
        Route::resource('technologies', TechnologyController::class);
        Route::resource('banners', BannerController::class);

        Route::resource('seo', SeoController::class);
        Route::resource('contacts', ContactController::class);
        Route::resource('prices', PriceController::class);
        Route::resource('reason', WhyChooseUsController::class);
        Route::resource('support', SupportController::class);

        Route::get('advisory', [AdvisoriesController::class, 'index'])->name('advisory.index');

        Route::post('/delete-items', [BulkActionController::class, 'deleteItems'])->name('delete.items');
        Route::post('/title-function', [TitleFunctionController::class, 'update'])->name('update.title');

        Route::prefix('zaloOa')->name('zaloOa.')->group(function () {
            Route::post('update', [ZaloOaController::class, 'updateOa'])->name('update');
            Route::get('template', [ZaloOaController::class, 'template'])->name('template');
            Route::get('detail-template', [ZaloOaController::class, 'detailTemplate'])->name('detail.template');
            Route::get('automation-template', [ZaloOaController::class, 'automationTemplate'])->name('automation.template');
            Route::get('message', [ZaloOaController::class, 'template'])->name('template');
        });

    });
});
Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');


