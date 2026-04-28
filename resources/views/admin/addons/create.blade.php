{{-- resources/views/admin/addons/create.blade.php --}}
@extends('layouts.frontend', ['title' => 'Add New Add-on'])

@section('page-content')
<div class="addon-form-page">
    <div class="addon-form-container">
        <div class="form-header">
            <a href="{{ route('dashboard.addons') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Add-ons
            </a>
            <h1>Add New Add-on</h1>
            <p>Create a new service add-on for your customers</p>
        </div>

        <form id="addonForm" action="{{ route('addons.store') }}" method="POST" class="addon-form" data-ajax="true">
            @csrf

            <div class="form-group">
                <label for="name">Add-on Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g., Hair Installation" required>
                <small>Enter a descriptive name for this add-on</small>
                <div class="error-message" id="name-error"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (£) <span class="required">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" placeholder="0.00" required>
                    <div class="error-message" id="price-error"></div>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    <small>Which service category does this add-on belong to?</small>
                    <div class="error-message" id="category-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description (Optional)</label>
                <textarea name="description" id="description" rows="3" placeholder="Describe what this add-on includes...">{{ old('description') }}</textarea>
                <div class="error-message" id="description-error"></div>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" placeholder="0">
                <small>Lower numbers appear first in the list</small>
                <div class="error-message" id="sort_order-error"></div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn-primary" id="submitBtn">Create Add-on</button>
            </div>
        </form>
    </div>
</div>
@endsection