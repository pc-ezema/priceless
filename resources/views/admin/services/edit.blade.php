{{-- resources/views/admin/services/edit.blade.php --}}
@extends('layouts.frontend', ['title' => 'Edit Service'])

@section('page-content')
<div class="service-form-page">
    <div class="service-form-container">
        <div class="form-header">
            <a href="{{ route('dashboard.services') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Services
            </a>
            <h1>Edit Service</h1>
            <p>Update service information</p>
        </div>

        <form id="serviceForm" action="{{ route('services.update', $service) }}" method="POST" class="service-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category">Category <span class="required">*</span></label>
                <select name="category" id="category" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $service->category == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Service Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" value="{{ $service->name }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (£) <span class="required">*</span></label>
                    <input type="number" name="price" id="price" value="{{ $service->price }}" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="duration">Duration</label>
                    <input type="text" name="duration" id="duration" value="{{ $service->duration }}" placeholder="e.g., 45 mins">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4">{{ $service->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ $service->sort_order }}">
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn-primary">Update Service</button>
            </div>
        </form>
    </div>
</div>
@endsection