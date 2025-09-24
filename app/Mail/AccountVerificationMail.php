<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $verificationLink;

    public function __construct($userName, $verificationLink)
    {
        $this->userName = $userName;
        $this->verificationLink = $verificationLink;
    }

    public function build()
    {
        return $this->markdown('emails.application-verification')
                    ->subject('Verifikasi Akun Anda');
    }
}
