<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;
    public $emailContent;
    public $companyName;
    public $companyEmail;

    public function __construct($data)
    {
        $this->emailSubject = $data['subject'];
        $this->emailContent = $data['message']; // Renamed from 'message' to 'emailContent'
        $this->companyName = $data['company_name'];
        $this->companyEmail = $data['company_email'];
    }

    public function build()
    {
        return $this->subject($this->emailSubject)
            ->view('emails.company-mail')
            ->with([
                'emailSubject' => $this->emailSubject,
                'emailContent' => $this->emailContent, // Use emailContent
                'companyName' => $this->companyName,
                'companyEmail' => $this->companyEmail,
            ]);
    }
}
