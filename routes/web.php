<?php

use Illuminate\Support\Facades\Route;

// ===== Frontend Controllers =====
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController as FrontPageController;
use App\Http\Controllers\Frontend\PortfolioController as FrontPortfolioController;
use App\Http\Controllers\Frontend\ContactController as FrontContactController;

// ===== Admin Controllers =====
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\PortfolioItemController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\AuthController;

// ------------------------------
// Public Routes
// ------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pages statis via DB (slug)
Route::get('/visi-misi', [FrontPageController::class, 'show'])
    ->name('pages.visimisi')->defaults('slug', 'visi-misi');
Route::get('/services', [FrontPageController::class, 'show'])
    ->name('pages.services')->defaults('slug', 'services');

// Portfolio (Buku Terbit)
Route::get('/buku-terbit', [FrontPortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/buku-terbit/{portfolio}', [FrontPortfolioController::class, 'show'])
    ->whereNumber('portfolio')->name('portfolio.show');

// Contact
Route::get('/contact', [FrontContactController::class, 'index'])->name('contact.index');

// ------------------------------
// Admin Routes (auth protected)
// ------------------------------

// Auth (manual)
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
         ->middleware('throttle:10,1') // 10 percobaan/menit
         ->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Pages (tanpa show)
    Route::resource('pages', PageController::class)->except(['show'])->parameters(['pages' => 'page:id']);

    // Nested: Sections di dalam Page
    Route::prefix('pages/{page:id}')->name('pages.')->group(function () {
        Route::resource('sections', SectionController::class)->except(['show'])->parameters(['sections' => 'section:id']);
        // AJAX: reorder & toggle
        Route::post('sections/reorder', [SectionController::class, 'reorder'])->name('sections.reorder');
        Route::post('sections/{section}/toggle', [SectionController::class, 'toggleVisibility'])->name('sections.toggle');
    });

    // Portfolio Items (tanpa show)
    Route::resource('portfolio', PortfolioItemController::class)->parameters(['portfolio' => 'portfolio'])->except(['show']);
    Route::post('portfolio/reorder', [PortfolioItemController::class, 'reorder'])->name('portfolio.reorder');
    Route::post('portfolio/{portfolio}/toggle-featured', [PortfolioItemController::class, 'toggleFeatured'])->name('portfolio.toggleFeatured');
    Route::post('portfolio/{portfolio}/toggle-visible', [PortfolioItemController::class, 'toggleVisibility'])->name('portfolio.toggleVisible');

    // Testimonials (tanpa show)
    Route::resource('testimonials', TestimonialController::class)->except(['show']);
    Route::post('testimonials/reorder', [TestimonialController::class, 'reorder'])->name('testimonials.reorder');
    Route::post('testimonials/{testimonial}/toggle-visible', [TestimonialController::class, 'toggleVisibility'])->name('testimonials.toggleVisible');

    // FAQs (tanpa show)
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::post('faqs/reorder', [FaqController::class, 'reorder'])->name('faqs.reorder');
    Route::post('faqs/{faq}/toggle-visible', [FaqController::class, 'toggleVisibility'])->name('faqs.toggleVisible');

    // Site Settings
    Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::get('settings/{key}/edit', [SiteSettingController::class, 'edit'])
        ->where('key', '[A-Za-z0-9_.-]+')->name('settings.edit');
    Route::match(['put','patch'], 'settings/{key}', [SiteSettingController::class, 'update'])
        ->where('key', '[A-Za-z0-9_.-]+')->name('settings.update');
    Route::post('settings', [SiteSettingController::class, 'updateMany'])->name('settings.updateMany');
});

// ------------------------------
// (Opsional) Auth routes
// ------------------------------
// Jika pakai Breeze/Fortify, letakkan require di sini.
// require __DIR__.'/auth.php';
