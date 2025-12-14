<?php

namespace App\Http\Controllers\Auth\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\IdentifierLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('website.home');
        }

        return view('Website.Auth.login');
    }

    public function login(IdentifierLoginRequest $request)
    {
        try {
            //Login using email or phone
            $type = filter_var($request->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            //Global scope in the User model will check if the user belongs to the current library or not
            $user = User::where($type, $request->identifier)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Invalid email or password.');
            }

            Auth::login($user);
            return redirect()->intended(tenant_route('website.home'))->with('success', 'Welcome back!');

        } catch (\Exception $e) {
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(tenant_route('showLogin'));
    }
}
