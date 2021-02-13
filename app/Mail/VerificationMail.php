<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
//use Illuminate\Notifications\Messages\MailMessage;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        //return $this->view('view.name');
        /*$url = url('http://localhost:8000/verification/'.$token);
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('Please confirm link or button activation email below!')
            ->action('click to verify your email',$url)
            ->line('Thank you for using our application!');*/

        return $this->view('emails.mymail');
    }
}
