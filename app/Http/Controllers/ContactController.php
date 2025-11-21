<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'nullable|email|max:255',
            'phone'=>'nullable|string|max:100',
            'message'=>'required|string|max:2000',
        ]);

        ContactMessage::create($data);

        return back()->with('success', 'Thank you — we received your message.');
    }
}
