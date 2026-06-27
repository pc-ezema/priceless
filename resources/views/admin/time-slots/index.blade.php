@extends('layouts.frontend', ['title' => 'Manage Time Slots'])

@section('page-content')
<div class="dashboard-time-slots-page">
    <div class="time-slots-header">
        <div class="time-slots-header-left">
            <div class="breadcrumb-nav">
                <a href="{{ route('dashboard') }}" class="back-to-dashboard">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            <h1>Manage Time Slots</h1>
            <p>Create and manage available appointment times</p>
        </div>
        <div class="time-slots-header-right">
            <button class="btn-primary" id="bulkCreateBtn">
                <i class="fas fa-layer-group"></i> Bulk Create
            </button>
            <button class="btn-primary" id="addSlotBtn">
                <i class="fas fa-plus"></i> Add Time Slot
            </button>
        </div>
    </div>

    <div class="time-slots-stats">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
            <div class="stat-info">
                <span class="stat-value" id="totalSlots">0</span>
                <span class="stat-label">Total Slots</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <span class="stat-value" id="availableSlots">0</span>
                <span class="stat-label">Available</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <span class="stat-value" id="bookedSlots">0</span>
                <span class="stat-label">Booked</span>
            </div>
        </div>
    </div>

    <div class="date-navigation-wrapper">
        <div class="date-navigation">
            <button id="prevWeek" class="nav-btn">
                <i class="fas fa-chevron-left"></i> Prev Week
            </button>
            <h3 id="weekRange" class="week-range"></h3>
            <button id="nextWeek" class="nav-btn">
                Next Week <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <div class="view-toggle">
            <button class="view-btn active" data-view="week">Week View</button>
            <button class="view-btn" data-view="month">Month View</button>
        </div>
    </div>

    <div class="time-slots-table-wrapper">
        <table class="time-slots-table">
            <thead id="tableHeaders">
                <!-- Headers will be populated by JS -->
            </thead>
            <tbody id="timeSlotsBody">
                <tr>
                    <td colspan="8" class="loading-state">
                        <i class="fas fa-spinner fa-spin"></i> Loading time slots...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Time Slot Modal -->
<div id="slotModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Add Time Slot</h3>
            <button class="modal-close">&times;</button>
        </div>
        <form id="slotForm">
            @csrf
            <input type="hidden" id="slotId" name="slot_id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="slotDate">Date <span class="required">*</span></label>
                    <input type="date" id="slotDate" name="date" min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="startTime">Start Time <span class="required">*</span></label>
                        <input type="time" id="startTime" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="endTime">End Time <span class="required">*</span></label>
                        <input type="time" id="endTime" name="end_time" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="maxBookings">Max Bookings per Slot</label>
                    <input type="number" id="maxBookings" name="max_bookings" min="1" value="1">
                    <small>How many clients can book this time slot</small>
                </div>
                <div class="form-group">
                    <label for="slotStatus">Status</label>
                    <select id="slotStatus" name="status">
                        <option value="available">Available</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary modal-cancel">Cancel</button>
                <button type="submit" class="btn-primary" id="saveSlotBtn">Save Slot</button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Create Modal -->
<div id="bulkModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Bulk Create Time Slots</h3>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Start Date <span class="required">*</span></label>
                <input type="date" id="bulkStartDate" class="form-control" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label>End Date <span class="required">*</span></label>
                <input type="date" id="bulkEndDate" class="form-control" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Start Time <span class="required">*</span></label>
                    <input type="time" id="bulkStartTime" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>End Time <span class="required">*</span></label>
                    <input type="time" id="bulkEndTime" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Max Bookings per Slot</label>
                <input type="number" id="bulkMaxBookings" min="1" max="10" value="1" class="form-control">
            </div>
            <div class="form-group">
                <label>Repeat on Days</label>
                <div class="repeat-days">
                    <label class="day-checkbox"><input type="checkbox" value="mon"> <span>Mon</span></label>
                    <label class="day-checkbox"><input type="checkbox" value="tue"> <span>Tue</span></label>
                    <label class="day-checkbox"><input type="checkbox" value="wed"> <span>Wed</span></label>
                    <label class="day-checkbox"><input type="checkbox" value="thu"> <span>Thu</span></label>
                    <label class="day-checkbox"><input type="checkbox" value="fri"> <span>Fri</span></label>
                    <label class="day-checkbox"><input type="checkbox" value="sat"> <span>Sat</span></label>
                    <label class="day-checkbox"><input type="checkbox" value="sun"> <span>Sun</span></label>
                </div>
                <small>Leave unchecked to create for all days</small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary modal-cancel">Cancel</button>
            <button type="button" class="btn-primary" id="confirmBulkCreate">Create Slots</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Delete Time Slot</h3>
            <button class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this time slot?</p>
            <p class="warning-text">⚠️ This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary modal-cancel">Cancel</button>
            <button class="btn-danger modal-confirm" id="confirmDelete">Delete</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Time Slots Page Styles */
.dashboard-time-slots-page {
    padding: 2rem;
    max-width: 1400px;
    margin: 5rem auto;
}

.time-slots-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.time-slots-header-left h1 {
    font-size: 2rem;
    margin-bottom: 0.3rem;
    color: var(--dark);
}

.time-slots-header-left p {
    color: var(--text-light);
}

.time-slots-header-right {
    display: flex;
    gap: 1rem;
}

.time-slots-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.date-navigation-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.date-navigation {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-btn {
    background: var(--white);
    border: 1px solid var(--secondary);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition-base);
    font-family: var(--font-sans);
    font-weight: 500;
}

.nav-btn:hover {
    background: var(--primary-light);
    border-color: var(--primary);
    color: white;
}

.week-range {
    font-size: 1.2rem;
    color: var(--primary);
    min-width: 300px;
    text-align: center;
}

.view-toggle {
    display: flex;
    gap: 0.5rem;
}

.view-btn {
    background: var(--white);
    border: 1px solid var(--secondary);
    padding: 0.5rem 1.2rem;
    border-radius: 50px;
    cursor: pointer;
    transition: var(--transition-base);
    font-family: var(--font-sans);
}

.view-btn.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Table Styles */
.time-slots-table-wrapper {
    overflow-x: auto;
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-md);
}

.time-slots-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.time-slots-table th,
.time-slots-table td {
    padding: 1rem;
    text-align: center;
    border: 1px solid var(--secondary);
}

.time-slots-table th {
    background: linear-gradient(135deg, #fdf3ff, #f8ebff);
    font-weight: 700;
    color: var(--dark);
    font-size: 0.85rem;
    text-transform: uppercase;
}

.time-slots-table td {
    vertical-align: middle;
    background: var(--white);
}

.date-header {
    font-weight: 700;
    color: var(--primary);
    background: #faf5ff;
}

.slot-cell {
    min-width: 120px;
}

.slot-item {
    background: #e8f5e9;
    color: #2e7d32;
    padding: 0.5rem;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    font-size: 0.8rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.3rem;
}

.slot-item.blocked {
    background: #ffebee;
    color: #c62828;
}

.slot-time {
    font-weight: 600;
    font-size: 0.75rem;
}

.slot-bookings {
    font-size: 0.65rem;
    background: rgba(0,0,0,0.1);
    padding: 0.2rem 0.4rem;
    border-radius: 10px;
}

.slot-actions {
    display: flex;
    gap: 0.3rem;
}

.slot-actions button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    transition: var(--transition-base);
}

.edit-slot {
    color: #4caf50;
}

.edit-slot:hover {
    background: #4caf50;
    color: white;
}

.delete-slot {
    color: #f44336;
}

.delete-slot:hover {
    background: #f44336;
    color: white;
}

.empty-slot {
    color: var(--text-light);
    font-size: 0.8rem;
    padding: 0.8rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.3rem;
}

.empty-slot button {
    background: none;
    border: none;
    color: var(--primary);
    cursor: pointer;
    font-size: 1rem;
}

.empty-slot button:hover {
    transform: scale(1.1);
}

.loading-state {
    text-align: center;
    padding: 3rem;
    color: var(--primary);
}

/* Modal Styles - FIXED SCROLLABLE */
.modal {
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
    overflow-y: auto;
    padding: 2rem;
}

.modal-content {
    background: white;
    border-radius: 20px;
    max-width: 550px;
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
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

.modal-header {
    padding: 1.2rem 1.5rem;
    background: linear-gradient(135deg, #b37d97, #d4a0ba);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.2rem;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: white;
    opacity: 0.8;
    transition: opacity 0.3s;
    line-height: 1;
}

.modal-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    flex: 1;
    max-height: calc(90vh - 130px);
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    flex-shrink: 0;
}

/* Form Styles Inside Modal */
.form-group {
    margin-bottom: 1.2rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--dark);
    font-size: 0.9rem;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 2px solid var(--secondary);
    border-radius: 12px;
    font-family: var(--font-sans);
    transition: var(--transition-base);
    font-size: 0.9rem;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(179, 125, 151, 0.1);
}

.form-group small {
    display: block;
    font-size: 0.7rem;
    color: var(--text-light);
    margin-top: 0.3rem;
}

.required {
    color: #f44336;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.repeat-days {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
    margin-top: 0.5rem;
}

.day-checkbox {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.3rem;
    cursor: pointer;
    padding: 0.3rem;
    border-radius: 8px;
    transition: var(--transition-base);
}

.day-checkbox:hover {
    background: var(--gray-light);
}

.day-checkbox input {
    cursor: pointer;
    width: 18px;
    height: 18px;
}

.day-checkbox span {
    font-size: 0.7rem;
    text-transform: uppercase;
    font-weight: 500;
}

/* Button Styles */
.btn-primary {
    background: var(--primary);
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: var(--transition-base);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.btn-secondary {
    background: #f0f0f0;
    color: #666;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: var(--transition-base);
}

.btn-secondary:hover {
    background: #e0e0e0;
}

.btn-danger {
    background: #c62828;
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: var(--transition-base);
}

.btn-danger:hover {
    background: #b71c1c;
}

/* Month View Styles */
.month-cell {
    cursor: pointer;
    transition: var(--transition-base);
    vertical-align: top;
    min-width: 100px;
    height: 100px;
}

.month-cell:hover {
    background: var(--gray-light);
}

.month-cell.other-month {
    opacity: 0.4;
}

.month-cell.today {
    background: rgba(179, 125, 151, 0.1);
    border: 2px solid var(--primary);
}

.month-cell.has-slots {
    background: rgba(76, 175, 80, 0.05);
}

.month-day {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.month-slots {
    font-size: 0.7rem;
    color: var(--text-light);
}

.month-slots i {
    color: #4caf50;
    margin-right: 0.3rem;
}

.no-slots {
    color: #999;
}

.week-number {
    background: var(--gray-light);
    font-weight: 600;
    text-align: center;
}

.today-header {
    background: rgba(179, 125, 151, 0.15);
}

/* Slots Dialog */
.slots-list {
    max-height: 400px;
    overflow-y: auto;
}

.slot-item-dialog {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem;
    border-bottom: 1px solid var(--secondary);
    background: var(--white);
    flex-wrap: wrap;
    gap: 0.5rem;
}

.slot-item-dialog.blocked {
    background: #ffebee;
    opacity: 0.7;
}

.slot-item-dialog span:first-child {
    font-weight: 600;
}

.slot-item-dialog .btn-small,
.slot-item-dialog .btn-small-danger {
    padding: 0.3rem 0.8rem;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.75rem;
    font-weight: 500;
    border: none;
}

.btn-small {
    background: var(--primary);
    color: white;
    margin-right: 0.5rem;
    display: inline-block !important;
}

.btn-small-danger {
    background: #f44336;
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-time-slots-page {
        padding: 1rem;
        margin: 4rem auto;
    }
    
    .time-slots-header {
        flex-direction: column;
    }
    
    .time-slots-header-right {
        width: 100%;
        flex-direction: column;
    }
    
    .time-slots-header-right button {
        width: 100%;
    }
    
    .time-slots-stats {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .date-navigation-wrapper {
        flex-direction: column;
    }
    
    .date-navigation {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .week-range {
        font-size: 1rem;
        min-width: auto;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .repeat-days {
        gap: 0.5rem;
    }
    
    .modal {
        padding: 1rem;
    }
    
    .modal-content {
        max-width: 95%;
        max-height: 95vh;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .slot-item-dialog {
        flex-direction: column;
        text-align: center;
    }
    
    .time-slots-table {
        min-width: 600px;
    }
    
    .slot-item {
        flex-direction: column;
        text-align: center;
    }
}

/* Navigation active states */
.nav-btn:active {
    transform: scale(0.95);
}

.past-date {
    opacity: 0.5;
    pointer-events: none; /* disables clicking on edit/delete buttons inside */
    background: #f9f9f9;
}
</style>
@endpush

@push('scripts')
<script>
// ============================================
// TIME SLOTS MANAGEMENT - FULLY WORKING
// ============================================

(function() {
    'use strict';
    
    if (!document.querySelector('.dashboard-time-slots-page')) return;
    
    let currentDate = new Date();
    let currentView = 'week'; // week or month
    let timeSlotsData = {};
    let deleteId = null;
    
    // Helper Functions
    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }
    
    function formatDisplayDate(date) {
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }
    
    // Get week range (Monday to Sunday)
    function getWeekRange(date) {
        const start = new Date(date);
        const day = start.getDay();
        // Adjust to Monday as first day of week
        const diff = start.getDate() - day + (day === 0 ? -6 : 1);
        start.setDate(diff);
        
        const end = new Date(start);
        end.setDate(start.getDate() + 6);
        
        return { start, end };
    }
    
    // Get month range
    function getMonthRange(date) {
        const start = new Date(date.getFullYear(), date.getMonth(), 1);
        const end = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        return { start, end };
    }
    
    // Update header display
    function updateHeaderDisplay() {
        if (currentView === 'week') {
            const { start, end } = getWeekRange(currentDate);
            const startStr = start.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            const endStr = end.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            document.getElementById('weekRange').textContent = `${startStr} - ${endStr}, ${start.getFullYear()}`;
        } else {
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            document.getElementById('weekRange').textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        }
    }
    
    // Load time slots from server
    async function loadTimeSlots() {
        let startDate, endDate;
        
        if (currentView === 'week') {
            const { start, end } = getWeekRange(currentDate);
            startDate = formatDate(start);
            endDate = formatDate(end);
        } else {
            const { start, end } = getMonthRange(currentDate);
            startDate = formatDate(start);
            endDate = formatDate(end);
        }
        
        try {
            const url = `/dashboard/time-slots/data?start_date=${startDate}&end_date=${endDate}&_=${Date.now()}`;
            const response = await fetch(url);
            const data = await response.json();
            timeSlotsData = data;
            renderView();
            updateStats();
        } catch (error) {
            console.error('Error loading time slots:', error);
            showNotification('Failed to load time slots. Please refresh.', 'error');
        }
    }
    
    // Render based on current view
    function renderView() {
        if (currentView === 'week') {
            renderWeekView();
        } else {
            renderMonthView();
        }
    }
    
    // Render Week View
    function renderWeekView() {
        const { start, end } = getWeekRange(currentDate);
        const dates = [];
        const headers = [];

        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
            const dateStr = formatDate(d);
            dates.push(dateStr);
            headers.push({
                date: dateStr,
                day: d.toLocaleDateString('en-US', { weekday: 'short' }),
                dateNum: d.getDate(),
                isToday: formatDate(d) === formatDate(new Date())
            });
        }

        const thead = document.getElementById('tableHeaders');
        thead.innerHTML = `
            <tr>
                <th>Time</th>
                ${headers.map(h => `<th class="${h.isToday ? 'today-header' : ''}">${h.day}<br><small>${h.dateNum}</small></th>`).join('')}
            </tr>
        `;

        const timeSlots = [];
        for (let hour = 9; hour <= 20; hour++) {
            const displayHour = hour > 12 ? hour - 12 : hour;
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const timeLabel = `${displayHour}:00 ${ampm}`;
            timeSlots.push({ hour, label: timeLabel });
        }

        const todayStr = formatDate(new Date());
        const tbody = document.getElementById('timeSlotsBody');
        let bodyHTML = '';

        for (const slot of timeSlots) {
            bodyHTML += '<tr>';
            bodyHTML += `<td class="slot-time-label"><strong>${slot.label}</strong></td>`;

            for (const date of dates) {
                const isPast = date < todayStr;
                const slotsForDate = timeSlotsData[date] || [];
                const hasAnySlot = slotsForDate.length > 0; // ← check if date already has any slot
                const matchingSlots = slotsForDate.filter(s => s.hour === slot.hour);

                if (matchingSlots.length > 0) {
                    let slotsHTML = '';
                    matchingSlots.forEach(s => {
                        const statusClass = s.status === 'blocked' ? 'blocked' : '';
                        const bookingsText = s.current_bookings > 0 ? `(${s.current_bookings}/${s.max_bookings})` : '';
                        slotsHTML += `
                            <div class="slot-item ${statusClass}">
                                <span class="slot-time">${s.start_time} - ${s.end_time}</span>
                                <span class="slot-bookings">${bookingsText}</span>
                                <div class="slot-actions">
                                    <button class="edit-slot" data-id="${s.id}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-slot" data-id="${s.id}" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                    bodyHTML += `<td class="slot-cell${isPast ? ' past-date' : ''}">${slotsHTML}</td>`;
                } else {
                    // Show "+" only if date is not past AND has no slots at all
                    if (!isPast && !hasAnySlot) {
                        bodyHTML += `
                            <td class="slot-cell">
                                <div class="empty-slot">
                                    <span>—</span>
                                    <button class="add-slot-btn" data-date="${date}" data-time="${slot.hour}:00" title="Add slot">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                    } else {
                        bodyHTML += `<td class="slot-cell past-date"><div class="empty-slot" style="opacity:0.4; pointer-events:none;"><span>—</span></div></td>`;
                    }
                }
            }
            bodyHTML += '</tr>';
        }

        tbody.innerHTML = bodyHTML;
        attachSlotEventListeners();
    }
    
    // Render Month View
    function renderMonthView() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDayOfWeek = firstDay.getDay();

        // Adjust to Monday first (0 = Sunday, so shift)
        const adjustedStartDay = startDayOfWeek === 0 ? 6 : startDayOfWeek - 1;

        const daysInMonth = lastDay.getDate();
        const prevMonthDays = new Date(year, month, 0).getDate();

        // Get today's date as string for comparison
        const todayStr = formatDate(new Date());

        const dates = [];

        // Previous month days
        for (let i = adjustedStartDay - 1; i >= 0; i--) {
            const day = prevMonthDays - i;
            dates.push({
                date: formatDate(new Date(year, month - 1, day)),
                day: day,
                isCurrentMonth: false,
                isToday: false
            });
        }

        // Current month days
        for (let day = 1; day <= daysInMonth; day++) {
            const currentDateObj = new Date(year, month, day);
            dates.push({
                date: formatDate(currentDateObj),
                day: day,
                isCurrentMonth: true,
                isToday: formatDate(currentDateObj) === todayStr
            });
        }

        // Next month days (to fill grid)
        const remainingCells = 42 - dates.length; // 6 rows * 7 days = 42
        for (let day = 1; day <= remainingCells; day++) {
            dates.push({
                date: formatDate(new Date(year, month + 1, day)),
                day: day,
                isCurrentMonth: false,
                isToday: false
            });
        }

        // Render headers (days of week)
        const thead = document.getElementById('tableHeaders');
        const weekdays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        thead.innerHTML = `
            <tr>
                <th>Date</th>
                ${weekdays.map(day => `<th>${day}</th>`).join('')}
            </tr>
        `;

        // Build table body (rows of weeks)
        const tbody = document.getElementById('timeSlotsBody');
        let bodyHTML = '';

        for (let i = 0; i < dates.length; i += 7) {
            const weekDates = dates.slice(i, i + 7);
            bodyHTML += '<tr>';

            // First column shows week number or date range
            const firstDate = weekDates[0];
            const lastDate = weekDates[6];
            bodyHTML += `<td class="week-number">Week ${Math.ceil((i + 1) / 7)}<br><small>${firstDate.day}/${lastDate.day}</small></td>`;

            for (const date of weekDates) {
                const hasSlots = Object.keys(timeSlotsData).some(key => key.startsWith(date.date));
                const dateObj = new Date(date.date);
                const dayOfMonth = dateObj.getDate();

                // 🆕 Check if this date is in the past
                const isPast = date.date < todayStr;

                let cellClass = 'month-cell';
                if (!date.isCurrentMonth) cellClass += ' other-month';
                if (date.isToday) cellClass += ' today';
                if (hasSlots) cellClass += ' has-slots';
                // 🆕 Add 'past' class if date is before today
                if (isPast) cellClass += ' past';

                bodyHTML += `
                    <td class="${cellClass}" data-date="${date.date}">
                        <div class="month-day">${dayOfMonth}</div>
                        <div class="month-slots">
                            ${hasSlots ? '<i class="fas fa-clock"></i> Available' : '<span class="no-slots">No slots</span>'}
                        </div>
                    </td>
                `;
            }
            bodyHTML += '</tr>';
        }

        tbody.innerHTML = bodyHTML;

        // 🆕 Attach click handlers only to non-past cells with slots
        document.querySelectorAll('.month-cell.has-slots:not(.past)').forEach(cell => {
            cell.addEventListener('click', function(e) {
                // Prevent opening for past dates (double-safe)
                const date = this.dataset.date;
                if (date < todayStr) return;
                showSlotsForDate(date);
            });
        });
    }
    
    // Show slots dialog for a specific date (month view)
    function showSlotsForDate(date) {
        const todayStr = formatDate(new Date());
        if (date < todayStr) {
            showNotification('Cannot manage slots for past dates.', 'error');
            return;
        }

        // Get slots for this date (both data structures)
        let slotsForDate = [];
        if (Array.isArray(timeSlotsData[date])) {
            slotsForDate = timeSlotsData[date];
        } else {
            slotsForDate = Object.entries(timeSlotsData)
                .filter(([key]) => key.startsWith(date))
                .map(([key, slot]) => slot);
        }

        if (slotsForDate.length === 0) {
            showNotification('No slots found for this date.', 'error');
            return;
        }

        let modalHtml = `
            <div id="slotsDialog" class="modal" style="display: flex;">
                <div class="modal-content" style="max-width: 500px;">
                    <div class="modal-header">
                        <h3>Time Slots for ${new Date(date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' })}</h3>
                        <button class="modal-close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="slots-list">
        `;

        slotsForDate.forEach(slot => {
            modalHtml += `
                <div class="slot-item-dialog ${slot.status === 'blocked' ? 'blocked' : ''}">
                    <span><strong>${slot.start_time} - ${slot.end_time}</strong></span>
                    <span>Booked: ${slot.current_bookings}/${slot.max_bookings}</span>
                    <div>
                        <button class="edit-slot-dialog btn-small" data-id="${slot.id}">Edit</button>
                        <button class="delete-slot-dialog btn-small-danger" data-id="${slot.id}">Delete</button>
                    </div>
                </div>
            `;
        });

        modalHtml += `
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-secondary" data-dismiss="modal">Close</button>
                        <!-- No "Add New Slot" button – one slot per date is enforced -->
                    </div>
                </div>
            </div>
        `;

        const existingDialog = document.getElementById('slotsDialog');
        if (existingDialog) existingDialog.remove();

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Event listeners for close, edit, delete
        document.querySelectorAll('[data-dismiss="modal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.modal').remove();
            });
        });

        document.querySelectorAll('.edit-slot-dialog').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                this.closest('.modal').remove();
                editSlot(id);
            });
        });

        document.querySelectorAll('.delete-slot-dialog').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                this.closest('.modal').remove();
                deleteSlot(id);
            });
        });
    }
    
    // Attach event listeners for week view
    function attachSlotEventListeners() {
        document.querySelectorAll('.edit-slot').forEach(btn => {
            btn.removeEventListener('click', handleEditClick);
            btn.addEventListener('click', handleEditClick);
        });
        
        document.querySelectorAll('.delete-slot').forEach(btn => {
            btn.removeEventListener('click', handleDeleteClick);
            btn.addEventListener('click', handleDeleteClick);
        });
        
        document.querySelectorAll('.add-slot-btn').forEach(btn => {
            btn.removeEventListener('click', handleAddClick);
            btn.addEventListener('click', handleAddClick);
        });
    }
    
    function handleEditClick(e) {
        editSlot(e.currentTarget.dataset.id);
    }
    
    function handleDeleteClick(e) {
        deleteSlot(e.currentTarget.dataset.id);
    }
    
    function handleAddClick(e) {
        openAddModal(e.currentTarget.dataset.date, e.currentTarget.dataset.time);
    }
    
    // Update statistics
    function updateStats() {
        const slots = Object.values(timeSlotsData);
        const total = slots.length;
        const available = slots.filter(s => s.status === 'available').length;
        const booked = slots.filter(s => s.current_bookings > 0).length;
        
        document.getElementById('totalSlots').textContent = total;
        document.getElementById('availableSlots').textContent = available;
        document.getElementById('bookedSlots').textContent = booked;
    }
    
    // Open add modal
    function openAddModal(date, time) {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('modalTitle').textContent = 'Add Time Slot';
        document.getElementById('slotId').value = '';
        
        // Set the date and min attribute
        const dateInput = document.getElementById('slotDate');
        dateInput.value = date;
        dateInput.setAttribute('min', today);   // <-- prevents selecting past dates
        
        document.getElementById('startTime').value = time;
        document.getElementById('endTime').value = '';
        document.getElementById('maxBookings').value = '1';
        document.getElementById('slotStatus').value = 'available';
        document.getElementById('slotModal').style.display = 'flex';
    }
    
    // Edit slot
    async function editSlot(id) {
        console.log('Editing slot with ID:', id);
        
        try {
            const response = await fetch(`/dashboard/time-slots/${id}/edit`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const slot = await response.json();
            console.log('Slot data received:', slot);
            
            // FIX: Format the date properly for input[type="date"]
            let formattedDate = slot.date;
            if (formattedDate && formattedDate.includes('T')) {
                // Convert "2026-05-02T00:00:00.000000Z" to "2026-05-02"
                formattedDate = formattedDate.split('T')[0];
            }
            
            // FIX: Format time for input[type="time"]
            let formattedStartTime = slot.start_time;
            let formattedEndTime = slot.end_time;
            
            if (formattedStartTime && formattedStartTime.includes('T')) {
                // Convert "2026-05-02T16:24:00.000000Z" to "16:24"
                formattedStartTime = formattedStartTime.split('T')[1].split('.')[0].substring(0, 5);
            }
            
            if (formattedEndTime && formattedEndTime.includes('T')) {
                formattedEndTime = formattedEndTime.split('T')[1].split('.')[0].substring(0, 5);
            }
            
            // Populate the form
            document.getElementById('modalTitle').textContent = 'Edit Time Slot';
            document.getElementById('slotId').value = slot.id;
            document.getElementById('slotDate').value = formattedDate;
            document.getElementById('startTime').value = formattedStartTime;
            document.getElementById('endTime').value = formattedEndTime;
            document.getElementById('maxBookings').value = slot.max_bookings;
            document.getElementById('slotStatus').value = slot.status;
            
            // Show the modal
            document.getElementById('slotModal').style.display = 'flex';
            
        } catch (error) {
            console.error('Error loading slot:', error);
            showNotification('Error loading slot: ' + error.message, 'error');
        }
    }
    
    // Delete slot
    function deleteSlot(id) {
        deleteId = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }
    
    // Navigation handlers
    function previousPeriod() {
        let newDate = new Date(currentDate);
        if (currentView === 'week') {
            newDate.setDate(newDate.getDate() - 7);
            const { start: todayStart } = getWeekRange(new Date());
            if (newDate < todayStart) {
                newDate = new Date(); // reset to today
            }
        } else {
            newDate.setMonth(newDate.getMonth() - 1);
            const today = new Date();
            if (newDate < new Date(today.getFullYear(), today.getMonth(), 1)) {
                newDate = today;
            }
        }
        currentDate = newDate;
        updateHeaderDisplay();
        loadTimeSlots();
    }
    
    function nextPeriod() {
        if (currentView === 'week') {
            currentDate.setDate(currentDate.getDate() + 7);
        } else {
            currentDate.setMonth(currentDate.getMonth() + 1);
        }
        updateHeaderDisplay();
        loadTimeSlots();
    }
    
    function switchView(view) {
        currentView = view;
        currentDate = new Date(); // Reset to today when switching view
        updateHeaderDisplay();
        
        // Update active button state
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.view === view) {
                btn.classList.add('active');
            }
        });
        
        loadTimeSlots();
    }
    
    // Show notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `time-slot-notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${type === 'success' ? '#4caf50' : '#f44336'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            z-index: 10001;
            animation: slideInRight 0.3s ease;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        `;
        notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i> ${message}`;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }
    
    // Initialize event listeners
    function initEventListeners() {
        // Navigation buttons
        document.getElementById('prevWeek')?.addEventListener('click', previousPeriod);
        document.getElementById('nextWeek')?.addEventListener('click', nextPeriod);
        
        // View toggle buttons
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => switchView(btn.dataset.view));
        });
        
        // Add slot button
        document.getElementById('addSlotBtn')?.addEventListener('click', () => {
            const today = formatDate(new Date());
            openAddModal(today, '09:00');
        });
        
        // Bulk create button
        document.getElementById('bulkCreateBtn')?.addEventListener('click', () => {
            document.getElementById('bulkModal').style.display = 'flex';
        });
        
        // Form submission
        document.getElementById('slotForm')?.addEventListener('submit', saveSlot);
        document.getElementById('confirmBulkCreate')?.addEventListener('click', bulkCreate);
        document.getElementById('confirmDelete')?.addEventListener('click', confirmDelete);
        
        // Modal close handlers
        document.querySelectorAll('.modal-close, .modal-cancel').forEach(btn => {
            btn.addEventListener('click', function() {
                const modal = this.closest('.modal');
                if (modal) modal.style.display = 'none';
            });
        });
        
        // Close modal on outside click
        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });
    }
    
    // Save slot
    async function saveSlot(e) {
        e.preventDefault();
        
        const slotId = document.getElementById('slotId').value;
        const isEdit = slotId && slotId !== '';
        
        const url = isEdit ? `/dashboard/time-slots/${slotId}` : '/dashboard/time-slots';
        const method = isEdit ? 'PUT' : 'POST';
        
        // Get raw date and time values
        const rawDate = document.getElementById('slotDate').value;
        const rawStartTime = document.getElementById('startTime').value;
        const rawEndTime = document.getElementById('endTime').value;
        
        // Validate inputs
        if (!rawDate || !rawStartTime || !rawEndTime) {
            showNotification('Please fill all required fields', 'error');
            return;
        }
        
        // Format data for database
        const formData = {
            date: rawDate, // Already in YYYY-MM-DD format
            start_time: rawStartTime, // Will be stored as time
            end_time: rawEndTime,
            max_bookings: parseInt(document.getElementById('maxBookings').value),
            status: document.getElementById('slotStatus').value
        };
        
        console.log('Saving slot data:', formData);
        
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(formData)
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                showNotification(data.message, 'success');
                document.getElementById('slotModal').style.display = 'none';

                // ---- NEW: Navigate to the slot's date ----
                const slotDate = new Date(rawDate + 'T00:00:00');
                currentDate = slotDate;               // update the global date
                updateHeaderDisplay();                // refresh the header (week/month label)
                loadTimeSlots();                     // reload data for the new range
            } else {
                showNotification(data.message || 'Error saving slot', 'error');
            }
        } catch (error) {
            console.error('Error saving slot:', error);
            showNotification('Network error: ' + error.message, 'error');
        }
    }
    
    // Bulk create
    async function bulkCreate() {
        const formData = {
            start_date: document.getElementById('bulkStartDate').value,
            end_date: document.getElementById('bulkEndDate').value,
            start_time: document.getElementById('bulkStartTime').value,
            end_time: document.getElementById('bulkEndTime').value,
            max_bookings: document.getElementById('bulkMaxBookings').value,
            repeat_days: Array.from(document.querySelectorAll('#bulkModal input[type="checkbox"]:checked')).map(cb => cb.value)
        };
        
        try {
            const response = await fetch('/dashboard/time-slots/bulk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message, 'success');
                document.getElementById('bulkModal').style.display = 'none';

                // ---- NEW: Navigate to the start date ----
                const startDate = new Date(formData.start_date + 'T00:00:00');
                currentDate = startDate;
                updateHeaderDisplay();
                loadTimeSlots();
            } else {
                showNotification(data.message || 'Error creating slots', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Network error', 'error');
        }
    }
    
    // Confirm delete
    async function confirmDelete() {
        if (!deleteId) return;
        
        try {
            const response = await fetch(`/dashboard/time-slots/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message, 'success');
                document.getElementById('deleteModal').style.display = 'none';
                loadTimeSlots();
            } else {
                showNotification(data.message || 'Error deleting slot', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Network error', 'error');
        }
        
        deleteId = null;
    }
    
    // Initial load
    function init() {
        initEventListeners();
        updateHeaderDisplay();
        loadTimeSlots();
    }
    
    init();
})();
</script>
@endpush