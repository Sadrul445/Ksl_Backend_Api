<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\MarkdownEmail;

class ContactController extends Controller
{
    public function submitForm(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'content' => 'required',
        ]);

        // Return validation errors if present
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Process form submission (e.g., save to database, send email)
        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->phone_number = $request->input('phone_number');
        $contact->content = $request->input('content');
        $contact->save();

        // Send email notification
        Mail::to('sadrul@kslbd.net')->send(new MarkdownEmail(
            $contact->name,
            $contact->email,
            $contact->phone_number,
            $contact->content
        ));

        // Return success response
        return response()->json(
            [
                'message' => 'Form submitted successfully',
                'status' => 'success'
            ]
        );
    }
}
