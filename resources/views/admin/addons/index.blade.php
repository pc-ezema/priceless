{{-- resources/views/admin/addons/index.blade.php --}}
@extends('layouts.frontend', ['title' => 'Manage Add-ons'])

@section('page-content')
<div class="admin-addons-page">
    <div class="addons-header">
        <div class="addons-header-left">
            <div class="breadcrumb-nav">
                <a href="{{ route('dashboard') }}" class="back-to-dashboard">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            <h1>Manage Add-ons</h1>
            <p>Add, edit, or remove service add-ons</p>
        </div>
        <div class="addons-header-right">
            <a href="{{ route('dashboard') }}" class="dashboard-btn">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="addons-stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-cube"></i></div>
            <div class="stat-info">
                <span class="stat-value" id="totalAddons">{{ $addons->count() }}</span>
                <span class="stat-label">Total Add-ons</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <span class="stat-value" id="activeAddons">{{ $addons->where('is_active', true)->count() }}</span>
                <span class="stat-label">Active Add-ons</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-tag"></i></div>
            <div class="stat-info">
                <span class="stat-value" id="categoryCount">{{ $addons->groupBy('category')->count() }}</span>
                <span class="stat-label">Categories</span>
            </div>
        </div>
    </div>

    @forelse($groupedAddons as $category => $categoryAddons)
    <div class="addons-category-section" data-category="{{ $category }}">
        <div class="category-header">
            <h2>
                @if($category == 'Hair Care & Styling') <i class="fas fa-cut"></i>
                @elseif($category == 'Wig Services') <i class="fas fa-female"></i>
                @elseif($category == 'Waxing Services') <i class="fas fa-feather-alt"></i>
                @else <i class="fas fa-cube"></i>
                @endif
                {{ $category }}
            </h2>
            <span class="category-count">{{ $categoryAddons->count() }} add-ons</span>
        </div>

        <div class="addons-table-wrapper">
            <table class="addons-table">
                <thead>
                    <tr>
                        <th>Add-on Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categoryAddons as $addon)
                    <tr data-addon-id="{{ $addon->id }}">
                        <td class="addon-name-cell" data-label="Add-on Name">
                            <span class="addon-name">{{ $addon->name }}</span>
                        </td>
                        <td class="addon-price" data-label="Price">
                            £{{ number_format($addon->price, 2) }}
                        </td>
                        <td class="addon-description" data-label="Description">
                            {{ $addon->description ?? '—' }}
                        </td>
                        <td class="addon-sort" data-label="Sort Order">
                            {{ $addon->sort_order }}
                        </td>
                        <td data-label="Status">
                            <button class="addon-status-toggle" data-id="{{ $addon->id }}" data-active="{{ $addon->is_active ? 'true' : 'false' }}">
                                <span class="addon-status-badge {{ $addon->is_active ? 'addon-active' : 'addon-inactive' }}">
                                    {{ $addon->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </button>
                        </td>
                        <td data-label="Actions" class="actions">
                            <a href="{{ route('addons.edit', $addon) }}" class="action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="action-btn addon-delete-btn" data-id="{{ $addon->id }}" data-name="{{ $addon->name }}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="fas fa-cube"></i>
        <h3>No Add-ons Yet</h3>
        <p>Get started by creating your first add-on</p>
        <a href="{{ route('addons.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Create Add-on
        </a>
    </div>
    @endforelse
</div>

<!-- Delete Confirmation Modal -->
<div id="addonDeleteModal" class="addon-modal" style="display: none;">
    <div class="addon-modal-content">
        <div class="addon-modal-header">
            <h3>Delete Add-on</h3>
            <button class="addon-modal-close">&times;</button>
        </div>
        <div class="addon-modal-body">
            <p>Are you sure you want to delete <strong id="addonDeleteName"></strong>?</p>
            <p class="warning-text">⚠️ This action cannot be undone.</p>
        </div>
        <div class="addon-modal-footer">
            <button class="btn-secondary addon-modal-cancel">Cancel</button>
            <button class="btn-danger addon-modal-confirm">Delete</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Add-ons Page Specific Styles */
    .admin-addons-page {
        padding: 2rem;
        max-width: 1400px;
        margin: 5rem auto;
    }

    .addons-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .addons-header-left h1 {
        font-size: 2rem;
        margin-bottom: 0.3rem;
        color: var(--dark);
    }

    .addons-header-left p {
        color: var(--text-light);
    }

    .addons-header-right {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .dashboard-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .dashboard-btn:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .addons-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.2rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid var(--secondary);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon i {
        font-size: 1.3rem;
        color: white;
    }

    .stat-info .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1.2;
    }

    .stat-info .stat-label {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .addons-category-section {
        background: var(--white);
        border-radius: 20px;
        margin-bottom: 2rem;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .category-header {
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        padding: 1rem 1.5rem;
        color: var(--white);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-header h2 {
        font-size: 1.3rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-count {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.8rem;
    }

    .addons-table-wrapper {
        overflow-x: auto;
    }

    .addons-table {
        width: 100%;
        border-collapse: collapse;
    }

    .addons-table th,
    .addons-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--secondary);
    }

    .addons-table th {
        background: var(--gray-light);
        font-weight: 700;
        color: var(--dark);
        font-size: 0.85rem;
    }

    .addons-table tr:hover {
        background: var(--gray-light);
    }

    .addon-name {
        font-weight: 600;
        color: var(--dark);
    }

    .addon-price {
        font-weight: 700;
        color: var(--primary);
    }

    .addon-description {
        color: var(--text-light);
        font-size: 0.85rem;
        max-width: 250px;
    }

    /* Add-on Status Badges */
    .addon-status-badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .addon-status-badge.addon-active {
        background: #d4edda;
        color: #155724;
    }

    .addon-status-badge.addon-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .addon-status-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    /* Action Buttons */
    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .edit-btn {
        color: #4caf50;
        background: rgba(76, 175, 80, 0.1);
    }

    .edit-btn:hover {
        background: #4caf50;
        color: white;
        transform: scale(1.05);
    }

    .addon-delete-btn {
        color: #f44336;
        background: rgba(244, 67, 54, 0.1);
    }

    .addon-delete-btn:hover {
        background: #f44336;
        color: white;
        transform: scale(1.05);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        margin: 2rem 0;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--primary-light);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--dark);
    }

    .empty-state p {
        color: var(--text-light);
        margin-bottom: 1.5rem;
    }

    /* Modal Styles */
    .addon-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }

    .addon-modal-content {
        background: white;
        border-radius: 20px;
        max-width: 450px;
        width: 90%;
        overflow: hidden;
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .addon-modal-header {
        padding: 1.2rem 1.5rem;
        background: linear-gradient(135deg, #b37d97, #d4a0ba);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .addon-modal-header h3 {
        margin: 0;
        font-size: 1.2rem;
    }

    .addon-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: white;
        opacity: 0.8;
        transition: opacity 0.3s;
    }

    .addon-modal-close:hover {
        opacity: 1;
    }

    .addon-modal-body {
        padding: 1.5rem;
    }

    .warning-text {
        color: #c62828;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .addon-modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-secondary {
        background: #f0f0f0;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        color: #000;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .btn-danger {
        background: #c62828;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        cursor: pointer;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-danger:hover {
        background: #b71c1c;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-addons-page {
            padding: 1rem;
            margin: 4rem auto;
        }

        .addons-header {
            flex-direction: column;
        }

        .addons-header-right {
            width: 100%;
            flex-direction: column;
        }

        .addons-header-right a {
            width: 100%;
            justify-content: center;
        }

        .addons-stats {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .addons-table thead {
            display: none;
        }

        .addons-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid var(--secondary);
            border-radius: 12px;
            overflow: hidden;
        }

        .addons-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 1rem;
            border-bottom: 1px solid var(--secondary);
        }

        .addons-table tbody td:last-child {
            border-bottom: none;
        }

        .addons-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: var(--primary);
            width: 40%;
        }

        .addons-table tbody td .action-btn {
            margin-left: auto;
        }
    }

    /* Notification */
    .addon-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 10001;
        animation: slideInRight 0.3s ease;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // ============================================
    // ADD-ONS MANAGEMENT - COMPLETE WORKING VERSION
    // ============================================

    (function() {
        'use strict';

        // Only run on add-ons page
        if (!document.querySelector('.admin-addons-page')) return;

        console.log('Add-ons management initialized');

        // DOM Elements
        const deleteModal = document.getElementById('addonDeleteModal');
        const deleteButtons = document.querySelectorAll('.addon-delete-btn');
        const statusToggles = document.querySelectorAll('.addon-status-toggle');
        const modalClose = document.querySelector('.addon-modal-close');
        const modalCancel = document.querySelector('.addon-modal-cancel');
        const modalConfirm = document.querySelector('.addon-modal-confirm');

        let currentAddonId = null;
        let currentAddonName = null;

        // ============================================
        // NOTIFICATION FUNCTION
        // ============================================

        function showNotification(message, type = 'success') {
            const existing = document.querySelector('.addon-notification');
            if (existing) existing.remove();

            const notification = document.createElement('div');
            notification.className = 'addon-notification';
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
        // UPDATE STATS
        // ============================================

        function updateStats() {
            const rows = document.querySelectorAll('.addons-table tbody tr');
            const total = rows.length;
            const active = document.querySelectorAll('.addon-status-badge.addon-active').length;
            const categories = document.querySelectorAll('.addons-category-section').length;

            const totalStat = document.getElementById('totalAddons');
            const activeStat = document.getElementById('activeAddons');
            const categoryStat = document.getElementById('categoryCount');

            if (totalStat) totalStat.textContent = total;
            if (activeStat) activeStat.textContent = active;
            if (categoryStat) categoryStat.textContent = categories;
        }

        // ============================================
        // UPDATE CATEGORY COUNTS
        // ============================================

        function updateCategoryCounts() {
            const sections = document.querySelectorAll('.addons-category-section');
            sections.forEach(section => {
                const rows = section.querySelectorAll('tbody tr');
                const count = rows.length;
                const countSpan = section.querySelector('.category-count');
                if (countSpan) {
                    countSpan.textContent = `${count} add-on${count !== 1 ? 's' : ''}`;
                }
            });
        }

        // ============================================
        // MODAL FUNCTIONS
        // ============================================

        function openDeleteModal(id, name) {
            currentAddonId = id;
            currentAddonName = name;
            const nameSpan = document.getElementById('addonDeleteName');
            if (nameSpan) nameSpan.textContent = name;
            if (deleteModal) {
                deleteModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeDeleteModal() {
            if (deleteModal) {
                deleteModal.style.display = 'none';
                document.body.style.overflow = '';
            }
            currentAddonId = null;
            currentAddonName = null;
        }

        // ============================================
        // DELETE HANDLER - USING FORM SUBMISSION
        // ============================================

        // Open modal when delete button is clicked
        if (deleteButtons.length > 0) {
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    openDeleteModal(id, name);
                });
            });
        }

        // Close modal handlers
        if (modalClose) modalClose.addEventListener('click', closeDeleteModal);
        if (modalCancel) modalCancel.addEventListener('click', closeDeleteModal);

        // Close modal when clicking outside
        if (deleteModal) {
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) closeDeleteModal();
            });
        }

        // ============================================
        // DELETE HANDLER - USING AJAX (No Page Reload)
        // ============================================

        if (modalConfirm) {
            modalConfirm.addEventListener('click', async function() {
                if (!currentAddonId) return;

                // Show loading
                const originalText = modalConfirm.innerHTML;
                modalConfirm.disabled = true;
                modalConfirm.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
                        document.querySelector('input[name="_token"]')?.value;

                    const response = await fetch(`/dashboard/addons/${currentAddonId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        // Remove the row from the table
                        const row = document.querySelector(`tr[data-addon-id="${currentAddonId}"]`);
                        if (row) {
                            const section = row.closest('.addons-category-section');
                            row.remove();
                            if (section && section.querySelectorAll('tbody tr').length === 0) {
                                section.remove();
                            }
                        }

                        // Show success message
                        showNotification(data.message, 'success');

                        // Update stats
                        updateStats();
                        updateCategoryCounts();

                        // Close modal
                        closeDeleteModal();
                    } else {
                        showNotification(data.message || 'Error deleting add-on', 'error');
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
        // STATUS TOGGLE HANDLER - AJAX
        // ============================================

        async function handleStatusToggle(e) {
            e.preventDefault();
            e.stopPropagation();

            const button = this;
            const addonId = button.dataset.id;
            const badge = button.querySelector('.addon-status-badge');
            const originalText = badge?.textContent;
            const originalClass = badge?.className;

            if (!addonId) return;

            // Show loading state
            if (badge) {
                badge.style.opacity = '0.7';
                badge.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
                    document.querySelector('input[name="_token"]')?.value;

                const response = await fetch(`/dashboard/addons/${addonId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PATCH'
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    if (badge) {
                        badge.style.opacity = '1';
                        if (data.is_active) {
                            badge.textContent = 'Active';
                            badge.className = 'addon-status-badge addon-active';
                            button.dataset.active = 'true';
                        } else {
                            badge.textContent = 'Inactive';
                            badge.className = 'addon-status-badge addon-inactive';
                            button.dataset.active = 'false';
                        }
                    }
                    showNotification(data.message, 'success');
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
        }

        // Attach status toggle event listeners
        if (statusToggles.length > 0) {
            statusToggles.forEach(toggle => {
                toggle.removeEventListener('click', handleStatusToggle);
                toggle.addEventListener('click', handleStatusToggle);
            });
        }

        // Escape key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && deleteModal && deleteModal.style.display === 'flex') {
                closeDeleteModal();
            }
        });
    })();
</script>
@endpush