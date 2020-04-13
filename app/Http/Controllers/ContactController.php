<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Models\BlogPost;
use App\Models\BlogPostCategory;

class ContactController extends Controller {

    public function index(Request $request) {

        $systemMessage = session()->pull('system_message');
        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();

        $mostViewedBlogPosts = BlogPost::query()->
                        orderby('views', 'DESC')
                        ->limit(3)->get();
        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();

        return view('front.contact.index', [
            'systemMessage' => $systemMessage,
            'latestBlogPosts' => $latestBlogPosts,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,
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
