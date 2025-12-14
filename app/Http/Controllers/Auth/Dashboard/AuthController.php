<?php

namespace App\Http\Controllers\Auth\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Models\Library;
use App\Models\LibraryAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard.home');
        }

        if (Auth::guard('library-admin')->check()) {
            return redirect()->route('library.home');
        }

        return view('Dashboard.Auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $host = $request->getHost();
            $mainDomain = config('app.main_domain', 'bookstore.test');
            $subdomain = str_replace('.' . $mainDomain, '', $host);

            // SUBDOMAIN ACCESS - Library Admin
            if ($subdomain && $subdomain !== $mainDomain) {

                $library = Library::where('slug', $subdomain)->firstOrFail();

                if (! $library->status) {
                    return back()->with('error', 'The library is inactive.');
                }

                $libraryAdmin = LibraryAdmin::where('email', $request->email)
                    ->where('library_id', $library->id)
                    ->first();

                if (! $libraryAdmin) {
                    return back()->with('error', 'Invalid email or password.');
                }

                if (Auth::guard('library-admin')->attempt([
                    'email' => $request->email,
                    'password' => $request->password
                ])) {
                    $request->session()->regenerate();
                    return redirect()->intended(route('library.home'));
                }

                return back()->with('error', 'Invalid email or password.');
            }

            // MAIN DOMAIN ACCESS - Super Admin
            if (Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard.home'));
            }

            return back()->with('error', 'Invalid email or password.');
        } catch (\Exception $e) {
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        $admin = $request->user();
        if ($admin instanceof Admin) {
            Auth::guard('admin')->logout();
        }
        if ($admin instanceof LibraryAdmin) {
            Auth::guard('library-admin')->logout();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.showLogin');
    }
}
