@component('mail::message')
{{-- Logo --}}
<p style="text-align: center; margin-bottom: 20px;">
    <img src="{{ url('images/logo.png') }}" alt="{{ config('app.name') }}" style="height: 70px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
</p>

# 🎉 New Appointment Booking

A new appointment has been successfully booked!  

---

## 👤 Customer Details
- **Name:** {{ $appointment->name }}  
- **Email:** {{ $appointment->email }}  
- **Phone:** {{ $appointment->phone }}

## 💇‍♀️ Appointment Details
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

@component('mail::button', ['url' => url('/dashboard/appointments'), 'color' => 'success'])
View in Dashboard
@endcomponent

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
