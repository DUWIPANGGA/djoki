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
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management (Admin Only)
    Route::resource('users', UserController::class);

    // Service Categories
    Route::resource('service-categories', ServiceCategoryController::class);

    // Payment Methods (Master Data)
    Route::resource('payment-methods', PaymentMethodController::class);

    // Services
    Route::resource('services', ServiceController::class);

    // Provider Services
    Route::resource('provider-services', ProviderServiceController::class);

    // Client Services Listing
    Route::get('layanan', [LayananController::class, 'index'])->name('layanan.index');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/files', [OrderController::class, 'uploadFile'])->name('orders.files.upload');
    Route::get('orders/{order}/files/{file}/download', [OrderController::class, 'download'])->name('orders.download');

    // Messages
    Route::get('orders/{order}/messages', [MessageController::class, 'index'])->name('orders.messages.index');
    Route::post('orders/{order}/messages', [MessageController::class, 'store'])->name('orders.messages.store');

    // Reviews
    Route::post('orders/{order}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');

    // Revisions
    Route::resource('revisions', RevisionController::class)->only(['store', 'update']);

    // Portfolios
    Route::resource('portfolios', PortfolioController::class);

    // Payments
    Route::post('orders/{order}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');

    // Verification Documents
    Route::resource('verification-documents', VerificationDocumentController::class);
    Route::put('verification-documents/{document}/status', [VerificationDocumentController::class, 'updateStatus'])->name('verification-documents.status');

    // Privacy Settings
    Route::get('privacy-settings', [PrivacySettingController::class, 'edit'])->name('privacy-settings.edit');
    Route::put('privacy-settings', [PrivacySettingController::class, 'update'])->name('privacy-settings.update');

    // Finance (Admin Only)
    Route::get('finance', [\App\Http\Controllers\Web\FinanceController::class, 'index'])->name('finance.index');
    Route::post('finance/{order}/pay', [\App\Http\Controllers\Web\FinanceController::class, 'pay'])->name('finance.pay');

    // Finance (Provider Only)
    Route::get('provider/finance', [\App\Http\Controllers\Web\FinanceController::class, 'providerIndex'])->name('provider.finance.index');
});

// Auth routes
require __DIR__.'/auth.php';
