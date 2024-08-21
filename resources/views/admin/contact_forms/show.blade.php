@extends('layouts.admin')

@section('page_title', 'View Contact Form')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-eye"></i></div>
                            View Contact Form
                        </h1>
                        <div class="page-header-subtitle">
                            Viewing an contact form
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header">Contact Form</div>
            <div class="card-body">
                <form class="needs-validation">
                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="name" class="col-form-label">Name</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="name" name="name" type="text" class="form-control" value="{{ $contact_form->name }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="email" class="col-form-label">Email</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="email" name="email" type="text" class="form-control" value="{{ $contact_form->email }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="mobile" class="col-form-label">Mobile</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="mobile" name="mobile" type="text" class="form-control" value="{{ $contact_form->mobile }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="subject" class="col-form-label">Subject</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="subject" name="subject" type="text" class="form-control" value="{{ $contact_form->subject }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="message" class="col-form-label">Message</label>
                        </div>
                        <div class="col-xl-8">
                            <div id="message" class="form-control lh-base" readonly>{!! nl2br($contact_form->message) !!}</div>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="ip_address" class="col-form-label">IP Address</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="ip_address" name="ip_address" type="text" class="form-control" value="{{ $contact_form->ip_address }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="created_at" class="col-form-label">Submitted At</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="created_at" name="created_at" type="text" class="form-control" value="@humanDateTime($contact_form->created_at)" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-xl-2 col-xl-8">
                            <a href="{{ $contact_form->indexRoute() }}" class="me-1 btn btn-secondary">
                                <i class="fas fa-fw fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection