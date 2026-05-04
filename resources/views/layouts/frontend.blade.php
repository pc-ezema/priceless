<!DOCTYPE html>
<html lang="en-GB">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Primary SEO Tags --}}
    <title>{{ $seo_title ?? config('app.name') . ' - Luxury Beauty & Spa' }}</title>
    <meta name="description" content="{{ $seo_description ?? 'Professional beauty services including hair styling, waxing, wigs, and makeup in London. Book your appointment today.' }}">
    <meta name="keywords" content="{{ $seo_keywords ?? 'beauty salon, spa, hair styling, makeup, waxing, wigs, london beauty' }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="robots" content="index, follow">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Alternate URLs for sections (for one-page site) --}}
    <link rel="alternate" href="{{ url('/#about-us') }}" />
    <link rel="alternate" href="{{ url('/#services') }}" />
    <link rel="alternate" href="{{ url('/#gallery') }}" />
    <link rel="alternate" href="{{ url('/#faqs') }}" />
    <link rel="alternate" href="{{ url('/#contact-us') }}" />
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seo_og_title ?? $seo_title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $seo_og_description ?? $seo_description ?? 'Professional beauty services in London' }}">
    <meta property="og:image" content="{{ $seo_og_image ?? url('images/og-image.jpg') }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo_twitter_title ?? $seo_title ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $seo_twitter_description ?? $seo_description ?? 'Professional beauty services in London' }}">
    <meta name="twitter:image" content="{{ $seo_twitter_image ?? url('images/logo.png') }}">

    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Google Fonts: Elegant & Feminine -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 (Free Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('images/logo.png') }}">

    <!-- Core Stylesheet (No inline styles, all external) -->
    <link rel="stylesheet" href="{{ url('css/app.css') }}">

    <!-- Local Business Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BeautySalon",
        "name": "Priceless Beauty Touch",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Ashford",
            "addressRegion": "Kent",
            "addressCountry": "UK"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 51.1465,
            "longitude": 0.8736
        },
        "priceRange": "££",
        "telephone": "+447369277963",
        "openingHours": "Mo-Fr 09:00-18:00, Sa 09:00-20:00"
    }
    </script>

    <!-- Location meta tags -->
    <meta name="geo.region" content="GB-KEN">
    <meta name="geo.placename" content="Ashford">
    <meta name="geo.position" content="51.1465;0.8736">
    <meta name="ICBM" content="51.1465, 0.8736">

    @stack('styles')
</head>

<body class="antialiased">
    <div id="app">
        @include('layouts.header')
        <main class="main-content">
            @yield('page-content')
        </main>
        @include('layouts.footer')
    </div>

    <!-- Core JavaScript -->
    <script src="{{ url('js/app.js') }}" defer></script>
    @stack('scripts')
</body>

</html>