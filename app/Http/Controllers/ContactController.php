<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        ContactMessage::create($validated);

        return redirect('/contact')->with('success', 'Message saved successfully!');
    }
}
