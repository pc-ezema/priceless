{{-- resources/views/admin/customers/index.blade.php --}}
@extends('layouts.frontend', ['title' => 'Manage Customers'])

@section('page-content')
<div class="admin-customers-page">
    <div class="customers-header">
        <div class="customers-header-left">
            <div class="breadcrumb-nav">
                <a href="{{ route('dashboard') }}" class="back-to-dashboard">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            <h1>Manage Customers</h1>
            <p>View and manage your customer database</p>
        </div>
    </div>

    <div class="customers-stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $customers->total() }}</span>
                <span class="stat-label">Total Customers</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $customers->where('total_bookings', '>', 0)->count() }}</span>
                <span class="stat-label">Active Customers</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <div class="stat-info">
                <span class="stat-value">£{{ number_format($customers->sum('total_spent'), 2) }}</span>
                <span class="stat-label">Total Spent</span>
            </div>
        </div>
    </div>

    <div class="customers-search">
        <form method="GET" class="search-form">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" placeholder="Search by name, email, or phone..." 
                       value="{{ request('search') }}" class="search-input">
                <button type="submit" class="search-btn">Search</button>
                @if(request('search'))
                    <a href="{{ route('customers.index') }}" class="clear-search">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <div class="customers-table-wrapper">
        <table class="customers-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Bookings</th>
                    <th>Total Spent</th>
                    <th>Last Booking</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td><strong>{{ $customer->name }}</strong></td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '—' }}</td>
                    <td>{{ $customer->total_bookings }}</td>
                    <td>£{{ number_format($customer->total_spent, 2) }}</td>
                    <td>{{ $customer->last_booking ? \Carbon\Carbon::parse($customer->last_booking)->format('M d, Y') : '—' }}</td>
                    <td class="actions">
                        <a href="{{ route('customers.show', $customer->email) }}" class="action-btn view-btn" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-users"></i>
                        <p>No customers found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $customers->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection