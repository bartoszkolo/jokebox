<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail; // Make sure to create this Mailable class.

class ContactController extends Controller
{
    public function sendContactForm(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'      
        ]);

        // Send an email
        Mail::send(new ContactFormMail($data));

        return redirect()->back()->with('success', 'Wiadomość została wysłana.');
    }
}
