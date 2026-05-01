@extends('layouts.frontend', ['title' => 'Spa & Beauty Services in London | Priceless Beauty Touch'])

@section('page-content')
<main id="page" class="container-full" role="main">
    <article class="sections" id="sections" data-page-sections="65d36a8c0d3ab3468b2de1b9">
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="hero-content-wrapper">
                <a href="{{ route('book.appointment') }}" class="hero-cta-btn" data-hover-scale>BOOK APPOINTMENT</a>
            </div>
        </section>

        <!-- About Us Section -->
        <section id="about-us" class="about-section">
            <div class="about-container">
                <div class="about-image-wrapper">
                    <div class="about-image">
                        <img src="{{ url('images/about-image.jpg') }}" alt="{{ config('app.name') }} Beauty Studio" loading="lazy">
                    </div>
                </div>
                <div class="about-content-wrapper">
                    <h2 class="about-title">{{ config('app.name') }}</h2>
                    <div class="about-text">
                        <p>At Priceless Beauty Touch, we believe that beauty is personal, and everyone deserves to look and feel their best. Our salon combines professional expertise, high-quality products, and a relaxing atmosphere to provide you with exceptional hair, makeup, and waxing services.</p>
                        <p>From flawless hair transformations to rejuvenating beauty treatments, we pride ourselves on attention to detail, creativity, and a commitment to enhancing your natural beauty. Whether you're preparing for a special occasion, a casual day out, or simply pampering yourself, Priceless Beauty Touch is your go-to destination for confidence, style, and self-care.</p>
                        <p class="about-mission"><strong>Our Mission:</strong> To empower every client by delivering personalized beauty services that leave a lasting impression.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section - Hybrid Approach -->
        <section id="services" class="services-section">
            <div class="services-container">
                <h2 class="services-title">Our Services</h2>
                <div class="services-grid" id="servicesGrid">
                    @if(isset($services) && count($services) > 0)
                        @php
                            $categoryIcons = [
                                'Hair Care & Styling' => 'fa-cut',
                                'Wig Services' => 'fa-female',
                                'Waxing Services' => 'fa-feather-alt'
                            ];
                        @endphp

                        @foreach($services as $category => $categoryServices)
                        <div class="service-card" data-animate="fade-up">
                            <div class="service-card-inner">
                                <div class="service-icon">
                                    <i class="fas {{ $categoryIcons[$category] ?? 'fa-spa' }}"></i>
                                </div>
                                <h3>{{ $category }}</h3>
                                <ul class="service-list">
                                    @foreach($categoryServices as $service)
                                    <li>
                                        <span class="service-name">{{ $service->name }}</span>
                                        <span class="service-price">
                                            @if($service->price == 0 || str_contains(strtolower($service->name), 'from'))
                                                from £{{ number_format($service->price, 2) }}
                                            @else
                                                £{{ number_format($service->price, 2) }}
                                            @endif
                                        </span>
                                        @if($service->duration)
                                            <span class="service-duration">({{ $service->duration }})</span>
                                        @endif
                                        @if($service->description)
                                            <br><small>{{ $service->description }}</small>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('book.appointment') }}" class="book-btn">
                                    Book Appointment <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <!-- Fallback static content if no services in database -->
                        <div class="service-card" data-animate="fade-up">
                            <div class="service-card-inner">
                                <div class="service-icon">
                                    <i class="fas fa-cut"></i>
                                </div>
                                <h3>Hair Care & Styling</h3>
                                <ul class="service-list">
                                    <li><span class="service-name">Braid Removal</span> <span class="service-price">£60</span> <span class="service-duration">(1h 45m)</span></li>
                                    <li><span class="service-name">Virgin Hair Relaxer</span> <span class="service-price">£120</span> <span class="service-duration">(2h)</span></li>
                                    <li><span class="service-name">Wash & Blow Dry</span> <span class="service-price">£30</span> <span class="service-duration">(1h)</span></li>
                                    <li><span class="service-name">Silk Press</span> <span class="service-price">£60</span> <span class="service-duration">(2h)</span></li>
                                </ul>
                                <a href="{{ route('book.appointment') }}" class="book-btn">Book Appointment <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        
                        <div class="service-card" data-animate="fade-up">
                            <div class="service-card-inner">
                                <div class="service-icon">
                                    <i class="fas fa-female"></i>
                                </div>
                                <h3>Wig Services</h3>
                                <ul class="service-list">
                                    <li><span class="service-name">Closure Wigs</span> <span class="service-price">£110</span></li>
                                    <li><span class="service-name">Frontal Wigs</span> <span class="service-price">£130</span></li>
                                    <li><span class="service-name">Revamps</span> <span class="service-price">from £50</span></li>
                                </ul>
                                <a href="{{ route('book.appointment') }}" class="book-btn">Book Appointment <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                        
                        <div class="service-card" data-animate="fade-up">
                            <div class="service-card-inner">
                                <div class="service-icon">
                                    <i class="fas fa-feather-alt"></i>
                                </div>
                                <h3>Waxing Services</h3>
                                <ul class="service-list">
                                    <li><span class="service-name">Bikini Wax</span> <span class="service-price">£30</span> <span class="service-duration">(30 mins)</span></li>
                                    <li><span class="service-name">Brazilian</span> <span class="service-price">£45</span> <span class="service-duration">(45 mins)</span></li>
                                    <li><span class="service-name">Full Leg Wax</span> <span class="service-price">£35</span> <span class="service-duration">(45 mins)</span></li>
                                </ul>
                                <a href="{{ route('book.appointment') }}" class="book-btn">Book Appointment <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="gallery-section" id="gallery">
            <div class="gallery-container">
                <h2 class="gallery-title">Our Gallery</h2>
                <p class="gallery-subtitle">Follow us on Instagram for more inspiration</p>
                <div class="gallery-grid">
                    <figure class="gallery-item">
                        <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer">
                            <img src="{{ url('images/gallery/image-d1.jpeg') }}" alt="Hair styling service">
                            <div class="gallery-overlay"><i class="fab fa-instagram"></i></div>
                        </a>
                    </figure>
                    <figure class="gallery-item">
                        <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer">
                            <img src="{{ url('images/gallery/image-d2.jpeg') }}" alt="Wig service">
                            <div class="gallery-overlay"><i class="fab fa-instagram"></i></div>
                        </a>
                    </figure>
                    <figure class="gallery-item">
                        <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer">
                            <img src="{{ url('images/gallery/image-d3.jpeg') }}" alt="Makeup service">
                            <div class="gallery-overlay"><i class="fab fa-instagram"></i></div>
                        </a>
                    </figure>
                    <figure class="gallery-item">
                        <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer">
                            <img src="{{ url('images/gallery/image-d4.jpg') }}" alt="Beauty treatment">
                            <div class="gallery-overlay"><i class="fab fa-instagram"></i></div>
                        </a>
                    </figure>
                    <figure class="gallery-item">
                        <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer">
                            <img src="{{ url('images/gallery/image-p1.jpeg') }}" alt="Styling session">
                            <div class="gallery-overlay"><i class="fab fa-instagram"></i></div>
                        </a>
                    </figure>
                    <figure class="gallery-item">
                        <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer">
                            <img src="{{ url('images/gallery/image-p2.jpeg') }}" alt="Waxing service">
                            <div class="gallery-overlay"><i class="fab fa-instagram"></i></div>
                        </a>
                    </figure>
                    <figure class="gallery-item">
                        <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer">
                            <img src="{{ url('images/gallery/image-p3.jpeg') }}" alt="Hair treatment">
                            <div class="gallery-overlay"><i class="fab fa-instagram"></i></div>
                        </a>
                    </figure>
                    <figure class="gallery-item">
                        <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer">
                            <img src="{{ url('images/gallery/image-p4.jpeg') }}" alt="Beauty makeover">
                            <div class="gallery-overlay"><i class="fab fa-instagram"></i></div>
                        </a>
                    </figure>
                </div>
            </div>
        </section>

        <!-- FAQs Section -->
        <section id="faqs" class="faq-section">
            <div class="faq-container">
                <h2 class="faq-title">Frequently Asked Questions</h2>
                <div class="faq-accordion">
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            How much do you charge for braid removal?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>Braid removal costs <strong>£60</strong> and takes approximately <strong>1 hour 45 minutes</strong>.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            What is the difference between Virgin Relaxer and Regular Relaxer?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p><strong>Virgin Hair Relaxer</strong> — £120 (2 hours) for hair that has never been chemically treated.<br>
                            <strong>Regular Relaxer</strong> — £80 (2 hours) for previously relaxed hair.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            Do I need clean hair for Sleek Ponytail?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>Yes. For Sleek Ponytail (£75), please come with <strong>no products in your hair</strong> for best results.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            When should I drop hair for wig making?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>Drop hair <strong>3–5 weekdays</strong> before appointment. Late drop-off after 3pm on day 3 incurs a <strong>£15 fee</strong>.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            What is included in closure and frontal wig services?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>Includes:</p>
                            <ul>
                                <li>Bleaching knots</li>
                                <li>Plucking</li>
                                <li>Wig making</li>
                            </ul>
                            <p>Installation must be added as an add-on.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            What if my appointment is on Monday?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>Hair must be dropped by <strong>Thursday</strong>. Otherwise, a <strong>£10 fee</strong> applies.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            What are your frontal and closure replacement prices?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>Frontal replacement — <strong>£110</strong><br>
                            Closure replacement — <strong>£85</strong><br>
                            Wig must be dropped 3–5 days before appointment.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            Do you offer waxing services?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>Yes — Bikini £30 • G-String £36 • Brazilian £45 • Hollywood £45<br>
                            Underarm £15 • Forearm £15 • Half Leg £25 • Full Leg £35</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            Do you offer revamps and braids?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>Revamp — from <strong>£50</strong><br>
                            Braids — from <strong>£120</strong></p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            What are your working hours?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <ul class="hours-list">
                                <li>Monday: 9 AM - 6 PM</li>
                                <li>Tuesday: 9 AM - 6 PM</li>
                                <li>Wednesday: 9 AM - 6 PM</li>
                                <li>Thursday: 9 AM - 6 PM</li>
                                <li>Friday: 9 AM - 6 PM</li>
                                <li>Saturday: 9 AM - 8 PM</li>
                                <li>Sunday: Subject to Availability</li>
                            </ul>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="false">
                            How can I book an appointment?
                            <span class="faq-icon"><i class="fas fa-plus"></i></span>
                        </button>
                        <div class="faq-answer">
                            <p>You can book an appointment via our <a href="{{ route('book.appointment') }}">appointment page</a> or contact us directly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact-us" class="contact-section">
            <div class="contact-container">
                <h2 class="contact-title">Contact Us</h2>
                <p class="contact-subtitle">We'd love to hear from you</p>
                <div class="contact-info-wrapper">
                    <div class="contact-info-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pricelessbeautytouch@gmail.com">pricelessbeautytouch@gmail.com</a>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-phone-alt"></i>
                        <a href="tel:+447369277963">+44 7369 277963</a>
                    </div>
                </div>
                <div class="contact-social">
                    <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer" class="social-link instagram">
                        <i class="fab fa-instagram"></i> Follow us on Instagram
                    </a>
                </div>
            </div>
        </section>
        
    </article>
</main>
@endsection