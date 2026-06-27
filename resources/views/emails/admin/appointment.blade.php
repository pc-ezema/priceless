{{-- resources/views/emails/admin/appointment.blade.php --}}

@component('mail::message')
{{-- Logo --}}
<p style="text-align: center; margin-bottom: 20px;">
    <img src="{{ url('images/logo.png') }}" alt="{{ config('app.name') }}" style="height: 70px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
</p>

# 🎉 New Appointment Booking

A new appointment has been successfully booked!  
**Booking ID:** #{{ $appointment->id }}

---

## 👤 Customer Details
- **Name:** {{ $appointment->name }}  
- **Email:** {{ $appointment->email }}  
- **Phone:** {{ $appointment->phone }}

---

## 💇‍♀️ Appointment Details
- **Service:** {{ $appointment->service }}  
- **Date:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}  
- **Time:** {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}

---

## 💰 Payment Breakdown

| Item | Amount |
|------|--------|
| **{{ $service->name ?? $appointment->service }}** | ${{ number_format($service->price ?? 0, 2) }} |
@foreach($addons as $addon)
| {{ $addon->name }} (add‑on) | +${{ number_format($addon->price, 2) }} |
@endforeach
| **Subtotal** | **${{ number_format($subtotal, 2) }}** |
| **Deposit (30%)** | **${{ number_format($deposit, 2) }}** |
| **Balance Due** | **${{ number_format($balance, 2) }}** |

> 💡 The customer is required to pay the **30% deposit** to secure the booking.  
> **Bank details for deposit:**  
> Account Name: Priceless Beauty Touch  
> Sort Code: 60-84-64  
> Account Number: 87478568

---

@if($appointment->notes)
## 📝 Special Instructions
{{ $appointment->notes }}
@endif

@component('mail::button', ['url' => url('/dashboard/appointments'), 'color' => 'success'])
View in Dashboard
@endcomponent

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent