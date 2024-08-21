<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\ContactRequest;
use App\Models\ContactForm;

class GuestController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware(\Spatie\Honeypot\ProtectAgainstSpam::class)->only('submitContact');
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function homepage()
    {
        return view('guest.homepage');
    }

    /**
     * Show the about page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        return view('guest.about');
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('guest.contact');
    }

    /**
     * Submit the contact form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(ContactRequest $request)
    {
        $form = ContactForm::create($request->validated());

        \Mail::send(new \App\Mail\ContactGuestMail($form));

        \Mail::send(new \App\Mail\ContactAdminMail($form));

        \Alert::success('Message sent successfully!');

        return redirect()->back();
    }
}
