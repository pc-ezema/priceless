@extends('layouts.frontend', ['title' => 'Admin Dashboard'])

@section('page-content')
<main id="page" class="admin-dashboard-page" role="main">
    <article class="sections" id="sections">
        <section class="dashboard-section">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <div class="welcome-badge">
                        <i class="fas fa-crown"></i>
                        <span>Administrator Access</span>
                    </div>
                    <h2 class="dash-title">Welcome Back, Admin</h2>
                    <p class="dash-subtitle">Manage your beauty empire from one central dashboard</p>
                </div>

                <div class="dashboard-stats">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value" id="todayAppointments">{{ $todayAppointments }}</span>
                            <span class="stat-label">Today's Appointments</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value" id="pendingAppointments">{{ $pendingAppointments }}</span>
                            <span class="stat-label">Pending Requests</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value" id="totalCustomers">{{ $totalCustomers }}</span>
                            <span class="stat-label">Happy Clients</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value" id="weeklyAppointments">{{ $weeklyAppointments }}</span>
                            <span class="stat-label">This Week</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <!-- APPOINTMENTS CARD -->
                    <a href="{{ route('dashboard.appointments') }}" class="dash-card" data-hover="ripple">
                        <div class="card-icon-wrapper">
                            <i class="fa-solid fa-calendar-check dash-icon"></i>
                        </div>
                        <div class="card-content">
                            <h3>Appointments</h3>
                            <p>Manage customer bookings, reschedule, and track all appointments</p>
                            <span class="card-link">View all <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </a>

                    <!-- TIME SLOTS CARD -->
                    <a href="{{ route('dashboard.time-slots') }}" class="dash-card" data-hover="ripple">
                        <div class="card-icon-wrapper">
                            <i class="fa-solid fa-clock dash-icon"></i>
                        </div>
                        <div class="card-content">
                            <h3>Time Slots</h3>
                            <p>Manage available time slots for appointments</p>
                            <span class="card-link">View all <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </a>

                    <!-- SERVICES CARD -->
                    <a href="{{ route('dashboard.services') }}" class="dash-card" data-hover="ripple">
                        <div class="card-icon-wrapper">
                            <i class="fa-solid fa-spa dash-icon"></i>
                        </div>
                        <div class="card-content">
                            <h3>Services</h3>
                            <p>Update service offerings, pricing, and durations</p>
                            <span class="card-link">Edit services <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </a>
                    
                    <!-- ADD-ON CARD -->
                    <a href="{{ route('dashboard.addons') }}" class="dash-card" data-hover="ripple">
                        <div class="card-icon-wrapper">
                            <i class="fa-solid fa-plus-circle dash-icon"></i>
                        </div>
                        <div class="card-content">
                            <h3>Add-ons</h3>
                            <p>Manage additional services or products offered</p>
                            <span class="card-link">Edit add-ons <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </a>

                    <!-- CUSTOMERS CARD -->
                    <a href="{{ route('dashboard.customers') }}" class="dash-card" data-hover="ripple">
                        <div class="card-icon-wrapper">
                            <i class="fa-solid fa-users dash-icon"></i>
                        </div>
                        <div class="card-content">
                            <h3>Customers</h3>
                            <p>View customer database and manage preferences</p>
                            <span class="card-link">View clients <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </a>

                    <!-- LOGOUT CARD -->
                    <form action="{{ route('logout') }}" method="POST" class="dash-card logout-card" id="logoutForm">
                        @csrf
                        <button type="submit" class="logout-btn" id="logoutBtn">
                            <div class="card-icon-wrapper">
                                <i class="fa-solid fa-right-from-bracket dash-icon"></i>
                            </div>
                            <div class="card-content">
                                <h3>Logout</h3>
                                <p>Exit your account securely and return to the site</p>
                                <span class="card-link">Sign out <i class="fas fa-sign-out-alt"></i></span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </article>
</main>
@endsection