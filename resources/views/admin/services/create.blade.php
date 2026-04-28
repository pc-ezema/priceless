{{-- resources/views/admin/services/create.blade.php --}}
@extends('layouts.frontend', ['title' => 'Add New Service'])

@section('page-content')
<div class="service-form-page">
    <div class="service-form-container">
        <div class="form-header">
            <a href="{{ route('dashboard.services') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Services
            </a>
            <h1>Add New Service</h1>
            <p>Create a new beauty service for your customers</p>
        </div>

        <form id="serviceForm" action="{{ route('services.store') }}" method="POST" class="service-form">
            @csrf

            <div class="form-group">
                <label for="category">Category <span class="required">*</span></label>
                <select name="category" id="category" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Service Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g., Brazilian Wax" required>
                <small>Enter the exact service name as it appears to customers</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (£) <span class="required">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="duration">Duration</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration') }}" placeholder="e.g., 45 mins, 1h 30m">
                    <small>Expected time for this service</small>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description (Optional)</label>
                <textarea name="description" id="description" rows="4" placeholder="Describe what this service includes...">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" placeholder="0">
                <small>Lower numbers appear first</small>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn-primary">Create Service</button>
            </div>
        </form>
    </div>
</div>
@endsection