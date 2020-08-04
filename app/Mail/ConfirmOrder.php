<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $orderDetails;
    public $user;
    public $admin;

    public function __construct($user, $admin, $orderDetails)
    {
        $this->user = $user;
        $this->admin = $admin;
        $this->orderDetails = $orderDetails;
    }

    public function build()
    {
        return $this->from($this->admin->email)
            ->subject(trans('message.mail.subject_mail'))
            ->markdown('emails.confirm-order');
    }
}
