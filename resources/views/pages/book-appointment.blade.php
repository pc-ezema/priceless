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

                        <!-- Date & Time Selection -->
                        <div class="form-section">
                            <h3 class="section-title">Schedule Your Appointment</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="appointment_date">Preferred Date <span class="required">*</span></label>
                                    <input type="date" id="appointment_date" name="appointment_date" required>
                                    <i class="fas fa-calendar-alt input-icon"></i>
                                </div>

                                <div class="form-group">
                                    <label for="appointment_time">Preferred Time <span class="required">*</span></label>
                                    <input type="time" id="appointment_time" name="appointment_time" required>
                                    <i class="fas fa-clock input-icon"></i>
                                </div>
                            </div>
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