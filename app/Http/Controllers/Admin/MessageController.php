<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->get();

        return Inertia::render('Admin/Messages', [
            'messages' => $messages
        ]);
    }

    public function destroy($id)
    {
        \App\Models\ContactMessage::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Message deleted.');
    }
}
