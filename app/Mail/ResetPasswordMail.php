<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $token, $type;

    public function __construct($user, $token, $type)
    {
        $this->user = $user;
        $this->token = $token;
        $this->type = $type;
    }

    public function build()
    {
        return $this->subject("Email khôi phục mật khẩu.")->view('emails.resetPassword-email');
    }
}
