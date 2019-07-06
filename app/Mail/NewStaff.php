<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewStaff extends Mailable
{
    use Queueable, SerializesModels;

    public $password,$user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password,$user)
    {
        $this->password = $password;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.welcome-emaill');
    }
}
