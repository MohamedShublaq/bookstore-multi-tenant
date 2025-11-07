<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('Library.changePassword');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $admin = $request->user();
            $admin->update([
                'password' => $request->password
            ]);
            return redirect()->route('library.home')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Operation Failed');
        }
    }
}
