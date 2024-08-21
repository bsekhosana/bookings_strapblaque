<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;

class ContactFormController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(ContactForm::class, 'contact_form');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = ContactForm::search(function () {
            return ContactForm::latest('id')->paginate();
        }, 'contact_forms');

        return view('admin.contact_forms.index')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(ContactForm $contact_form)
    {
        return view('admin.contact_forms.show')->with(compact('contact_form'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(ContactForm $contact_form)
    {
        $deleted = $contact_form->delete();

        \Alert::crud($deleted, \Alert::Deleted, 'contact form');

        return redirect()->route('admin.contact_forms.index');
    }
}
