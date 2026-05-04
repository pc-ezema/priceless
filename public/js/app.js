// =============================================
// FILE: public/js/app.js
// PRICELESS BEAUTY TOUCH - COMPLETE JAVASCRIPT
// =============================================

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // ---------- MOBILE MENU LOGIC ----------
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');
    const mobileClose = document.getElementById('mobileClose');
    
    function openMobileMenu() {
        if (mobileNavOverlay) {
            mobileNavOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            if(mobileToggle) mobileToggle.setAttribute('aria-expanded', 'true');
        }
    }
    
    function closeMobileMenu() {
        if (mobileNavOverlay) {
            mobileNavOverlay.classList.remove('active');
            document.body.style.overflow = '';
            if(mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
        }
    }
    
    if(mobileToggle) {
        mobileToggle.addEventListener('click', openMobileMenu);
    }
    if(mobileClose) {
        mobileClose.addEventListener('click', closeMobileMenu);
    }
    
    // Close overlay when clicking on a link
    const mobileLinks = document.querySelectorAll('.mobile-nav-link');
    mobileLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });
    
    // Escape key closes menu
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape' && mobileNavOverlay?.classList.contains('active')) {
            closeMobileMenu();
        }
    });
    
    // ---------- HEADER SCROLL EFFECT ----------
    const header = document.querySelector('.site-header');
    let lastScroll = 0;
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        if (header) {
            if (currentScroll > 50) {
                header.style.padding = '0';
                header.style.background = 'rgba(255, 253, 248, 0.98)';
            } else {
                header.style.padding = '';
                header.style.background = 'rgba(255, 253, 248, 0.92)';
            }
        }
        lastScroll = currentScroll;
    });
    
    // ---------- NEWSLETTER FORM SUBMIT ----------
    const newsletterForm = document.getElementById('newsletterForm');
    if(newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput ? emailInput.value.trim() : '';
            if(email && email.includes('@')) {
                alert('✨ Thank you, beauty! You\'ll receive exclusive updates at ' + email + '.');
                emailInput.value = '';
            } else {
                alert('Please enter a valid email address to receive serenity.');
            }
        });
    }
    
    // ---------- ACTIVE NAVIGATION LINK (based on scroll position) ----------
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    
    function updateActiveLink() {
        let current = '';
        const scrollPos = window.scrollY + 120;
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            if(scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if(href && href.includes(current) && current !== '') {
                link.classList.add('active');
            }
        });
    }
    
    window.addEventListener('scroll', updateActiveLink);
    window.addEventListener('load', updateActiveLink);
    
    // ---------- SMOOTH SCROLL FOR ANCHOR LINKS ----------
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if(targetId === "#" || targetId === "") return;
            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                // Update URL without jumping
                history.pushState(null, null, targetId);
            }
        });
    });
    
    // ---------- FAQ ACCORDION ----------
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(button => {
        button.addEventListener('click', () => {
            const faqItem = button.parentElement;
            const isOpen = faqItem.classList.contains('active');
            
            // Close all other FAQ items
            document.querySelectorAll('.faq-item').forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('active');
                    const otherButton = item.querySelector('.faq-question');
                    if (otherButton) otherButton.setAttribute('aria-expanded', 'false');
                }
            });
            
            // Toggle current item
            if (!isOpen) {
                faqItem.classList.add('active');
                button.setAttribute('aria-expanded', 'true');
            } else {
                faqItem.classList.remove('active');
                button.setAttribute('aria-expanded', 'false');
            }
        });
    });
    
    // ---------- SCROLL REVEAL ANIMATION FOR SERVICE CARDS ----------
    const serviceCards = document.querySelectorAll('.service-card');
    
    function checkCardVisibility() {
        serviceCards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight - 100 && rect.bottom > 0;
            if (isVisible && !card.classList.contains('animated')) {
                card.classList.add('animated');
            }
        });
    }
    
    window.addEventListener('scroll', checkCardVisibility);
    window.addEventListener('load', checkCardVisibility);
    
    // ---------- PARALLAX EFFECT FOR HERO SECTION (optional) ----------
    const heroSection = document.querySelector('.hero-section');
    if(heroSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            heroSection.style.backgroundPositionY = scrolled * 0.5 + 'px';
        });
    }
    
    // ---------- HOVER SCALE EFFECT FOR BUTTONS ----------
    const hoverButtons = document.querySelectorAll('[data-hover-scale]');
    hoverButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // ---------- GALLERY IMAGE LIGHTBOX (Optional enhancement) ----------
    const galleryImages = document.querySelectorAll('.gallery-item img');
    galleryImages.forEach(img => {
        img.addEventListener('click', function(e) {
            // Prevent if clicking on the link directly
            if (e.target.closest('a')) return;
            
            // Create lightbox
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            lightbox.innerHTML = `
                <div class="lightbox-content">
                    <img src="${this.src}" alt="${this.alt}">
                    <button class="lightbox-close">&times;</button>
                </div>
            `;
            document.body.appendChild(lightbox);
            document.body.style.overflow = 'hidden';
            
            // Close lightbox
            const closeBtn = lightbox.querySelector('.lightbox-close');
            closeBtn.addEventListener('click', () => {
                lightbox.remove();
                document.body.style.overflow = '';
            });
            
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    lightbox.remove();
                    document.body.style.overflow = '';
                }
            });
        });
    });
    
    // ---------- ADD LIGHTBOX STYLES DYNAMICALLY ----------
    const lightboxStyles = document.createElement('style');
    lightboxStyles.textContent = `
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            cursor: pointer;
        }
        .lightbox-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
        }
        .lightbox-content img {
            width: auto;
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 8px;
        }
        .lightbox-close {
            position: absolute;
            top: -40px;
            right: -40px;
            background: none;
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .lightbox-close:hover {
            transform: scale(1.1);
        }
        @media (max-width: 768px) {
            .lightbox-close {
                top: -30px;
                right: 0;
            }
        }
    `;
    document.head.appendChild(lightboxStyles);
    
    // ---------- PRELOAD IMAGES FOR BETTER PERFORMANCE ----------
    const imagesToPreload = document.querySelectorAll('.gallery-item img, .about-image img');
    imagesToPreload.forEach(img => {
        const src = img.getAttribute('src');
        if (src) {
            const preloader = new Image();
            preloader.src = src;
        }
    });
    
    // ---------- ADD SCROLL PROGRESS INDICATOR (Optional) ----------
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    document.body.appendChild(progressBar);
    
    const progressStyles = document.createElement('style');
    progressStyles.textContent = `
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            z-index: 1001;
            transition: width 0.1s ease;
        }
    `;
    document.head.appendChild(progressStyles);
    
    window.addEventListener('scroll', () => {
        const windowHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrolled = (window.scrollY / windowHeight) * 100;
        progressBar.style.width = scrolled + '%';
    });
    
    console.log('✨ Priceless Beauty Touch — Luxury Redefined ✨');
});

// ---------- BOOKING APPOINTMENT FORM HANDLER ----------
const appointmentForm = document.getElementById('appointmentForm');
if (appointmentForm) {
    appointmentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let submitBtn = document.getElementById('submitBtn');
        let btnText = submitBtn.querySelector('.btn-text');
        let btnLoader = submitBtn.querySelector('.btn-loader');
        let formMessage = document.getElementById('formMessage');

        // Show loading state
        btnText.style.display = 'none';
        btnLoader.style.display = 'inline-flex';
        submitBtn.disabled = true;

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            // Reset button state
            btnText.style.display = 'inline';
            btnLoader.style.display = 'none';
            submitBtn.disabled = false;

            if (data.status) {
                formMessage.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> ${data.message}
                    </div>
                `;
                
                // Scroll to message
                formMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Optional: Clear form on success
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        // Reset the entire form
                        resetAppointmentForm();
                    }
                }, 2000);
            } else {
                formMessage.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> ${data.message || 'Something went wrong!'}
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btnText.style.display = 'inline';
            btnLoader.style.display = 'none';
            submitBtn.disabled = false;

            formMessage.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> Network error! Please check your connection and try again.
                </div>
            `;
        });
    });
}

// Complete reset function for appointment form
function resetAppointmentForm() {
    // Reset standard form fields
    const form = document.getElementById('appointmentForm');
    if (form) {
        form.reset();
    }
    
    // Reset add-on checkboxes
    document.querySelectorAll('.custom-checkbox input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Clear add-ons summary
    const addonsSummary = document.getElementById('addonsSummary');
    if (addonsSummary) {
        addonsSummary.style.display = 'none';
    }
    
    const selectedAddonsList = document.getElementById('selectedAddonsList');
    if (selectedAddonsList) {
        selectedAddonsList.innerHTML = '';
    }
    
    const addonsTotalPrice = document.getElementById('addonsTotalPrice');
    if (addonsTotalPrice) {
        addonsTotalPrice.textContent = '£0.00';
    }
    
    // Reset calendar selection
    if (window.appointmentCalendar) {
        window.appointmentCalendar.selectedDate = null;
        window.appointmentCalendar.selectedTimeSlot = null;
        window.appointmentCalendar.currentDate = new Date();
        window.appointmentCalendar.renderCalendar();
    }
    
    // Clear date display
    const selectedDateDisplay = document.getElementById('selectedDateDisplay');
    if (selectedDateDisplay) {
        selectedDateDisplay.textContent = 'Select a date';
    }
    
    // Clear selected date hidden field
    const selectedDate = document.getElementById('selectedDate');
    if (selectedDate) {
        selectedDate.value = '';
    }
    
    // Hide and clear time slots container
    const timeSlotsContainer = document.getElementById('timeSlotsContainer');
    if (timeSlotsContainer) {
        timeSlotsContainer.style.display = 'none';
    }
    
    const timeSlotsGrid = document.getElementById('timeSlotsGrid');
    if (timeSlotsGrid) {
        timeSlotsGrid.innerHTML = '';
    }
    
    // Clear time selection hidden fields
    const selectedTimeSlot = document.getElementById('selectedTimeSlot');
    if (selectedTimeSlot) {
        selectedTimeSlot.value = '';
    }
    
    const selectedTimeDisplay = document.getElementById('selectedTimeDisplay');
    if (selectedTimeDisplay) {
        selectedTimeDisplay.value = '';
    }
    
    const appointmentTime = document.querySelector('input[name="appointment_time"]');
    if (appointmentTime) {
        appointmentTime.value = '';
    }
    
    // Remove any selected time display
    const selectedTimeDisplayArea = document.querySelector('.selected-time-display');
    if (selectedTimeDisplayArea) {
        selectedTimeDisplayArea.remove();
    }
    
    // Remove selected class from any selected calendar days
    document.querySelectorAll('.calendar-day.selected').forEach(day => {
        day.classList.remove('selected');
    });
    
    // Remove selected class from any selected time slots
    document.querySelectorAll('.time-slot-10min.selected').forEach(slot => {
        slot.classList.remove('selected');
    });
    
    // Reset service selection dropdown
    const serviceSelect = document.getElementById('service');
    if (serviceSelect) {
        serviceSelect.selectedIndex = 0;
    }
    
    // Reset service summary if exists
    const serviceSummary = document.querySelector('.service-summary');
    if (serviceSummary) {
        serviceSummary.style.display = 'none';
    }
    
    // Clear any error messages
    document.querySelectorAll('.error-message').forEach(error => {
        error.classList.remove('show');
        error.innerHTML = '';
    });
}

// Set minimum date to today for date picker
const dateInput = document.getElementById('appointment_date');
if (dateInput) {
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
}

// ============================================
// ADMIN LOGIN HANDLER
// ============================================

// Password Toggle Functionality
const togglePasswordBtn = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

if (togglePasswordBtn && passwordInput) {
    togglePasswordBtn.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle eye icon
        const icon = this.querySelector('i');
        if (icon) {
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    });
}

// Admin Login Form Submission
const adminLoginForm = document.getElementById('adminLoginForm');
const loginBtn = document.getElementById('loginBtn');
const loginMessage = document.getElementById('loginMessage');

if (adminLoginForm) {
    adminLoginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        if (loginBtn) {
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;
        }
        
        // Clear previous messages
        if (loginMessage) {
            loginMessage.innerHTML = '';
        }
        
        const formData = new FormData(this);
        
        fetch('/ajax/login', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Show success message
                if (loginMessage) {
                    loginMessage.innerHTML = `<div class="success"><i class="fas fa-check-circle"></i> ${data.message || 'Login successful! Redirecting...'}</div>`;
                }
                // Redirect after short delay
                setTimeout(() => {
                    window.location.href = data.redirect || '/admin/dashboard';
                }, 1000);
            } else {
                // Show error message
                if (loginMessage) {
                    loginMessage.innerHTML = `<div class="error"><i class="fas fa-exclamation-circle"></i> ${data.message || 'Invalid credentials. Please try again.'}</div>`;
                }
                // Reset button state
                if (loginBtn) {
                    loginBtn.classList.remove('loading');
                    loginBtn.disabled = false;
                }
                // Clear password field for security
                if (passwordInput) {
                    passwordInput.value = '';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (loginMessage) {
                loginMessage.innerHTML = `<div class="error"><i class="fas fa-exclamation-circle"></i> Network error. Please check your connection and try again.</div>`;
            }
            if (loginBtn) {
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;
            }
        });
    });
}

// Optional: Add enter key support for form submission
if (adminLoginForm) {
    adminLoginForm.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.click();
            }
        }
    });
}


// ============================================
// ADMIN DASHBOARD HANDLER
// ============================================

// ============================================
// DASHBOARD STATS - UPDATED VERSION
// ============================================

(function() {
    'use strict';
    
    // Only run on dashboard page
    if (!document.querySelector('.admin-dashboard-page')) return;
    
    console.log('Dashboard page detected');
    
    async function loadDashboardStats() {
        try {
            console.log('Fetching dashboard stats...');
            
            const response = await fetch('/dashboard/stats', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Cache-Control': 'no-cache'
                },
                credentials: 'same-origin'
            });
            
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            console.log('Stats received:', data);
            
            // Update DOM elements
            const todayEl = document.getElementById('todayAppointments');
            const pendingEl = document.getElementById('pendingAppointments');
            const customersEl = document.getElementById('totalCustomers');
            const weeklyEl = document.getElementById('weeklyAppointments');
            
            if (todayEl) todayEl.textContent = data.today_appointments ?? '0';
            if (pendingEl) pendingEl.textContent = data.pending_appointments ?? '0';
            if (customersEl) customersEl.textContent = data.total_customers ?? '0';
            if (weeklyEl) weeklyEl.textContent = data.weekly_appointments ?? '0';
            
            // Also update any additional stats if they exist
            const servicesEl = document.getElementById('totalServices');
            const addonsEl = document.getElementById('totalAddons');
            const revenueEl = document.getElementById('totalRevenue');

            
            if (servicesEl && data.total_services) servicesEl.textContent = data.total_services;
            if (addonsEl && data.total_addons) addonsEl.textContent = data.total_addons;
            if (revenueEl && data.total_revenue) revenueEl.textContent = '£' + data.total_revenue.toFixed(2);
            
        } catch (error) {
            console.error('Error loading dashboard stats:', error);
            // Keep existing values or show error indicator
            const errorDiv = document.createElement('div');
            errorDiv.className = 'stats-error';
            errorDiv.textContent = 'Failed to load stats';
            errorDiv.style.cssText = 'position: fixed; bottom: 20px; left: 20px; background: #f44336; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; z-index: 9999;';
            document.body.appendChild(errorDiv);
            setTimeout(() => errorDiv.remove(), 5000);
        }
    }
    
    // Load stats immediately
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadDashboardStats);
    } else {
        loadDashboardStats();
    }
    
    // Refresh every 30 seconds
    setInterval(loadDashboardStats, 30000);
})();

// Handle logout with confirmation and loading state
const logoutForm = document.getElementById('logoutForm');
const logoutBtn = document.getElementById('logoutBtn');

if (logoutForm && logoutBtn) {
    logoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show confirmation dialog
        if (confirm('Are you sure you want to logout? You will be redirected to the login page.')) {
            // Create loading overlay
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'logout-loading';
            loadingOverlay.innerHTML = `
                <div class="spinner"></div>
                <p>Logging out securely...</p>
            `;
            document.body.appendChild(loadingOverlay);
            
            // Submit the form via fetch
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                // Redirect to home page regardless of response
                window.location.href = '/';
            })
            .catch(error => {
                console.error('Logout error:', error);
                // Still redirect on error
                window.location.href = '/';
            });
        }
    });
}

// Add ripple effect to cards
const cards = document.querySelectorAll('[data-hover="ripple"]');
cards.forEach(card => {
    card.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const ripple = document.createElement('span');
        ripple.className = 'ripple-effect';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        
        this.style.position = 'relative';
        this.style.overflow = 'hidden';
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Add ripple styles dynamically
const rippleStyles = document.createElement('style');
rippleStyles.textContent = `
    .ripple-effect {
        position: absolute;
        width: 100px;
        height: 100px;
        background: rgba(179, 125, 151, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(rippleStyles);

// Load dashboard stats when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardStats();
    
    // Refresh stats every 30 seconds if page is visible
    let intervalId;
    
    function startStatsRefresh() {
        intervalId = setInterval(() => {
            if (document.visibilityState === 'visible') {
                loadDashboardStats();
            }
        }, 30000);
    }
    
    function stopStatsRefresh() {
        if (intervalId) {
            clearInterval(intervalId);
        }
    }
    
    startStatsRefresh();
    
    // Stop refresh when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopStatsRefresh();
        } else {
            startStatsRefresh();
            loadDashboardStats(); // Immediate refresh when tab becomes visible
        }
    });
});

// Add welcome message with admin name
const adminNameElement = document.querySelector('.dash-title');
if (adminNameElement) {
    const adminName = localStorage.getItem('admin_name') || 'Admin';
    adminNameElement.textContent = `Welcome Back, ${adminName}`;
}

// ============================================
// SERVICES MANAGEMENT - COMPLETE WORKING
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Only run on services page
    if (!document.querySelector('.admin-services-page')) return;
    
    console.log('Services management initialized');
    
    // ============================================
    // NOTIFICATION FUNCTION
    // ============================================
    
    function showNotification(message, type = 'success') {
        const existing = document.querySelector('.service-notification');
        if (existing) existing.remove();
        
        const notification = document.createElement('div');
        notification.className = 'service-notification';
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            min-width: 300px;
            background: ${type === 'success' ? '#4caf50' : '#f44336'};
            color: white;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            z-index: 10001;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        `;
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i> ${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) notification.remove();
        }, 3000);
    }
    
    // ============================================
    // UPDATE CATEGORY COUNTS
    // ============================================
    
    function updateCategoryCounts() {
        const sections = document.querySelectorAll('.services-category-section');
        sections.forEach(section => {
            const rows = section.querySelectorAll('tbody tr');
            const count = rows.length;
            const countSpan = section.querySelector('.category-count');
            if (countSpan) {
                countSpan.textContent = `${count} service${count !== 1 ? 's' : ''}`;
            }
        });
    }
    
    // ============================================
    // UPDATE STATS
    // ============================================
    
    function updateStats() {
        const rows = document.querySelectorAll('.services-table tbody tr');
        const total = rows.length;
        const active = document.querySelectorAll('.status-badge.active').length;
        const categories = document.querySelectorAll('.services-category-section').length;
        
        const totalStat = document.querySelector('.services-stats .stat-card:first-child .stat-value');
        const activeStat = document.querySelectorAll('.services-stats .stat-card')[1]?.querySelector('.stat-value');
        const categoryStat = document.querySelectorAll('.services-stats .stat-card')[2]?.querySelector('.stat-value');
        
        if (totalStat) totalStat.textContent = total;
        if (activeStat) activeStat.textContent = active;
        if (categoryStat) categoryStat.textContent = categories;
    }
    
    // ============================================
    // DELETE FUNCTIONALITY
    // ============================================
    
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteModal = document.getElementById('deleteModal');
    let serviceToDelete = null;
    
    // Open modal when delete button is clicked
    if (deleteButtons.length) {
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                serviceToDelete = this.dataset.id;
                const serviceName = this.dataset.name;
                
                const deleteServiceName = document.getElementById('deleteServiceName');
                if (deleteServiceName) {
                    deleteServiceName.textContent = serviceName;
                }
                
                if (deleteModal) {
                    deleteModal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            });
        });
    }
    
    // Close modal function
    function closeModal() {
        if (deleteModal) {
            deleteModal.style.display = 'none';
            document.body.style.overflow = '';
        }
        serviceToDelete = null;
    }
    
    // Modal close handlers
    const modalClose = document.querySelector('#deleteModal .modal-close');
    const modalCancel = document.querySelector('#deleteModal .modal-cancel');
    const modalConfirm = document.querySelector('#deleteModal .modal-confirm');
    
    if (modalClose) modalClose.addEventListener('click', closeModal);
    if (modalCancel) modalCancel.addEventListener('click', closeModal);
    
    // Close modal when clicking outside
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) closeModal();
        });
    }
    
    // Confirm delete
    if (modalConfirm) {
        modalConfirm.addEventListener('click', async function() {
            if (!serviceToDelete) return;
            
            const originalText = modalConfirm.innerHTML;
            modalConfirm.disabled = true;
            modalConfirm.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
            
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                                  document.querySelector('input[name="_token"]')?.value;
                
                const response = await fetch(`/dashboard/services/${serviceToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    const row = document.querySelector(`tr[data-service-id="${serviceToDelete}"]`);
                    if (row) {
                        const section = row.closest('.services-category-section');
                        row.remove();
                        if (section && section.querySelectorAll('tbody tr').length === 0) {
                            section.remove();
                        }
                    }
                    
                    showNotification(data.message || 'Service deleted successfully!', 'success');
                    updateCategoryCounts();
                    updateStats();
                    closeModal();
                } else {
                    showNotification(data.message || 'Error deleting service', 'error');
                }
            } catch (error) {
                console.error('Delete error:', error);
                showNotification('Network error. Please try again.', 'error');
            } finally {
                modalConfirm.disabled = false;
                modalConfirm.innerHTML = originalText;
            }
        });
    }
    
    // ============================================
    // STATUS TOGGLE FUNCTIONALITY
    // ============================================
    
    const statusToggles = document.querySelectorAll('.status-toggle');
    
    if (statusToggles.length) {
        statusToggles.forEach(toggle => {
            toggle.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const serviceId = this.dataset.id;
                const badge = this.querySelector('.status-badge');
                const originalText = badge?.textContent;
                const originalClass = badge?.className;
                
                // Show loading state
                if (badge) {
                    badge.style.opacity = '0.7';
                    badge.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                }
                
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                                      document.querySelector('input[name="_token"]')?.value;
                    
                    const response = await fetch(`/dashboard/services/${serviceId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ _method: 'PATCH' })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        if (badge) {
                            badge.style.opacity = '1';
                            if (data.is_active) {
                                badge.textContent = 'Active';
                                badge.classList.remove('inactive');
                                badge.classList.add('active');
                                this.dataset.active = 'true';
                            } else {
                                badge.textContent = 'Inactive';
                                badge.classList.remove('active');
                                badge.classList.add('inactive');
                                this.dataset.active = 'false';
                            }
                        }
                        showNotification(data.message || 'Service status updated!', 'success');
                        updateStats();
                    } else {
                        if (badge) {
                            badge.style.opacity = '1';
                            badge.textContent = originalText;
                            badge.className = originalClass;
                        }
                        showNotification(data.message || 'Error updating status', 'error');
                    }
                } catch (error) {
                    console.error('Status update error:', error);
                    if (badge) {
                        badge.style.opacity = '1';
                        badge.textContent = originalText;
                        badge.className = originalClass;
                    }
                    showNotification('Network error. Please try again.', 'error');
                }
            });
        });
    }
    
    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && deleteModal && deleteModal.style.display === 'flex') {
            closeModal();
        }
    });
});

// ============================================
// APPOINTMENTS MANAGEMENT HANDLER
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('statusModal');
    const closeModal = document.querySelector('#statusModal .modal-close');
    const modalCancel = document.querySelector('#statusModal .modal-cancel');
    const appointmentIdInput = document.getElementById('appointment_id');
    const statusSelect = document.getElementById('status');
    const appointmentCustomerName = document.getElementById('appointmentCustomerName');
    const statusForm = document.getElementById('statusForm');
    const statusSubmit = document.getElementById('statusSubmit');

    // Open modal when clicking change status button
    const changeStatusBtns = document.querySelectorAll('.change-status-btn');
    changeStatusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const appointmentId = this.dataset.id;
            const currentStatus = this.dataset.current;
            const customerName = this.dataset.name;
            
            if (appointmentIdInput) appointmentIdInput.value = appointmentId;
            if (statusSelect) statusSelect.value = currentStatus;
            if (appointmentCustomerName) appointmentCustomerName.textContent = customerName;
            
            if (modal) modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal function
    function closeStatusModal() {
        if (modal) modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Close modal events
    if (closeModal) closeModal.addEventListener('click', closeStatusModal);
    if (modalCancel) modalCancel.addEventListener('click', closeStatusModal);
    
    // Click outside modal to close
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeStatusModal();
        });
    }

    // Escape key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            closeStatusModal();
        }
    });

    // Handle status update form submission
    if (statusForm) {
        statusForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const appointmentId = appointmentIdInput?.value;
            const status = statusSelect?.value;
            const csrfToken = document.querySelector('input[name="_token"]')?.value;
            
            if (!appointmentId || !status) return;
            
            // Show loading state
            const btnText = statusSubmit?.querySelector('.btn-text');
            const btnLoader = statusSubmit?.querySelector('.btn-loader');
            if (btnText) btnText.style.display = 'none';
            if (btnLoader) btnLoader.style.display = 'inline-block';
            if (statusSubmit) statusSubmit.disabled = true;
            
            try {
                const response = await fetch(`/appointments/${appointmentId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ status: status })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    // Show success notification
                    showNotification('Appointment status updated successfully!', 'success');
                    
                    // Update the status badge in the table
                    const row = document.querySelector(`tr[data-appointment-id="${appointmentId}"]`);
                    if (row) {
                        const statusCell = row.querySelector('.status-badge');
                        if (statusCell) {
                            statusCell.className = `status-badge status-${status}`;
                            statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        }
                        
                        // Update the button data-current attribute
                        const updateBtn = row.querySelector('.change-status-btn');
                        if (updateBtn) {
                            updateBtn.dataset.current = status;
                        }
                    }
                    
                    // Update stats
                    updateAppointmentStats();
                    
                    // Close modal
                    closeStatusModal();
                } else {
                    showNotification(data.message || 'Something went wrong', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Network error. Please try again.', 'error');
            } finally {
                // Reset button state
                if (btnText) btnText.style.display = 'inline-block';
                if (btnLoader) btnLoader.style.display = 'none';
                if (statusSubmit) statusSubmit.disabled = false;
            }
        });
    }
});

// Helper function to update appointment stats
function updateAppointmentStats() {
    const rows = document.querySelectorAll('.appointments-table tbody tr:not(.empty-state)');
    let total = rows.length;
    let pending = 0;
    let confirmed = 0;
    let cancelled = 0;
    
    rows.forEach(row => {
        const statusBadge = row.querySelector('.status-badge');
        if (statusBadge) {
            const status = statusBadge.classList[1]?.replace('status-', '');
            if (status === 'pending') pending++;
            else if (status === 'confirmed') confirmed++;
            else if (status === 'cancelled') cancelled++;
        }
    });
    
    // Update stat values
    const totalStat = document.querySelector('.stat-card:first-child .stat-value');
    const pendingStat = document.querySelectorAll('.stat-card')[1]?.querySelector('.stat-value');
    const confirmedStat = document.querySelectorAll('.stat-card')[2]?.querySelector('.stat-value');
    const cancelledStat = document.querySelectorAll('.stat-card')[3]?.querySelector('.stat-value');
    
    if (totalStat) totalStat.textContent = total;
    if (pendingStat) pendingStat.textContent = pending;
    if (confirmedStat) confirmedStat.textContent = confirmed;
    if (cancelledStat) cancelledStat.textContent = cancelled;
}

// Helper function to show notifications (reuse the same one from services)
function showNotification(message, type = 'success') {
    const existingNotification = document.querySelector('.appointment-notification');
    if (existingNotification) existingNotification.remove();
    
    const notification = document.createElement('div');
    notification.className = `appointment-notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    notification.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        min-width: 300px;
        background: ${type === 'success' ? '#4caf50' : '#f44336'};
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        z-index: 10001;
        padding: 1rem 1.5rem;
        animation: slideInRight 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Handle add-ons selection and pricing
document.addEventListener('DOMContentLoaded', function() {
    const addonCheckboxes = document.querySelectorAll('.custom-checkbox input[type="checkbox"]');
    const addonsSummary = document.getElementById('addonsSummary');
    const selectedAddonsList = document.getElementById('selectedAddonsList');
    const addonsTotalPrice = document.getElementById('addonsTotalPrice');
    
    function updateAddonsSummary() {
        const selectedAddons = [];
        let totalPrice = 0;
        
        addonCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const label = checkbox.closest('.custom-checkbox');
                const addonName = checkbox.value;
                const priceText = label.querySelector('.addon-price')?.textContent || '';
                const priceMatch = priceText.match(/£([\d.]+)/);
                const price = priceMatch ? parseFloat(priceMatch[1]) : 0;
                
                selectedAddons.push({ name: addonName, price: price });
                totalPrice += price;
            }
        });
        
        if (selectedAddons.length > 0) {
            selectedAddonsList.innerHTML = selectedAddons.map(addon => `
                <div class="addon-item">
                    <span>${escapeHtml(addon.name)}</span>
                    <span>£${addon.price.toFixed(2)}</span>
                </div>
            `).join('');
            
            addonsTotalPrice.textContent = `£${totalPrice.toFixed(2)}`;
            addonsSummary.style.display = 'block';
        } else {
            addonsSummary.style.display = 'none';
        }
    }
    
    addonCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateAddonsSummary);
    });
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});

// ============================================
// APPOINTMENT CALENDAR 
// ============================================

class AppointmentCalendar {
    constructor() {
        this.currentDate = new Date();
        this.selectedDate = null;
        this.selectedTimeSlot = null;
        
        console.log('Calendar initialized');
        this.init();
    }
    
    init() {
        this.renderCalendar();
        this.attachEvents();
    }
    
    async renderCalendar() {
        const year = this.currentDate.getFullYear();
        const month = this.currentDate.getMonth();
        
        const calendarGrid = document.getElementById('calendarGrid');
        if (!calendarGrid) {
            console.error('Calendar grid not found!');
            return;
        }
        
        calendarGrid.innerHTML = '<div class="loading-calendar">Loading calendar...</div>';
        
        try {
            console.log(`Fetching slots for month: ${month + 1}, year: ${year}`);
            const response = await fetch(`/available-slots?month=${month + 1}&year=${year}`);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const calendarData = await response.json();
            console.log('Calendar data received:', calendarData);
            
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            document.getElementById('currentMonthYear').textContent = `${monthNames[month]} ${year}`;
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const prevMonthDays = new Date(year, month, 0).getDate();
            
            let calendarHTML = '';
            
            // Previous month days
            for (let i = firstDay - 1; i >= 0; i--) {
                const day = prevMonthDays - i;
                calendarHTML += `<div class="calendar-day other-month disabled">${day}</div>`;
            }
            
            // Current month days
            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const hasSlots = calendarData[dateString]?.has_slots || false;
                const isPast = new Date(year, month, day) < new Date(new Date().setHours(0, 0, 0, 0));
                
                let classes = 'calendar-day';
                if (isPast) {
                    classes += ' disabled';
                } else if (hasSlots) {
                    classes += ' available';
                }
                
                if (this.selectedDate === dateString) {
                    classes += ' selected';
                }
                
                calendarHTML += `<div class="${classes}" data-date="${dateString}">${day}</div>`;
            }
            
            // Next month days
            const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
            const remainingCells = totalCells - (firstDay + daysInMonth);
            for (let i = 1; i <= remainingCells; i++) {
                calendarHTML += `<div class="calendar-day other-month disabled">${i}</div>`;
            }
            
            calendarGrid.innerHTML = calendarHTML;
            
            // Attach click events
            const availableDays = document.querySelectorAll('.calendar-day.available');
            console.log(`Found ${availableDays.length} available days`);
            
            availableDays.forEach(day => {
                day.addEventListener('click', () => {
                    console.log('Day clicked:', day.dataset.date);
                    this.selectDate(day.dataset.date);
                });
            });
            
            if (availableDays.length === 0) {
                console.log('No available days found. Make sure you have time slots created in the database.');
            }
            
        } catch (error) {
            console.error('Error loading calendar:', error);
            calendarGrid.innerHTML = '<div class="error-calendar">Error loading calendar. Please refresh.</div>';
        }
    }
    
    async selectDate(date) {
        console.log('Selecting date:', date);
        
        // Remove previous selection
        document.querySelectorAll('.calendar-day.selected').forEach(day => {
            day.classList.remove('selected');
        });
        
        const selectedDay = document.querySelector(`.calendar-day[data-date="${date}"]`);
        if (selectedDay) {
            selectedDay.classList.add('selected');
        }
        
        this.selectedDate = date;
        document.getElementById('selectedDate').value = date;
        console.log('Selected date set to:', date);
        
        await this.loadTimeSlots(date);
        
        const timeSlotsContainer = document.getElementById('timeSlotsContainer');
        if (timeSlotsContainer) {
            timeSlotsContainer.style.display = 'block';
            console.log('Time slots container shown');
        }
    }
    
    async loadTimeSlots(date) {
        console.log('Loading time slots for date:', date);
        const timeSlotsGrid = document.getElementById('timeSlotsGrid');
        if (!timeSlotsGrid) {
            console.error('Time slots grid not found!');
            return;
        }
        
        timeSlotsGrid.innerHTML = '<div class="loading-slots"><i class="fas fa-spinner fa-spin"></i><br>Loading available times...</div>';
        
        try {
            const response = await fetch(`/slots/${date}`);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const data = await response.json();
            const slots = data.slots || data;
            
            console.log('Time slots received:', slots);
            
            if (slots.length === 0) {
                timeSlotsGrid.innerHTML = `
                    <div class="no-slots">
                        <i class="fas fa-calendar-times"></i>
                        No available time slots for this date
                        <br><small>Please select another date</small>
                    </div>
                `;
                return;
            }
            
            let slotsHTML = '';
            slots.forEach(slot => {
                const isAvailable = slot.is_available;

                slotsHTML += `
                    <div class="time-slot-10min ${isAvailable ? 'available' : 'booked'}" 
                        data-slot-id="${slot.id}" 
                        data-time-slot-id="${slot.time_slot_id}"
                        data-start-time="${slot.start_time}"
                        data-start-display="${slot.start_display}"
                        ${isAvailable ? 'data-available="true"' : ''}>
                        <span class="slot-time">${slot.start_display}</span>
                        ${isAvailable ? 
                            '<span class="slot-available">Available</span>' : 
                            '<span class="slot-booked">Booked</span>'
                        }
                    </div>
                `;
            });
            
            timeSlotsGrid.innerHTML = slotsHTML;
            
            // Attach click events only to available slots
            document.querySelectorAll('.time-slot-10min.available').forEach(slot => {
                slot.addEventListener('click', () => this.selectTimeSlot(slot));
            });
            
        } catch (error) {
            console.error('Error loading time slots:', error);
            timeSlotsGrid.innerHTML = '<div class="error-slots"><i class="fas fa-exclamation-circle"></i><br>Error loading time slots. Please refresh.</div>';
        }
    }

    selectTimeSlot(slotElement) {
        console.log('Time slot selected');
        
        // Remove previous selection
        document.querySelectorAll('.time-slot-10min.selected').forEach(slot => {
            slot.classList.remove('selected');
        });
        
        // Highlight selected
        slotElement.classList.add('selected');
        
        const slotId = slotElement.dataset.slotId;
        const timeSlotId = slotElement.dataset.timeSlotId;
        const startTime = slotElement.dataset.startTime;
        const startDisplay = slotElement.dataset.startDisplay;
        const endDisplay = slotElement.dataset.endDisplay;
        
        // Store in hidden fields
        document.getElementById('selectedTimeSlot').value = timeSlotId;
        document.getElementById('selectedTimeDisplay').value = `${startDisplay}`;
        
        // Set appointment time (24-hour format for database)
        const appointmentTimeField = document.querySelector('input[name="appointment_time"]');
        if (appointmentTimeField) {
            appointmentTimeField.value = startTime;
        }
        
        // Show selected time display
        this.showSelectedTime(startDisplay, endDisplay);
        
        console.log('Time selected:', {
            slotId: slotId,
            timeSlotId: timeSlotId,
            time: startDisplay,
            dbTime: startTime
        });
    }

    showSelectedTime(startDisplay, endDisplay) {
        // Remove existing display
        const existingDisplay = document.querySelector('.selected-time-display');
        if (existingDisplay) existingDisplay.remove();
        
        const display = document.createElement('div');
        display.className = 'selected-time-display';
        display.innerHTML = `
            <div class="selected-time-card">
                <i class="fas fa-check-circle"></i>
                <div>
                    <div class="selected-time-label">Selected Time (London Timezone)</div>
                    <div class="selected-time-value">${startDisplay}</div>
                </div>
                <button type="button" class="change-time-btn">Change</button>
            </div>
        `;
        
        const timeSlotsContainer = document.getElementById('timeSlotsContainer');
        if (timeSlotsContainer) {
            timeSlotsContainer.insertAdjacentElement('afterend', display);
        }
        
        display.querySelector('.change-time-btn')?.addEventListener('click', () => {
            document.querySelectorAll('.time-slot-10min.selected').forEach(slot => {
                slot.classList.remove('selected');
            });
            document.getElementById('selectedTimeSlot').value = '';
            document.getElementById('selectedTimeDisplay').value = '';
            document.querySelector('input[name="appointment_time"]').value = '';
            display.remove();
        });
        
        display.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    attachEvents() {
        const prevBtn = document.getElementById('prevMonth');
        const nextBtn = document.getElementById('nextMonth');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                console.log('Previous month clicked');
                this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                this.renderCalendar();
                document.getElementById('timeSlotsContainer').style.display = 'none';
                this.selectedDate = null;
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                console.log('Next month clicked');
                this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                this.renderCalendar();
                document.getElementById('timeSlotsContainer').style.display = 'none';
                this.selectedDate = null;
            });
        }
    }
}

// Initialize calendar on booking page
if (document.querySelector('.calendar-container')) {
    console.log('Calendar container found, initializing...');
    new AppointmentCalendar();
} else {
    console.log('Calendar container not found');
}