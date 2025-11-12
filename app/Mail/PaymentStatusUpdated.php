<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $status;
    public $isEnrollment;

    public function __construct(User $user, $status, $isEnrollment = false)
    {
        $this->user = $user;
        $this->status = $status;
        $this->isEnrollment = $isEnrollment;
    }

    public function build()
    {
        $subject = $this->isEnrollment
            ? "Enrollment Payment Status Update - Millennium Academy"
            : "Registration Payment Status Update - Millennium Academy";

        return $this->subject($subject)
                    ->view('emails.payment-status-updated')
                    ->with([
                        'isEnrollment' => $this->isEnrollment
                    ]);
    }
}
