<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:150'],
            'pesan' => ['required', 'string', 'max:2000'],
        ]);

        Contact::create($validated);

        return redirect()
            ->route('contact')
            ->with('success', 'Pesan kamu sudah terkirim. Admin akan membalas melalui email yang kamu isi.');
    }

    public function index()
    {
        $contacts = Contact::latest()->paginate(15);

        return view('admin.contact', compact('contacts'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}