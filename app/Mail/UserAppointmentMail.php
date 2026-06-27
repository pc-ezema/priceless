<?php
// app/Mail/UserAppointmentMail.php

namespace App\Mail;

use App\Models\Addon;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class UserAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $isWaxingService;
    public $service;
    public $addons = [];
    public $subtotal;
    public $deposit;
    public $balance;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $isWaxingService = false, Service $service)
    {
        $this->appointment = $appointment;
        $this->isWaxingService = $isWaxingService;
        $this->service = $service;

        // Fetch add-ons
        // Assuming $appointment->addons is an array of add-on names or IDs
        // We'll try to get the add-on models
        $addonNames = is_array($appointment->addons) ? $appointment->addons : [];
        $addonModels = Addon::whereIn('name', $addonNames)->where('is_active', true)->get();

        // If the appointment stores IDs instead, adjust accordingly:
        // $addonIds = $appointment->addon_ids ?? [];
        // $addonModels = Addon::whereIn('id', $addonIds)->get();

        $this->addons = $addonModels;

        // Calculate totals
        $addonTotal = $addonModels->sum('price');
        $this->subtotal = $service->price + $addonTotal;
        $this->deposit = round($this->subtotal * 0.30, 2);
        $this->balance = round($this->subtotal - $this->deposit, 2);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Confirmation - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user.appointment',
            with: [
                'appointment'    => $this->appointment,
                'isWaxingService'=> $this->isWaxingService,
                'service'        => $this->service,
                'addons'         => $this->addons,
                'subtotal'       => $this->subtotal,
                'deposit'        => $this->deposit,
                'balance'        => $this->balance,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->isWaxingService) {
            // Document 1: Client Medical Forms
            $clientMedicalPath = storage_path('app/public/documents/client_medical_forms.pdf');
            if (file_exists($clientMedicalPath)) {
                $attachments[] = Attachment::fromPath($clientMedicalPath)
                    ->as('Client_Medical_Forms.pdf')
                    ->withMime('application/pdf');
            }
            
            // Document 2: Consultation Form
            $consultationPath = storage_path('app/public/documents/consultation_form.pdf');
            if (file_exists($consultationPath)) {
                $attachments[] = Attachment::fromPath($consultationPath)
                    ->as('Consultation_Form.pdf')
                    ->withMime('application/pdf');
            }
            
            // Document 3: GDPR Consent Form
            $gdprPath = storage_path('app/public/documents/gdpr_form.pdf');
            if (file_exists($gdprPath)) {
                $attachments[] = Attachment::fromPath($gdprPath)
                    ->as('GDPR_Consent_Form.pdf')
                    ->withMime('application/pdf');
            }
        }
        
        return $attachments;
    }
}