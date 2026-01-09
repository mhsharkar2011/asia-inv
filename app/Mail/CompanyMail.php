<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $companyName;
    public $companyEmail;

    public function __construct($data)
    {
        $this->subject = $data['subject'];
        $this->message = $data['message'];
        $this->companyName = $data['company_name'];
        $this->companyEmail = $data['company_email'];
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.company-mail') // This matches the view file
                    ->with([
                        'subject' => $this->subject,
                        'message' => $this->message,
                        'companyName' => $this->companyName,
                        'companyEmail' => $this->companyEmail,
                    ]);
    }
}
