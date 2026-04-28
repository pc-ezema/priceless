{{-- resources/views/admin/services/index.blade.php --}}
@extends('layouts.frontend', ['title' => 'Manage Services'])

@section('page-content')
<div class="admin-services-page">
    <div class="services-header">
        <div class="services-header-left">
            <div class="breadcrumb-nav">
                <a href="{{ route('dashboard') }}" class="back-to-dashboard">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            <h1>Manage Services</h1>
            <p>Add, edit, or remove beauty services</p>
        </div>
        <div class="services-header-right">
            <a href="{{ route('services.create') }}" class="btn-primary" id="addServiceBtn">
                <i class="fas fa-plus"></i> Add New Service
            </a>
        </div>
    </div>

    <div class="services-stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-cut"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $services->count() }}</span>
                <span class="stat-label">Total Services</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $services->where('is_active', true)->count() }}</span>
                <span class="stat-label">Active Services</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-tag"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $services->groupBy('category')->count() }}</span>
                <span class="stat-label">Categories</span>
            </div>
        </div>
    </div>

    @foreach($groupedServices as $category => $categoryServices)
    <div class="services-category-section" data-category="{{ $category }}">
        <div class="category-header">
            <h2>
                @if($category == 'Hair Care & Styling') <i class="fas fa-cut"></i>
                @elseif($category == 'Wig Services') <i class="fas fa-female"></i>
                @else <i class="fas fa-feather-alt"></i>
                @endif
                {{ $category }}
            </h2>
            <span class="category-count">{{ $categoryServices->count() }} services</span>
        </div>

        <div class="services-table-wrapper">
            <table class="services-table">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categoryServices as $service)
                    <tr data-service-id="{{ $service->id }}">
                        <td class="service-name-cell">
                            <span class="service-name">{{ $service->name }}</span>
                            @if($service->description)
                                <small class="service-desc">{{ $service->description }}</small>
                            @endif
                        </td>
                        <td class="service-price">£{{ number_format($service->price, 2) }}</td>
                        <td class="service-duration">{{ $service->duration ?? '—' }}</td>
                        <td>
                            <button class="status-toggle" data-id="{{ $service->id }}" data-active="{{ $service->is_active ? 'true' : 'false' }}">
                                <span class="status-badge {{ $service->is_active ? 'active' : 'inactive' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </button>
                        </td>
                        <td class="actions">
                            <a href="{{ route('services.edit', $service) }}" class="action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="action-btn delete-btn" data-id="{{ $service->id }}" data-name="{{ $service->name }}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Delete Service</h3>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <strong id="deleteServiceName"></strong>?</p>
            <p class="warning-text">This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary modal-cancel">Cancel</button>
            <button class="btn-danger modal-confirm">Delete</button>
        </div>
    </div>
</div>
@endsection