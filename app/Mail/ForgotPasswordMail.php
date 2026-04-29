<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\OTP;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public int $otp
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Reset OTP'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.forgot-password',
            with: [
                'user' => $this->user,
                'otp' => $this->otp,
            ]
        );
    }
}
