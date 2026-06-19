@extends('layouts.frontend', ['title' => 'Book Appointment'])

@section('page-content')
<main id="page" class="booking-page" role="main">
    <article class="sections" id="sections">
        <!-- Hero Breadcrumb Section -->
        <section class="booking-hero-section">
            <div class="booking-hero-overlay"></div>
            <div class="booking-hero-content">
                <h1 class="booking-hero-title">Book Your Appointment</h1>
                <p class="booking-hero-subtitle">Reserve your moment of beauty and relaxation</p>
                <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Book Appointment</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Appointment Form Section -->
        <section class="booking-form-section">
            {{-- Booking Policies Section --}}
            <div class="policies-info-wrapper">
                <div class="policies-header">
                    <div class="policies-header-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3>Important Information</h3>
                    <p>Please read all details before booking</p>
                </div>

                <div class="policies-grid">
                    <!-- Pre-Bookings -->
                    <div class="policy-card">
                        <div class="policy-card-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Pre-Bookings</h4>
                            <p>Appointments can be booked up to <strong>4 weeks</strong> in advance.</p>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="policy-card">
                        <div class="policy-card-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Location</h4>
                            <p><strong>Ashford, Kent</strong><br>Full address will be provided <strong>24 hours</strong> before your appointment.</p>
                        </div>
                    </div>

                    <!-- Deposit -->
                    <div class="policy-card policy-highlight">
                        <div class="policy-card-icon">
                            <i class="fas fa-pound-sign"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Deposit</h4>
                            <p>A <strong>£25 non-refundable deposit</strong> is required to secure your booking. This will be deducted from your final balance. Remaining payment can be made via bank transfer or cash.</p>
                        </div>
                    </div>

                    <!-- Rescheduling -->
                    <div class="policy-card">
                        <div class="policy-card-icon">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Rescheduling</h4>
                            <p>You may reschedule your appointment <strong>once</strong>. Any additional changes will require a new deposit. If you're unable to attend and do not reschedule within <strong>24 hours</strong>, your deposit will be forfeited. <strong>Same-day reschedules are not accepted.</strong></p>
                        </div>
                    </div>

                    <!-- Lateness -->
                    <div class="policy-card policy-warning">
                        <div class="policy-card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Lateness Policy</h4>
                            <ul class="policy-items-list">
                                <li><span>15 mins</span> <strong>£15 fee</strong></li>
                                <li><span>20 mins</span> <strong>£20 fee</strong></li>
                                <li><span>30 mins</span> <strong>Cancelled</strong></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Hair Drop Offs -->
                    <div class="policy-card">
                        <div class="policy-card-icon">
                            <i class="fas fa-cut"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Hair Drop Offs</h4>
                            <ul class="policy-items-list">
                                <li>Drop off <strong>no later than 5 days</strong> before your appointment</li>
                                <li>If dropping off, <strong>contact first</strong></li>
                                <li>If posting, <strong>stay on top of tracking</strong></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Emergency Slots -->
                    <div class="policy-card policy-highlight">
                        <div class="policy-card-icon">
                            <i class="fas fa-ambulance"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Emergency Slots</h4>
                            <p>Subject to availability and will incur an extra charge of <strong>£15</strong></p>
                        </div>
                    </div>

                    <!-- Cancellations & No-Shows -->
                    <div class="policy-card">
                        <div class="policy-card-icon">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Cancellations & No-Shows</h4>
                            <p>Same-day cancellations or failure to attend will result in a charge of <strong>25% of your service cost</strong>.</p>
                        </div>
                    </div>

                    <!-- Appointments & Availability -->
                    <div class="policy-card">
                        <div class="policy-card-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Appointments & Availability</h4>
                            <ul class="policy-items-list">
                                <li>New slots are released on the <strong>last day of each month</strong></li>
                                <li>Keep an eye on <strong>Instagram story</strong> for last-minute cancellations</li>
                                <li>Bookings made within <strong>24 hours</strong> incur a <strong>£10 late booking fee</strong></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Hair Preparation -->
                    <div class="policy-card">
                        <div class="policy-card-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Hair Preparation</h4>
                            <p>Please arrive with <strong>clean, freshly washed, and blow-dried hair</strong>. No oils or products. If hair is not prepped correctly, additional charges may apply.</p>
                        </div>
                    </div>

                    <!-- Guests -->
                    <div class="policy-card">
                        <div class="policy-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Guests</h4>
                            <p>Due to limited space, please <strong>check in advance</strong> before bringing anyone along.</p>
                        </div>
                    </div>

                    <!-- Hair Requirements -->
                    <div class="policy-card policy-highlight">
                        <div class="policy-card-icon">
                            <i class="fas fa-braille"></i>
                        </div>
                        <div class="policy-card-content">
                            <h4>Hair Requirements</h4>
                            <ul class="policy-items-list">
                                <li>Bring <strong>4 packs of pre-stretched X-Pression braiding hair</strong> to your appointment</li>
                                <li>We only work with <strong>pre-stretched hair</strong> to ensure the best finish and save time during your service</li>
                                <li>If you don't have hair, you can <strong>purchase it as an add-on during booking</strong> or through our website before your appointment</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="booking-form-container">
                <div class="booking-form-wrapper">
                    <div class="form-header">
                        <span class="form-badge">Reserve Your Spot</span>
                        <h2 class="form-title">Schedule Your Visit</h2>
                        <p class="form-description">Fill out the form below and we'll confirm your appointment within 24 hours.</p>
                    </div>

                    <form id="appointmentForm" action="{{ route('appointments.store') }}" method="POST" class="appointment-form">
                        @csrf

                        <!-- Personal Information -->
                        <div class="form-section">
                            <h3 class="section-title">Personal Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="required">*</span></label>
                                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                                    <i class="fas fa-user input-icon"></i>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" placeholder="your@email.com" required>
                                    <i class="fas fa-envelope input-icon"></i>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number <span class="required">*</span></label>
                                    <input type="tel" id="phone" name="phone" placeholder="+44 123 456 789" required>
                                    <i class="fas fa-phone input-icon"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Service Selection -->
                        <div class="form-section">
                            <h3 class="section-title">Select Your Service</h3>
                            <div class="form-group">
                                <label for="service">Choose Service <span class="required">*</span></label>
                                <select name="service" id="service" required>
                                    <option value="">Select a service...</option>
                                    @php
                                    $groupedServices = App\Models\Service::where('is_active', true)
                                    ->orderBy('sort_order')
                                    ->get()
                                    ->groupBy('category');

                                    $categoryIcons = [
                                    'Hair Care & Styling' => '💇‍♀️',
                                    'Wig Services' => '👑',
                                    'Waxing Services' => '✨'
                                    ];
                                    @endphp

                                    @foreach($groupedServices as $category => $services)
                                    <optgroup label="{{ $categoryIcons[$category] ?? '📌' }} {{ $category }}">
                                        @foreach($services as $service)
                                        @php
                                        $priceDisplay = $service->price > 0 ? '£' . number_format($service->price, 2) : 'Price on request';
                                        $durationDisplay = $service->duration ? " ({$service->duration})" : '';
                                        $serviceValue = "{$service->name} - {$priceDisplay}{$durationDisplay}";
                                        $optionText = "{$service->name} - {$priceDisplay}{$durationDisplay}";
                                        @endphp
                                        <option value="{{ $serviceValue }}"
                                            data-price="{{ $service->price }}"
                                            data-duration="{{ $service->duration }}"
                                            data-category="{{ $category }}">
                                            {{ $optionText }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Add-ons -->
                        <div class="form-section">
                            <h3 class="section-title">Add-ons (Optional)</h3>
                            <div class="checkbox-group" id="addonsGroup">
                                @php
                                $addons = App\Models\Addon::where('is_active', true)
                                ->orderBy('sort_order')
                                ->get();
                                @endphp

                                @foreach($addons as $addon)
                                <label class="custom-checkbox" data-price="{{ $addon->price }}" data-category="{{ $addon->category }}">
                                    <input type="checkbox" name="addons[]" value="{{ $addon->name }}">
                                    <span class="checkmark"></span>
                                    <span class="checkbox-label">
                                        {{ $addon->name }}
                                        @if($addon->price > 0)
                                        <span class="addon-price">(+£{{ number_format($addon->price, 2) }})</span>
                                        @endif
                                        @if($addon->description)
                                        <small class="addon-desc">{{ $addon->description }}</small>
                                        @endif
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Add-on Summary -->
                        <div class="addons-summary" id="addonsSummary" style="display: none;">
                            <div class="summary-card">
                                <h4>Selected Add-ons</h4>
                                <div id="selectedAddonsList"></div>
                                <div class="addons-total">
                                    <span>Total Add-ons:</span>
                                    <span id="addonsTotalPrice">£0.00</span>
                                </div>
                            </div>
                        </div>

                        {{-- Appointment Date and Time Section with Calendar --}}
                        <div class="form-section">
                            <h3 class="section-title">Select Date & Time</h3>

                            <!-- Calendar -->
                            <div class="calendar-container">
                                <div class="calendar-header">
                                    <button type="button" id="prevMonth" class="calendar-nav">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <h3 id="currentMonthYear">May 2026</h3>
                                    <button type="button" id="nextMonth" class="calendar-nav">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>

                                <div class="calendar-weekdays">
                                    <div>Sun</div>
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                </div>

                                <div id="calendarGrid" class="calendar-grid">
                                    <!-- Calendar cells will be populated by JavaScript -->
                                </div>
                            </div>

                            <!-- Time Slots -->
                            <div id="timeSlotsContainer" class="time-slots-container" style="display: none;">
                                <label>
                                    <i class="fas fa-clock" style="margin-right: 0.5rem; color: #b37d97;"></i>
                                    Choose your preferred time <span class="required">*</span>
                                </label>
                                <div id="timeSlotsGrid" class="time-slots-grid">
                                    <!-- Time slots will be populated by JavaScript -->
                                </div>
                            </div>

                            <!-- Hidden fields for form submission -->
                            <input type="hidden" name="appointment_date" id="selectedDate" required>
                            <input type="hidden" name="appointment_time" id="selectedTimeDisplay" required>
                            <input type="hidden" name="time_slot_id" id="selectedTimeSlot" required>
                        </div>

                        <!-- Special Instructions -->
                        <div class="form-section">
                            <h3 class="section-title">Special Requests</h3>
                            <div class="form-group">
                                <label for="notes">Additional Notes</label>
                                <textarea id="notes" name="notes" rows="4" placeholder="Any special requests, allergies, or instructions..."></textarea>
                                <i class="fas fa-pencil-alt textarea-icon"></i>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-actions">
                            <button type="submit" id="submitBtn" class="submit-btn">
                                <span class="btn-text">Book Appointment</span>
                                <span class="btn-loader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Processing...
                                </span>
                            </button>
                        </div>

                        <!-- Form Message -->
                        <div id="formMessage" class="form-message"></div>
                    </form>
                </div>

                <!-- Sidebar Info -->
                <div class="booking-info-sidebar">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Working Hours</h4>
                        <ul class="info-hours">
                            <li><span>Mon - Fri:</span> 9:00 AM - 6:00 PM</li>
                            <li><span>Saturday:</span> 9:00 AM - 8:00 PM</li>
                            <li><span>Sunday:</span> Subject to Availability</li>
                        </ul>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Need Help?</h4>
                        <p>Call us at <a href="tel:+447369277963">+44 7369 277963</a></p>
                        <p>Email: <a href="mailto:pricelessbeautytouch@gmail.com">pricelessbeautytouch@gmail.com</a></p>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h4>Booking Policy</h4>
                        <ul class="info-policy">
                            <li>✓ 24-hour cancellation notice required</li>
                            <li>✓ 10-minute grace period for late arrivals</li>
                            <li>✓ Deposits may be required for certain services</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </article>
</main>
@endsection

@push('styles')
<style>
    /* ============================================
   BOOKING POLICIES SECTION - UNIQUE NAMES
   ============================================ */

    /* Main Container */
    .policies-info-wrapper {
        background: linear-gradient(135deg, #fff9f7, #fff5f0);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(179, 125, 151, 0.15);
    }

    /* Header Section */
    .policies-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .policies-header-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #b37d97, #d4a0ba);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .policies-header-icon i {
        font-size: 1.8rem;
        color: white;
    }

    .policies-header h3 {
        font-size: 1.6rem;
        color: #2c2a2a;
        margin-bottom: 0.5rem;
        font-family: 'Playfair Display', serif;
    }

    .policies-header p {
        color: #b37d97;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Grid Container */
    .policies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    /* Policy Card */
    .policy-card {
        background: white;
        border-radius: 20px;
        padding: 1.2rem;
        display: flex;
        gap: 1rem;
        transition: all 0.3s ease;
        border: 1px solid #f0e0e8;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .policy-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(179, 125, 151, 0.1);
        border-color: #d4a0ba;
    }

    .policy-card.policy-highlight {
        background: linear-gradient(135deg, #fff5f0, #fff0f5);
        border-left: 4px solid #b37d97;
    }

    .policy-card.policy-warning {
        background: #fff8f0;
        border-left: 4px solid #ff9800;
    }

    /* Card Icon */
    .policy-card-icon {
        width: 45px;
        height: 45px;
        background: rgba(179, 125, 151, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .policy-card-icon i {
        font-size: 1.3rem;
        color: #b37d97;
    }

    .policy-card.policy-highlight .policy-card-icon {
        background: rgba(179, 125, 151, 0.15);
    }

    .policy-card.policy-warning .policy-card-icon {
        background: rgba(255, 152, 0, 0.1);
    }

    .policy-card.policy-warning .policy-card-icon i {
        color: #ff9800;
    }

    /* Card Content */
    .policy-card-content {
        flex: 1;
    }

    .policy-card-content h4 {
        font-size: 1rem;
        font-weight: 700;
        color: #2c2a2a;
        margin-bottom: 0.5rem;
        font-family: 'Playfair Display', serif;
    }

    .policy-card-content p {
        font-size: 0.85rem;
        color: #5a5a5a;
        line-height: 1.5;
        margin: 0;
    }

    .policy-card-content strong {
        color: #b37d97;
        font-weight: 600;
    }

    /* Policy List */
    .policy-items-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .policy-items-list li {
        font-size: 0.85rem;
        color: #5a5a5a;
        padding: 0.2rem 0;
        /* display: flex;
        justify-content: space-between;
        align-items: center; */
    }

    .policy-items-list li span {
        color: #2c2a2a;
    }

    .policy-items-list li strong {
        color: #b37d97;
    }

    .policy-card.policy-warning .policy-items-list li strong {
        color: #ff9800;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .policies-info-wrapper {
            padding: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .policies-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .policy-card {
            padding: 1rem;
        }

        .policy-card-icon {
            width: 40px;
            height: 40px;
        }

        .policy-card-icon i {
            font-size: 1.1rem;
        }

        .policy-card-content h4 {
            font-size: 0.9rem;
        }

        .policy-card-content p,
        .policy-items-list li {
            font-size: 0.8rem;
        }

        .policies-header h3 {
            font-size: 1.3rem;
        }
    }

    @media (max-width: 480px) {
        .policy-card {
            flex-direction: column;
            text-align: center;
        }

        .policy-card-icon {
            margin: 0 auto;
        }

        .policy-items-list li {
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
    }
</style>
@endpush