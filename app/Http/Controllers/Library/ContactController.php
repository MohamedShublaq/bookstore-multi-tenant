<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use DataTableTrait;

    public function index()
    {
        return view('Library.Contacts.index');
    }

    public function getContacts(Request $request)
    {
        $query = Contact::latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name', 'email', 'message']
        );

        $result['data'] = $result['data']->map(function ($contact) {
            $contact->actions = '
                <button class="text-danger btn-delete" data-url="' . route('library.contacts.destroy', $contact->id) . '">
                    <i class="la la-trash"></i> Delete
                </button>
            ';

            return $contact;
        });

        return response()->json($result);
    }

    public function destroy(string $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
