<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Addon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $service;
    public $addons;
    public $subtotal;
    public $deposit;
    public $balance;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, ?Service $service = null)
    {
        $this->appointment = $appointment;
        $this->service = $service; // may be null

        // Fetch add-ons...
        $addonNames = is_array($appointment->addons) 
            ? $appointment->addons 
            : (json_decode($appointment->addons, true) ?? []);
        
        $this->addons = Addon::whereIn('name', $addonNames)->get();

        $servicePrice = $this->service ? $this->service->price : 0;
        $addonTotal = $this->addons->sum('price');
        $this->subtotal = $servicePrice + $addonTotal;
        $this->deposit = round($this->subtotal * 0.30, 2);
        $this->balance = round($this->subtotal - $this->deposit, 2);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Appointment Booked - #' . $this->appointment->id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.appointment',
            with: [
                'appointment' => $this->appointment,
                'service'     => $this->service,
                'addons'      => $this->addons,
                'subtotal'    => $this->subtotal,
                'deposit'     => $this->deposit,
                'balance'     => $this->balance,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}