<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Artisan;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/book-appointment', [HomePageController::class, 'bookAppointment'])->name('book.appointment');
Route::post('/appointments', [HomePageController::class, 'storeAppointment'])->name('appointments.store');
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
Route::get('/appointment/confirmation', function() {
    return view('pages.appointment-confirmation');
})->name('appointment.confirmation');

Route::get('/login', function() {
    return view('admin.login');
})->name('login');

Route::post('/ajax/login', [HomePageController::class, 'ajaxLogin'])
     ->name('ajax.login');

Route::middleware(['auth'])->group(function () {
    // Logout route
    Route::post('/logout', [HomePageController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomePageController::class, 'dashboard'])->name('dashboard');

    // Service Management Routes
    Route::get('/dashboard/services', [HomePageController::class, 'indexService'])->name('dashboard.services');
    Route::get('/dashboard/services/create', [HomePageController::class, 'createService'])->name('services.create');
    Route::post('/dashboard/services', [HomePageController::class, 'storeService'])->name('services.store');
    Route::get('/dashboard/services/{service}/edit', [HomePageController::class, 'editService'])->name('services.edit');
    Route::put('/dashboard/services/{service}', [HomePageController::class, 'updateService'])->name('services.update');
    Route::delete('/dashboard/services/{service}', [HomePageController::class, 'destroyService'])->name('services.destroy');
    Route::patch('/dashboard/services/{service}/toggle-status', [HomePageController::class, 'toggleServiceStatus'])->name('services.toggle-status');

    // Add-on Management Routes
    Route::get('/dashboard/addons', [HomePageController::class, 'indexAddons'])->name('dashboard.addons');
    Route::get('/dashboard/addons/create', [HomePageController::class, 'createAddon'])->name('addons.create');
    Route::post('/dashboard/addons', [HomePageController::class, 'storeAddon'])->name('addons.store');
    Route::get('/dashboard/addons/{addon}/edit', [HomePageController::class, 'editAddon'])->name('addons.edit');
    Route::put('/dashboard/addons/{addon}', [HomePageController::class, 'updateAddon'])->name('addons.update');
    Route::delete('/dashboard/addons/{addon}', [HomePageController::class, 'destroyAddon'])->name('addons.destroy');
    Route::patch('/dashboard/addons/{addon}/toggle-status', [HomePageController::class, 'toggleAddonStatus'])->name('addons.toggle-status');

    // Optionally, other authenticated routes
    Route::get('/dashboard/appointments', [HomePageController::class, 'appointments'])->name('dashboard.appointments');
    Route::patch('/appointments/{appointment}/status', [HomePageController::class, 'updateStatus'])->name('appointments.updateStatus');
    
     // Dashboard Stats
    Route::get('/dashboard/stats', [HomePageController::class, 'getStats'])->name('dashboard.stats');
    
    // Customers
    Route::get('/dashboard/customers', [HomePageController::class, 'indexCustomer'])->name('dashboard.customers');
});

