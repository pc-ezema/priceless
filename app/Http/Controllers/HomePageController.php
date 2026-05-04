<?php

namespace App\Http\Controllers;

use App\Mail\AdminAppointmentMail;
use App\Mail\UserAppointmentMail;
use App\Models\Addon;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\TimeSlot;
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
            'Priceless Beauty Touch - Luxury Beauty & Spa in Ashford, Kent',
            'Experience luxury beauty and spa treatments at Priceless Beauty Touch in Ashford, Kent. Professional hair, makeup, waxing, wig services and wood therapy. Free parking near Victoria Park. Book your appointment today!',
            'beauty salon ashford kent, spa ashford, hair styling ashford, waxing ashford, wood therapy ashford, wigs kent, victoria park ashford',
            url('images/logo.png')
        );

        // Add schema markup for one-page site
        $schemaMarkup = [
            '@context' => 'https://schema.org',
            '@type' => 'BeautySalon',
            'name' => 'Priceless Beauty Touch',
            'description' => 'Luxury beauty and spa services in Ashford, Kent including hair styling, waxing, wigs, wood therapy, and makeup. Free parking available near Victoria Park.',
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

        $existingCount = Appointment::where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->count();
        
        // Get max bookings from your time_slots table for this time range
        $timeSlot = TimeSlot::where('date', $validated['appointment_date'])
            ->where('start_time', '<=', $validated['appointment_time'])
            ->where('end_time', '>', $validated['appointment_time'])
            ->first();

        $maxBookings = $timeSlot->max_bookings ?? 1;
    
        if ($existingCount >= $maxBookings) {
            return response()->json([
                "status" => false,
                "message" => "This time slot is no longer available. Please select another time."
            ], 422);
        }

        // Store appointment
        $appointment = Appointment::create($validated);

        // INCREMENT THE CURRENT_BOOKINGS COUNTER
        $timeSlot->increment('current_bookings');
        
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
            Mail::to(" admin@pricelessbeautytouch.co.uk")
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
        $categories = ['Hair Care & Styling', 'Wig Services', 'Waxing Services', 'Wood Therapy'];
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
        $categories = ['Hair Care & Styling', 'Wig Services', 'Waxing Services', 'Wood Therapy'];
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

    public function getData(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $slots = TimeSlot::whereBetween('date', [$startDate, $endDate])->get();
        
        $data = [];
        foreach ($slots as $slot) {
            $hour = date('G', strtotime($slot->start_time));
            $key = $slot->date . '_' . $hour;
            $data[$key] = [
                'id' => $slot->id,
                'start_time' => date('g:i A', strtotime($slot->start_time)),
                'end_time' => date('g:i A', strtotime($slot->end_time)),
                'max_bookings' => $slot->max_bookings,
                'current_bookings' => $slot->current_bookings,
                'status' => $slot->status,
            ];
        }
        
        return response()->json($data);
    }

    public function indexTimeSlot(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->toDateString());
        
        $timeSlots = TimeSlot::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('date');
        
        return view('admin.time-slots.index', compact('timeSlots', 'startDate', 'endDate'));
    }

    public function createTimeSlot()
    {
        return view('admin.time-slots.create');
    }

    public function storeTimeSlot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'max_bookings' => 'required|integer|min:1|max:10',
            'status' => 'required|in:available,blocked'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Check for existing slot
        $exists = TimeSlot::where('date', $request->date)->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'A time slot for this date already exists. Please edit the existing slot or choose a different date.'], 422);
            }
        }

        $timeSlot = TimeSlot::create($request->all());

        return response()->json(['success' => true, 'message' => 'Time slot created successfully', 'data' => $timeSlot]);
    }

    public function editTimeSlot(TimeSlot $timeSlot)
    {
        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'id' => $timeSlot->id,
                'date' => $timeSlot->date,
                'start_time' => $timeSlot->start_time,
                'end_time' => $timeSlot->end_time,
                'max_bookings' => $timeSlot->max_bookings,
                'current_bookings' => $timeSlot->current_bookings,
                'status' => $timeSlot->status,
            ]);
        }
        
        // For non-AJAX requests (fallback)
        return view('admin.time-slots.edit', compact('timeSlot'));
    }

    public function updateTimeSlot(Request $request, TimeSlot $timeSlot)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'max_bookings' => 'required|integer|min:1|max:10',
            'status' => 'required|in:available,blocked'  // Removed 'booked' as it's auto-managed
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $timeSlot->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_bookings' => $request->max_bookings,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Time slot updated successfully']);
    }

    public function destroyTimeSlot(TimeSlot $timeSlot)
    {
        $timeSlot->delete();
        return response()->json(['success' => true, 'message' => 'Time slot deleted successfully']);
    }

    public function bulkCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'max_bookings' => 'required|integer|min:1|max:10',
            'repeat_days' => 'array',
            'repeat_days.*' => 'in:mon,tue,wed,thu,fri,sat,sun'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $repeatDays = $request->repeat_days ?? [];
        $created = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            // Check if we should create for this day
            if (!empty($repeatDays)) {
                $dayName = strtolower($date->format('D'));
                if (!in_array($dayName, $repeatDays)) {
                    continue;
                }
            }

            // Check if slot already exists
            $exists = TimeSlot::where('date', $date->toDateString())
                ->where('start_time', $request->start_time)
                ->exists();

            if (!$exists) {
                TimeSlot::create([
                    'date' => $date->toDateString(),
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'max_bookings' => $request->max_bookings,
                    'status' => 'available'
                ]);
                $created++;
            }
        }

        return response()->json(['success' => true, 'message' => "Created {$created} time slots"]);
    }

    // API endpoint for frontend calendar
    public function getAvailableSlots(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        $startDate = Carbon::create($year, $month, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
        
        $slots = TimeSlot::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'available')
            ->whereRaw('current_bookings < max_bookings')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
        
        $calendar = [];
        $currentDate = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        while ($currentDate <= $end) {
            $dateString = $currentDate->toDateString();
            $calendar[$dateString] = [
                'date' => $dateString,
                'has_slots' => false,
                'slots' => []
            ];
            $currentDate->addDay();
        }
        
        foreach ($slots as $slot) {
            $dateString = $slot->date->toDateString();
            if (isset($calendar[$dateString])) {
                $calendar[$dateString]['has_slots'] = true;
                // Store the range info
                $calendar[$dateString]['range'] = [
                    'start' => Carbon::parse($slot->start_time)->format('g:i A'),
                    'end' => Carbon::parse($slot->end_time)->format('g:i A'),
                    'slot_id' => $slot->id
                ];
            }
        }
        
        return response()->json($calendar);
    }

    public function getSlotsByDate($date)
    {
        // Get available time slots
        $timeSlots = TimeSlot::where('date', $date)
            ->where('status', 'available')
            ->get();

        // Get booked appointments
        $appointments = Appointment::where('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->get();

        $individualSlots = [];

        foreach ($timeSlots as $slot) {
            $slotStart = Carbon::parse($slot->start_time);
            $slotEnd = Carbon::parse($slot->end_time);

            // Start EXACTLY from slot start
            $current = $slotStart->copy();

            while ($current < $slotEnd) {
                $windowStart = $current->copy();
                $windowEnd = $current->copy()->addMinutes(10);

                // Prevent overflow beyond slot end
                if ($windowStart >= $slotEnd) {
                    break;
                }

                // 🔥 COUNT BOOKINGS IN THIS WINDOW (ACCURATE)
                $currentBookings = 0;

                foreach ($appointments as $appointment) {
                    $appointmentTime = Carbon::parse($appointment->appointment_time);

                    if ($appointmentTime >= $windowStart && $appointmentTime < $windowEnd) {
                        $currentBookings++;
                    }
                }

                // ✔ Choose your availability logic

                // OPTION A: Allow multiple bookings up to max
                // $isAvailable = $currentBookings < $slot->max_bookings;

                // OPTION B: Only 1 booking per slot (uncomment if needed)
                $isAvailable = $currentBookings === 0;

                // Debug log (optional)
                // Log::info([
                //     'window' => $windowStart->format('H:i'),
                //     'bookings' => $currentBookings,
                //     'isAvailable' => $isAvailable
                // ]);

                $individualSlots[] = [
                    'id' => $slot->id . '_' . $windowStart->format('H:i'),
                    'time_slot_id' => $slot->id,
                    'start_time' => $windowStart->format('H:i:s'),
                    'start_display' => $windowStart->format('g:i A'),
                    'end_time' => $windowEnd->format('H:i:s'),
                    'end_display' => $windowEnd->format('g:i A'),
                    'max_bookings' => $slot->max_bookings,
                    'current_bookings' => $currentBookings,
                    'available_spots' => $slot->max_bookings - $currentBookings,
                    'is_available' => $isAvailable
                ];

                // Move forward 10 mins
                $current->addMinutes(10);
            }
        }

        return response()->json($individualSlots);
    }
}
