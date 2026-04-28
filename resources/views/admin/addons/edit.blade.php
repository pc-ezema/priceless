{{-- resources/views/admin/addons/edit.blade.php --}}
@extends('layouts.frontend', ['title' => 'Edit Add-on'])

@section('page-content')
<div class="addon-form-page">
    <div class="addon-form-container">
        <div class="form-header">
            <a href="{{ route('dashboard.addons') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Add-ons
            </a>
            <h1>Edit Add-on</h1>
            <p>Update add-on information</p>
        </div>

        <form id="addonForm" action="{{ route('addons.update', $addon) }}" method="POST" class="addon-form" data-ajax="true">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Add-on Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" value="{{ $addon->name }}" required>
                <div class="error-message" id="name-error"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (£) <span class="required">*</span></label>
                    <input type="number" name="price" id="price" value="{{ $addon->price }}" step="0.01" required>
                    <div class="error-message" id="price-error"></div>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ $addon->category == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    <div class="error-message" id="category-error"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3">{{ $addon->description }}</textarea>
                <div class="error-message" id="description-error"></div>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ $addon->sort_order }}">
                <div class="error-message" id="sort_order-error"></div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn-primary" id="submitBtn">Update Add-on</button>
            </div>
        </form>
    </div>
</div>
@endsection