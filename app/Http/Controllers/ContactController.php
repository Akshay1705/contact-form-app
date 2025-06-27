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
            'phone_number' => 'required|string|max:15',
        ]);

        ContactMessage::create($validated);

        return redirect('/admin/messages')->with([
            'success' => 'Contact added successfully!',
            'action' => 'added'
        ]);
    }

    public function destroy($id)
    {
        ContactMessage::findOrFail($id)->delete();

        return redirect('/admin/messages')->with([
            'success' => 'Contact deleted.',
            'action' => 'deleted'
        ]);
    }
}
