<header class="site-header" id="siteHeader">
    <div class="container header-container">
        <!-- Brand Logo / Wordmark -->
        <div class="brand-logo">
            <a href="{{ route('home') }}" aria-label="Homepage">
                <img src="{{ url('images/logo.png') }}" alt="{{ config('app.name') }} - Luxury Beauty Logo" class="logo-img">
            </a>
        </div>

        <!-- Desktop Navigation (Modern Minimal) -->
        <nav class="desktop-nav" aria-label="Main Navigation">
            <ul class="nav-menu">
                <li class="nav-item"><a href="{{ route('home') }}#about-us" class="nav-link">About</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#services" class="nav-link">Services</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#gallery" class="nav-link">Gallery</a></li>
                <li class="nav-item"><a href="{{ route('book.appointment') }}" class="nav-link">Book</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#faqs" class="nav-link">FAQs</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#contact-us" class="nav-link">Contact</a></li>
            </ul>
        </nav>

        <!-- CTA Button & Mobile Toggle -->
        <div class="header-actions">
            <a href="{{ route('book.appointment') }}" class="btn-primary btn-small">Reserve Now</a>
            <button class="mobile-toggle" id="mobileToggle" aria-label="Menu" aria-expanded="false">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation (Overlay style) -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay">
        <div class="mobile-nav-container">
            <button class="mobile-close" id="mobileClose" aria-label="Close Menu">
                <i class="fas fa-times"></i>
            </button>
            <ul class="mobile-nav-menu">
                <li><a href="{{ route('home') }}#about-us" class="mobile-nav-link">About</a></li>
                <li><a href="{{ route('home') }}#services" class="mobile-nav-link">Services</a></li>
                <li><a href="{{ route('home') }}#gallery" class="mobile-nav-link">Gallery</a></li>
                <li><a href="{{ route('book.appointment') }}" class="mobile-nav-link">Book Appointment</a></li>
                <li><a href="{{ route('home') }}#faqs" class="mobile-nav-link">FAQs</a></li>
                <li><a href="{{ route('home') }}#contact-us" class="mobile-nav-link">Contact</a></li>
            </ul>
            <div class="mobile-social">
                <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                <a href="mailto:pricelessbeautytouch@gmail.com"><i class="fas fa-envelope"></i></a>
                <a href="tel:+447956403572"><i class="fas fa-phone-alt"></i></a>
            </div>
        </div>
    </div>
</header>