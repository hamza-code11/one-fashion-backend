<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function index()
    {
        return response()->json(
            Newsletter::latest()->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('newsletters', 'email'),
            ],
        ]);

        $newsletter = Newsletter::create($validated);

        return response()->json([
            'message' => 'Successfully subscribed to newsletter.',
            'data' => $newsletter,
        ], 201);
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return response()->json([
            'message' => 'Subscriber removed successfully.',
        ]);
    }


}
