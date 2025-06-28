<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id(); // 👈 Logged-in user ID
        $search = $request->input('search');

        $query = ContactMessage::where('user_id', $userId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(5)->withQueryString();

        return Inertia::render('Admin/Messages', [
            'messages' => $messages,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function destroy($id)
    {
        \App\Models\ContactMessage::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Message deleted.');
    }

    public function export(): StreamedResponse
    {
        $userId = Auth::id();
        $contacts = ContactMessage::where('user_id', $userId)->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="my_contacts.csv"',
        ];

        $callback = function () use ($contacts) {
            $handle = fopen('php://output', 'w');
            // Header row
            fputcsv($handle, ['Name', 'Email', 'Phone', 'Submitted At']);

            // Data rows
            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->name,
                    $contact->email,
                    $contact->phone_number,
                    $contact->created_at,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
