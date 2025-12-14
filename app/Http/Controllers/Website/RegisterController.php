<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('Website.Auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $currentLibrary = app('library');
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->full_phone,
                'password'   => $request->password,
                'library_id' => $currentLibrary->id,
            ]);

            Auth::login($user);

            return redirect()->intended(tenant_route('website.home'))->with('success', 'Welcome!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
