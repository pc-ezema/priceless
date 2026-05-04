<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\SitemapController;
use App\Models\Service;
use Illuminate\Support\Facades\Artisan;

Route::get('/sitemap.xml', function () {
    $services = Service::where('is_active', true)->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    
    // Main page
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>' . url('/') . '</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>daily</changefreq>' . "\n";
    $xml .= '        <priority>1.0</priority>' . "\n";
    $xml .= '    </url>' . "\n";
    
    // Booking page
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>' . url('/book-appointment') . '</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>weekly</changefreq>' . "\n";
    $xml .= '        <priority>0.9</priority>' . "\n";
    $xml .= '    </url>' . "\n";
    
    // ADD MORE PAGES HERE - Example:
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>' . url('/#about-us') . '</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>monthly</changefreq>' . "\n";
    $xml .= '        <priority>0.8</priority>' . "\n";
    $xml .= '    </url>' . "\n";
    
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>' . url('/#services') . '</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>weekly</changefreq>' . "\n";
    $xml .= '        <priority>0.9</priority>' . "\n";
    $xml .= '    </url>' . "\n";
    
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>' . url('/#gallery') . '</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>monthly</changefreq>' . "\n";
    $xml .= '        <priority>0.7</priority>' . "\n";
    $xml .= '    </url>' . "\n";
    
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>' . url('/#faqs') . '</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>monthly</changefreq>' . "\n";
    $xml .= '        <priority>0.7</priority>' . "\n";
    $xml .= '    </url>' . "\n";
    
    $xml .= '    <url>' . "\n";
    $xml .= '        <loc>' . url('/#contact-us') . '</loc>' . "\n";
    $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    $xml .= '        <changefreq>monthly</changefreq>' . "\n";
    $xml .= '        <priority>0.8</priority>' . "\n";
    $xml .= '    </url>' . "\n";
    
    // ==========================================
    // ADD YOUR SERVICES FROM DATABASE
    // ==========================================
    foreach ($services as $service) {
        $xml .= '    <url>' . "\n";
        $xml .= '        <loc>' . url('/#service-' . \Illuminate\Support\Str::slug($service->name)) . '</loc>' . "\n";
        $xml .= '        <lastmod>' . ($service->updated_at ?? now())->format('Y-m-d') . '</lastmod>' . "\n";
        $xml .= '        <changefreq>weekly</changefreq>' . "\n";
        $xml .= '        <priority>0.8</priority>' . "\n";
        $xml .= '    </url>' . "\n";
    }
    
    $xml .= '</urlset>';
    
    return response($xml, 200)
        ->header('Content-Type', 'text/xml')
        ->header('Cache-Control', 'public, max-age=3600');
});

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

Route::get('/available-slots', [HomePageController::class, 'getAvailableSlots']);
Route::get('/slots/{date}', [HomePageController::class, 'getSlotsByDate']);

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
    
    // Time Slot Management Routes
    Route::get('/dashboard/time-slots', [HomePageController::class, 'indexTimeSlot'])->name('dashboard.time-slots');
    Route::get('/dashboard/time-slots/data', [HomePageController::class, 'getData'])->name('time-slots.data');
    Route::get('/dashboard/time-slots/create', [HomePageController::class, 'createTimeSlot'])->name('time-slots.create');
    Route::post('/dashboard/time-slots', [HomePageController::class, 'storeTimeSlot'])->name('time-slots.store');
    Route::get('/dashboard/time-slots/{timeSlot}/edit', [HomePageController::class, 'editTimeSlot'])->name('time-slots.edit');
    Route::put('/dashboard/time-slots/{timeSlot}', [HomePageController::class, 'updateTimeSlot'])->name('time-slots.update');
    Route::delete('/dashboard/time-slots/{timeSlot}', [HomePageController::class, 'destroyTimeSlot'])->name('time-slots.destroy');

    // Dashboard Stats
    Route::get('/dashboard/stats', [HomePageController::class, 'getStats'])->name('dashboard.stats');
    
    // Customers
    Route::get('/dashboard/customers', [HomePageController::class, 'indexCustomer'])->name('dashboard.customers');
});

