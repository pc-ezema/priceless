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
@if(!empty($appointment->addons))
    {{ implode(", ", $appointment->addons) }}
@else
    None
@endif
- **Date:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}  
- **Time:** {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}

@if($appointment->notes)
## 📝 Special Instructions
{{ $appointment->notes }}
@endif

@if($isWaxingService)
---
## 📄 Important Waxing Documents

Please find attached the following documents for your waxing appointment:

1. **Client Medical Forms** - Please complete before your appointment
2. **Consultation Form** - Required for first-time clients  
3. **GDPR Consent Form** - Data protection and privacy policy

> ⚠️ **Note:** Please review and complete these forms before your appointment. You may also fill them out at the salon upon arrival.

**Why these forms are needed:**
- To ensure your safety during the treatment
- To understand any medical conditions or allergies
- To comply with health and safety regulations
- To provide you with the best possible service

If you have any questions about the forms, please contact us before your appointment.
@endif

We look forward to seeing you! Please arrive a few minutes early and bring any necessary items for your appointment.

@component('mail::button', ['url' => url('/'), 'color' => 'primary'])
Visit Our Website
@endcomponent

Thanks,<br>
**{{ config('app.name') }} Team**
@endcomponent