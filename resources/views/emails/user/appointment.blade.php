{{-- resources/views/emails/user/appointment.blade.php --}}

@component('mail::message')
{{-- Logo --}}
<p style="text-align: center; margin-bottom: 20px;">
    <img src="{{ url('images/logo.png') }}" alt="{{ config('app.name') }}" style="height: 70px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
</p>

# ✅ Appointment Confirmed!

Hi **{{ $appointment->name }}**,  
Your appointment has been successfully booked.  

---

## 💇‍♀️ Appointment Summary
- **Service:** {{ $appointment->service }}  
- **Add-ons:**  
@if($addons->isNotEmpty())
    @foreach($addons as $addon)
        - {{ $addon->name }} (+${{ number_format($addon->price, 2) }})<br>
    @endforeach
@else
    None
@endif
- **Date:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}  
- **Time:** {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}

---

## 💰 Payment Breakdown

| Item | Amount |
|------|--------|
| **{{ $service->name }}** | ${{ number_format($service->price, 2) }} |
@foreach($addons as $addon)
| {{ $addon->name }} (add‑on) | +${{ number_format($addon->price, 2) }} |
@endforeach
| **Subtotal** | **${{ number_format($subtotal, 2) }}** |
| **Deposit Required (30%)** | **${{ number_format($deposit, 2) }}** |
| **Balance Due at Salon** | **${{ number_format($balance, 2) }}** |

> 💡 A **30% deposit** is required to secure your appointment. Please pay the deposit of **${{ number_format($deposit, 2) }}** before your appointment date. The remaining balance is payable at the salon.

---

## 🏦 Bank Transfer Details

Please make your deposit payment via bank transfer to the following account:

| Detail | Information |
|--------|-------------|
| **Account Name** | Priceless Beauty Touch |
| **Sort Code** | 60-84-64 |
| **Account Number** | 87478568 |

> ⚠️ **Important:** Please use your **full name** and **appointment date** as the payment reference so we can match your payment to your booking.

---

@if($appointment->notes)
## 📝 Special Instructions
{{ $appointment->notes }}
@endif

@if($isWaxingService)
---
## 📄 Important Waxing Documents

... (your existing waxing documents section) ...
@endif

We look forward to seeing you! Please arrive a few minutes early.

@component('mail::button', ['url' => url('/'), 'color' => 'primary'])
Visit Our Website
@endcomponent

Thanks,<br>
**{{ config('app.name') }} Team**
@endcomponent