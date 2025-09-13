<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LamaranNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $namaPelamar;
    public $namaLowongan;

    /**
     * Create a new message instance.
     */
    public function __construct($namaPelamar, $namaLowongan)
    {
        $this->namaPelamar = $namaPelamar;
        $this->namaLowongan = $namaLowongan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Notifikasi Lamaran Baru')
                    ->view('emails.lamaran');
    }
}
