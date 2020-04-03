<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable {

    use Queueable,
        SerializesModels;

    protected $message;
    protected $contactName;
    protected $contactEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactName, $contactEmail, $message) {

        $this->ContactName = $contactName;
        $this->ContactEmail = $contactEmail;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        
        $this->from(config('mail.username'), $this->contactName)
                ->replyTo($this->ContactEmail)
                ->subject('You have new message on contact form');


        return $this->view('front.emails.contact_form')
                        ->with([
                            'contactName' => $this->ContactName,
                            'contactMessage' => $this->message,
        ]);
    }

}
