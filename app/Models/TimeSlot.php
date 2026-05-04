<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function isAvailable()
    {
        return $this->status === 'available' && $this->current_bookings < $this->max_bookings;
    }

    public function getAvailableSpotsAttribute()
    {
        return $this->max_bookings - $this->current_bookings;
    }

    // Generate 10-minute interval slots from the range
    public function getTenMinuteSlotsAttribute()
    {
        $slots = [];
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        
        // Generate slots in 10-minute intervals
        while ($start < $end) {
            $slotEnd = (clone $start)->addMinutes(10);
            
            $slots[] = [
                'slot_id' => $this->id,
                'start_time' => $start->format('H:i'),
                'start_display' => $start->format('g:i'),
                'end_time' => $slotEnd->format('H:i'),
                'end_display' => $slotEnd->format('g:i'),
                'available' => $this->current_bookings < $this->max_bookings,
                'available_spots' => $this->max_bookings - $this->current_bookings
            ];
            
            $start->addMinutes(10);
        }
        
        return $slots;
    }
    
    public function getIndividualSlotsAttribute()
    {
        $slots = [];
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        
        // Generate hourly slots
        while ($start < $end) {
            $slotEnd = (clone $start)->addHour();
            if ($slotEnd > $end) {
                $slotEnd = $end;
            }
            
            $slots[] = [
                'slot_id' => $this->id,
                'start_time' => $start->format('g:i A'),
                'end_time' => $slotEnd->format('g:i A'),
                'start_hour' => $start->format('H:i'),
                'end_hour' => $slotEnd->format('H:i'),
                'available' => $this->current_bookings < $this->max_bookings
            ];
            
            $start->addHour();
        }
        
        return $slots;
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                     ->whereRaw('current_bookings < max_bookings');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }
}
