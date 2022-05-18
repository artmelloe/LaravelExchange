<?php

namespace App\Http\Controllers;

use App\Mail\ExchangeMail;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;


class ExchangeMailController extends Controller
{

    public function submitMail(Request $request) :RedirectResponse
    {
        $to = $request->input('email');
        $subject = 'Currency Exchange';
        $data = Exchange::orderByDesc('created_at')->first();

        Mail::send(new ExchangeMail($to, $subject, $data));

        return Redirect::route('index')->with('submit_email_success', 'Your email has been sent!');
    }
}
