<footer class="site-footer">
    <div class="container">
        <!-- Main Footer Grid -->
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-col brand-col">
                <img src="{{ url('images/logo.png') }}" alt="{{ config('app.name') }}" class="footer-logo">
                <p class="footer-tagline">Where beauty meets tranquility. Luxury spa & holistic wellness tailored to you.</p>
                <div class="footer-social-links">
                    <a href="https://instagram.com/pricelessbeautytouch1" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="mailto:pricelessbeautytouch@gmail.com" aria-label="Email"><i class="fas fa-envelope"></i></a>
                    <a href="tel:+447956403572" aria-label="Phone"><i class="fas fa-phone-alt"></i></a>
                    <a href="#" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            <!-- Explore Links -->
            <div class="footer-col">
                <h4 class="footer-title">Explore</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}#about-us">Our Story</a></li>
                    <li><a href="{{ route('home') }}#services">Treatments</a></li>
                    <li><a href="{{ route('home') }}#gallery">Moments</a></li>
                    <li><a href="{{ route('book.appointment') }}">Booking</a></li>
                </ul>
            </div>

            <!-- Hours Column -->
            <div class="footer-col">
                <h4 class="footer-title">Serenity Hours</h4>
                <ul class="footer-hours">
                    <li><span>Mon - Fri:</span> 9:00 AM - 7:00 PM</li>
                    <li><span>Saturday:</span> 9:00 AM - 8:00 PM</li>
                    <li><span>Sunday:</span> 10:00 AM - 5:00 PM</li>
                    <li class="special-note">*Appointments recommended</li>
                </ul>
            </div>

            <!-- Newsletter / Contact Quick -->
            <div class="footer-col">
                <h4 class="footer-title">Indulge your inbox</h4>
                <p class="newsletter-text">Receive exclusive offers & wellness tips.</p>
                <form class="newsletter-form" id="newsletterForm" action="#" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="email" placeholder="Your email address" required aria-label="Email for newsletter">
                        <button type="submit" aria-label="Subscribe"><i class="fas fa-arrow-right"></i></button>
                    </div>
                </form>
                <p class="footer-note">Visit us: 123 Luxury Lane, Mayfair, London</p>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Priceless Beauty Touch') }}. All rights reserved. <br class="mobile-break"> Designed with <i class="fas fa-heart" style="color: #d4af7a;"></i> for elegance.</p>
        </div>
    </div>
</footer>