<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return response()->json(
            Contact::latest()->paginate(10)
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string'],
        ]);

        $contact = Contact::create($validated);

        return response()->json([
            'message' => 'Your message has been submitted successfully.',
            'data' => $contact,
        ], 201);
    }

    

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'message' => 'Contact message deleted successfully.',
        ]);
    }



}
