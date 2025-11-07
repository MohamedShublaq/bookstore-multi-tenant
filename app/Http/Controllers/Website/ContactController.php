<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        try {
            Contact::create($request->validated());
            return redirect()->route('home')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
