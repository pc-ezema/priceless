<?php

namespace App\Http\Controllers;

use App\Mail\AdminAppointmentMail;
use App\Mail\UserAppointmentMail;
use App\Models\Addon;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomePageController extends Controller
{
    public function setBreadcrumbs($breadcrumbs)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];
        
        foreach ($breadcrumbs as $index => $crumb) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $crumb['name'],
                'item' => url($crumb['url'])
            ];
        }
        
        view()->share('seo_breadcrumbs_schema', $schema);
    }

    public function index()
    {
        $this->setSEO(
            'Priceless Beauty Touch - Luxury Beauty & Spa',
            'Experience luxury beauty and spa treatments at Priceless Beauty Touch in Ashford, Kent. Professional hair, makeup, waxing and wig services. Free parking available near Victoria Park. Book your appointment today!',
            'beauty salon, spa, hair styling, makeup, waxing, wigs, ashford kent, victoria park, priceless beauty touch',
            url('images/logo.png')
        );

        // Add schema markup for one-page site
        $schemaMarkup = [
            '@context' => 'https://schema.org',
            '@type' => 'BeautySalon',
            'name' => 'Priceless Beauty Touch',
            'description' => 'Luxury beauty and spa services in Ashford, Kent including hair styling, waxing, wigs, and makeup. Free parking available near Victoria Park.',
            'url' => url('/'),
            'logo' => url('images/logo.png'),
            'image' => url('images/logo.png'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Near Victoria Park',
                'addressLocality' => 'Ashford',
                'addressRegion' => 'Kent',
                'postalCode' => '', // Add postal code if available
                'addressCountry' => 'UK'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '51.1465',  // Approximate latitude for Ashford, Kent
                'longitude' => '0.8736'   // Approximate longitude for Ashford, Kent
            ],
            'telephone' => '+447369277963',
            'email' => 'pricelessbeautytouch@gmail.com',
            'priceRange' => '££',
            'amenities' => [
                'Free Parking',
                'Near Victoria Park'
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '09:00',
                    'closes' => '18:00'
                ],
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => 'Saturday',
                    'opens' => '09:00',
                    'closes' => '20:00'
                ]
            ],
            'sameAs' => [
                'https://www.instagram.com/pricelessbeautytouch1'
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Beauty Services',
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Hair Styling',
                            'description' => 'Professional hair styling services including cuts, blow dries, and treatments'
                        ]
                    ],
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Waxing',
                            'description' => 'Full range of waxing services including Brazilian, Hollywood, and leg waxing'
                        ]
                    ],
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Wig Services',
                            'description' => 'Custom wig making, styling, and maintenance'
                        ]
                    ]
                ]
            ]
        ];

        view()->share('seo_schema_markup', $schemaMarkup);

        // For server-side rendering
        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('pages.index', compact('services'));
    }

    public function bookAppointment()
    {
        $this->setSEO(
            'Book Your Appointment - Priceless Beauty Touch',
            'Schedule your beauty appointment online. Choose from hair styling, waxing, wig services, and makeup. Easy booking form.',
            'book appointment, online booking, beauty appointment, schedule appointment, london beauty booking',
            url('images/logo.png')
        );

        // ADD SCHEMA MARKUP FOR BOOKING PAGE
        $schemaMarkup = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => 'Book Your Appointment',
            'description' => 'Schedule your beauty appointment online at Priceless Beauty Touch',
            'url' => url('/book-appointment'),
            'mainEntity' => [
                '@type' => 'Offer',
                'name' => 'Beauty Services Booking',
                'description' => 'Online booking form for beauty services',
                'url' => url('/book-appointment'),
                'availability' => 'https://schema.org/InStock',
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'priceCurrency' => 'GBP',
                    'price' => '0'
                ]
            ]
        ];

        view()->share('seo_schema_markup', $schemaMarkup);

        return view('pages.book-appointment');
    }

    /**
     * Clean service name by removing price and duration
     */
    private function cleanServiceName($serviceName)
    {
        // Remove everything after " - "
        $dashPosition = strpos($serviceName, ' - ');
        if ($dashPosition !== false) {
            $serviceName = substr($serviceName, 0, $dashPosition);
        }
        
        // Remove price patterns (£XX.XX)
        $serviceName = preg_replace('/\s*£[\d.]+.*$/', '', $serviceName);
        
        // Remove duration patterns ((Xh Xm) or (X mins))
        $serviceName = preg_replace('/\s*\([^)]*\)\s*$/', '', $serviceName);
        
        // Remove trailing dash
        $serviceName = rtrim($serviceName, ' -');
        
        return trim($serviceName);
    }

    public function storeAppointment(Request $request)
    {
        // Validate with Validator for AJAX-friendly errors
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|email",
            "phone" => "required|string",
            "service" => "required|string",
            "addons" => "nullable|array",
            "appointment_date" => "required|date",
            "appointment_time" => "required",
            "notes" => "nullable|string"
        ]);

        // Return validation errors as JSON (for AJAX)
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Store appointment
        $appointment = Appointment::create($validated);
        
        // CHECK IF THE SERVICE IS IN WAXING CATEGORY
        $isWaxingService = false;

        // Usage
        $cleanedServiceName = $this->cleanServiceName($validated['service']);
        
        // Check from services table (if you have one)
        $service = Service::where('name', $cleanedServiceName)->first();
        if ($service && $service->category === 'Waxing Services') {
            $isWaxingService = true;
        }

        // ---- SEND EMAILS ----
        try {
            // Send email to admin
            Mail::to(" admin@pricelessbeauty.co.uk")
                ->send(new AdminAppointmentMail($appointment));

            // Send email to user with waxing documents if applicable
            Mail::to($appointment->email)
                ->send(new UserAppointmentMail($appointment, $isWaxingService));
                
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error("Failed to send appointment emails: " . $e->getMessage());
        }

        return response()->json([
            "status" => true,
            "message" => "Appointment booked successfully!",
        ]);
    }

    public function ajaxLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->remember == 'on';

        if (Auth::attempt($request->only('email', 'password'), $remember)) {

            return response()->json([
                'status' => 'success',
                'redirect' => route('dashboard') // change if needed
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password.'
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function dashboard()
    {
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $totalCustomers = Appointment::distinct('email')->count('email');
        $totalServices = Service::where('is_active', true)->count();
        $totalAddons = Addon::where('is_active', true)->count();
        $weeklyAppointments = Appointment::whereBetween('appointment_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        return view('admin.dashboard', compact('todayAppointments', 'pendingAppointments', 'totalCustomers', 'totalServices', 'totalAddons', 'weeklyAppointments'));
    }   

    public function getStats()
    {
        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'total_customers' => Appointment::distinct('email')->count('email'),
            'total_services' => Service::where('is_active', true)->count(),
            'total_addons' => Addon::where('is_active', true)->count(),
            'weekly_appointments' => Appointment::whereBetween('appointment_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
        ];
        
        return response()->json($stats);
    }

    public function indexCustomer(Request $request)
    {
        // Get unique customers from appointments
        $query = Appointment::select(
                'email',
                'name',
                'phone',
                DB::raw('MAX(created_at) as last_booking'),
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(CAST(price AS DECIMAL(10,2))) as total_spent')
            )
            ->groupBy('email', 'name', 'phone');
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
        }
        
        $customers = $query->orderBy('last_booking', 'desc')->paginate(15);
        
        return view('admin.customers.index', compact('customers'));
    }

    public function appointments(Request $request)
    {
        $query = Appointment::query();

        // Optional search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('service', 'like', '%' . $request->search . '%');
        }

        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(10);

        return view('admin.appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return response()->json(['success' => true]);
    }

    public function indexService()
    {
        $services = Service::orderBy('category')->orderBy('sort_order')->get();
        $groupedServices = $services->groupBy('category');
        
        return view('admin.services.index', compact('groupedServices', 'services'));
    }

    public function createService()
    {
        $categories = ['Hair Care & Styling', 'Wig Services', 'Waxing Services'];
        return view('admin.services.create', compact('categories'));
    }

    public function storeService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = Service::create([
            'category' => $request->category,
            'name' => $request->name,
            'price' => $request->price,
            'duration' => $request->duration,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'service' => $service, 
                'message' => 'Service added successfully!',
                'redirect' => route('dashboard.services')
            ]);
        }

        return redirect()->route('dashboard.services')->with('success', 'Service added successfully!');
    }

    public function editService(Service $service)
    {
        $categories = ['Hair Care & Styling', 'Wig Services', 'Waxing Services'];
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function updateService(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service->update([
            'category' => $request->category,
            'name' => $request->name,
            'price' => $request->price,
            'duration' => $request->duration,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'service' => $service, 
                'message' => 'Service updated successfully!',
                'redirect' => route('dashboard.services')
            ]);
        }

        return redirect()->route('dashboard.services')->with('success', 'Service updated successfully!');
    }

    public function destroyService(Service $service, Request $request)
    {
        $service->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Service deleted successfully!']);
        }

        return redirect()->route('dashboard.services')->with('success', 'Service deleted successfully!');
    }

    public function toggleServiceStatus(Service $service, Request $request)
    {
        $service->is_active = !$service->is_active;
        $service->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'is_active' => $service->is_active, 'message' => 'Service status updated!']);
        }

        return back()->with('success', 'Service status updated!');
    }

    // API endpoint for frontend to fetch services
    public function getServices()
    {
        $services = Service::getGroupedByCategory();
        return response()->json($services);
    }

    public function indexAddons()
    {
        $addons = Addon::orderBy('category')->orderBy('sort_order')->get();
        $groupedAddons = $addons->groupBy('category');
        return view('admin.addons.index', compact('addons', 'groupedAddons'));
    }

    public function createAddon()
    {
        $categories = ['Hair Care & Styling', 'Wig Services', 'Waxing Services', 'General'];
        return view('admin.addons.create', compact('categories'));
    }

    public function storeAddon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:addons',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $addon = Addon::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'category' => $request->category ?? 'General',
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'addon' => $addon,
                'message' => 'Add-on created successfully!',
                'redirect' => route('dashboard.addons')
            ]);
        }

        return redirect()->route('dashboard.addons')->with('success', 'Add-on created successfully!');
    }

    public function editAddon(Addon $addon)
    {
        $categories = ['Hair Care & Styling', 'Wig Services', 'Waxing Services', 'General'];
        return view('admin.addons.edit', compact('addon', 'categories'));
    }

    public function updateAddon(Request $request, Addon $addon)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:addons,name,' . $addon->id,
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $addon->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'category' => $request->category ?? 'General',
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'addon' => $addon,
                'message' => 'Add-on updated successfully!',
                'redirect' => route('dashboard.addons')
            ]);
        }

        return redirect()->route('dashboard.addons')->with('success', 'Add-on updated successfully!');
    }

    public function destroyAddon(Addon $addon, Request $request)
    {
        $addon->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Add-on deleted successfully!']);
        }

        return redirect()->route('dashboard.addons')->with('success', 'Add-on deleted successfully!');
    }

    public function toggleAddonStatus(Addon $addon, Request $request)
    {
       // Always return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $addon->is_active = !$addon->is_active;
                $addon->save();
                
                return response()->json([
                    'success' => true,
                    'is_active' => $addon->is_active,
                    'message' => $addon->is_active ? 'Add-on activated successfully!' : 'Add-on deactivated successfully!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update status: ' . $e->getMessage()
                ], 500);
            }
        }
        
        // For non-AJAX requests
        $addon->is_active = !$addon->is_active;
        $addon->save();
        
        return redirect()->back()->with('success', 'Add-on status updated!');
    }
}
