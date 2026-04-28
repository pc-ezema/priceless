{{-- resources/views/admin/appointments.blade.php --}}
@extends('layouts.frontend', ['title' => 'View Appointments'])

@section('page-content')
<div class="appointments-page">
    <div class="appointments-header">
        <div class="appointments-header-left">
            <div class="breadcrumb-nav">
                <a href="{{ route('dashboard') }}" class="back-to-dashboard">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            <h1>All Appointments</h1>
            <p>Manage and track customer bookings</p>
        </div>
        <div class="appointments-header-right">
            <a href="{{ route('dashboard.services') }}" class="services-link-btn">
                <i class="fas fa-spa"></i> Manage Services
            </a>
        </div>
    </div>

    <div class="appointments-stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $appointments->total() }}</span>
                <span class="stat-label">Total Appointments</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $appointments->where('status', 'pending')->count() }}</span>
                <span class="stat-label">Pending</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $appointments->where('status', 'confirmed')->count() }}</span>
                <span class="stat-label">Confirmed</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $appointments->where('status', 'cancelled')->count() }}</span>
                <span class="stat-label">Cancelled</span>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="appointments-search">
        <form method="GET" action="{{ route('dashboard.appointments') }}" class="search-form">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" placeholder="Search by name, email, or service..." 
                       value="{{ request('search') }}" class="search-input">
                <button type="submit" class="search-btn">Search</button>
                @if(request('search'))
                    <a href="{{ route('dashboard.appointments') }}" class="clear-search">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="appointments-table-wrapper">
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Service</th>
                    <th>Add-ons</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr data-appointment-id="{{ $appointment->id }}">
                    <td data-label="#"> {{ $loop->iteration + ($appointments->currentPage()-1) * $appointments->perPage() }} </td>
                    <td data-label="Customer">
                        <strong>{{ $appointment->name }}</strong>
                    </td>
                    <td data-label="Contact">
                        <div><i class="fas fa-envelope"></i> {{ $appointment->email }}</div>
                        <div><i class="fas fa-phone"></i> {{ $appointment->phone }}</div>
                    </td>
                    <td data-label="Service">{{ $appointment->service }}</td>
                    <td data-label="Add-ons">{{ $appointment->addons ? implode(', ', is_array($appointment->addons) ? $appointment->addons : json_decode($appointment->addons, true)) : 'None' }}</td>
                    <td data-label="Date & Time">
                        <div><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</div>
                        <div><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</div>
                    </td>
                    <td data-label="Status">
                        <span class="status-badge status-{{ strtolower($appointment->status ?? 'pending') }}">
                            {{ ucfirst($appointment->status ?? 'Pending') }}
                        </span>
                    </td>
                    <td data-label="Action">
                        <button class="change-status-btn"
                            data-id="{{ $appointment->id }}"
                            data-current="{{ $appointment->status ?? 'pending' }}"
                            data-name="{{ $appointment->name }}">
                            <i class="fas fa-edit"></i> Update
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>No appointments found</p>
                        <span>Schedule your first appointment to get started</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($appointments->hasPages())
    <div class="pagination-wrapper">
        {{ $appointments->appends(['search' => request('search')])->links() }}
    </div>
    @endif
</div>

<!-- Status Modal -->
<div id="statusModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update Appointment Status</h3>
            <button class="modal-close">&times;</button>
        </div>
        <form id="statusForm">
            @csrf
            <input type="hidden" name="appointment_id" id="appointment_id">
            <div class="modal-body">
                <p>Update status for <strong id="appointmentCustomerName"></strong></p>
                <div class="form-group">
                    <label for="status">Select Status:</label>
                    <select name="status" id="status" class="status-select" required>
                        <option value="pending">⏳ Pending</option>
                        <option value="confirmed">✓ Confirmed</option>
                        <option value="cancelled">✗ Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary modal-cancel">Cancel</button>
                <button type="submit" class="btn-primary" id="statusSubmit">
                    <span class="btn-text">Update Status</span>
                    <span class="btn-loader" style="display: none;"><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection