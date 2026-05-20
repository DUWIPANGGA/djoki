<?php

use App\Http\Controllers\ProviderServiceController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\MessageController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\PortfolioController;
use App\Http\Controllers\Web\PrivacySettingController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\RevisionController;
use App\Http\Controllers\Web\ServiceCategoryController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\PaymentMethodController;
use App\Http\Controllers\Web\LayananController;
use App\Http\Controllers\Web\SocialAuthController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\VerificationDocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = \App\Models\ServiceCategory::where('is_active', true)->get();
    return view('welcome', compact('categories'));
});

Route::get('/policy', function () {
    return view('policy');
})->name('policy');

// Social Auth
Route::get('auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');
Route::post('auth/firebase/google', [SocialAuthController::class, 'handleFirebaseLogin'])->name('auth.firebase.google');

Route::middleware(['auth'])->group(function () {
    // ----------------------------------------------------
    // ALL AUTHENTICATED USERS
    // ----------------------------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('privacy-settings', [PrivacySettingController::class, 'edit'])->name('privacy-settings.edit');
    Route::put('privacy-settings', [PrivacySettingController::class, 'update'])->name('privacy-settings.update');

    // Orders & Messages (Akses dibatasi spesifik di Controller)
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/files', [OrderController::class, 'uploadFile'])->name('orders.files.upload');
    Route::get('orders/{order}/files/{file}/download', [OrderController::class, 'download'])->name('orders.download');
    Route::get('orders/{order}/messages', [MessageController::class, 'index'])->name('orders.messages.index');
    Route::post('orders/{order}/messages', [MessageController::class, 'store'])->name('orders.messages.store');


    // ----------------------------------------------------
    // ADMIN ONLY
    // ----------------------------------------------------
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('service-categories', ServiceCategoryController::class);
        Route::resource('payment-methods', PaymentMethodController::class);
        Route::resource('services', ServiceController::class);
        
        Route::get('finance', [\App\Http\Controllers\Web\FinanceController::class, 'index'])->name('finance.index');
        Route::post('finance/{order}/pay', [\App\Http\Controllers\Web\FinanceController::class, 'pay'])->name('finance.pay');
        Route::post('payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
        
        Route::put('verification-documents/{document}/status', [VerificationDocumentController::class, 'updateStatus'])->name('verification-documents.status');
    });


    // ----------------------------------------------------
    // PROVIDER ONLY
    // ----------------------------------------------------
    Route::middleware(['role:provider'])->group(function () {
        Route::resource('provider-services', ProviderServiceController::class);
        Route::resource('portfolios', PortfolioController::class);
        
        Route::get('provider/finance', [\App\Http\Controllers\Web\FinanceController::class, 'providerIndex'])->name('provider.finance.index');
        Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
        Route::put('revisions/{revision}', [RevisionController::class, 'update'])->name('revisions.update');
    });


    // ----------------------------------------------------
    // CLIENT ONLY
    // ----------------------------------------------------
    Route::middleware(['role:client'])->group(function () {
        Route::get('layanan', [LayananController::class, 'index'])->name('layanan.index');
        Route::post('orders/{order}/review', [ReviewController::class, 'store'])->name('reviews.store');
        Route::post('orders/{order}/revisions', [RevisionController::class, 'store'])->name('orders.revisions.store');
        Route::post('orders/{order}/payments', [PaymentController::class, 'store'])->name('payments.store');
    });


    // ----------------------------------------------------
    // ADMIN & PROVIDER
    // ----------------------------------------------------
    Route::middleware(['role:admin,provider'])->group(function () {
        Route::resource('verification-documents', VerificationDocumentController::class)->except(['updateStatus']);
    });
});

// Auth routes
require __DIR__.'/auth.php';
