<?php
// app/Mail/UserAppointmentMail.php

namespace App\Mail;

use App\Models\Appointment;
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

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $isWaxingService = false)
    {
        $this->appointment = $appointment;
        $this->isWaxingService = $isWaxingService;
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
                'appointment' => $this->appointment,
                'isWaxingService' => $this->isWaxingService,
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