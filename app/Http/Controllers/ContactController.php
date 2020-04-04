<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;

class ContactController extends Controller {

    public function index(Request $request) {

        $systemMessage = session()->pull('system_message');

        return view('front.contact.index', [
            'systemMessage' => $systemMessage,
        ]);
    }

    public function sendMessage(Request $request) {



        $formData = $request->validate([
            'contact_person' => ['required', 'string', 'min:2', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_message' => ['required', 'string', 'min:50', 'max:500'],
            'g-recaptcha-response' => ['recaptcha']
        ]);

        \Mail::to('maximovic.daca@gmail.com')->send(new ContactFormMail(
                        $formData['contact_person'],
                        $formData['contact_email'],
                        $formData['contact_message'],
        ));



        session()->flash(
                'system_message',
                'Your message has been received, we will contact you soon!!!'
        );
        return redirect()->back();
    }

}
