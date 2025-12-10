<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kode;

    public function __construct($kode)
    {
        $this->kode = $kode;
    }

    public function build()
    {
       return $this->subject('Kode Reset Password Anda')
            ->view('reset_password')
            ->with(['kode' => $this->kode]);

    }
}
