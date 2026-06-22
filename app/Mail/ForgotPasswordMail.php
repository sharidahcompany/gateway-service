<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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
