<?php

namespace App\Http\Middleware;

use App\Models\LibraryAdmin;
use Closure;
use Illuminate\Http\Request;

class LibraryManager
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('library-admin')->user();

        if (! $user || ! $user->is_manager) {
            abort(403, 'Unauthorized access. Manager privileges required.');
        }

        if ($request->route('admin')) {
            $adminId = $request->route('admin');
            $targetAdmin = LibraryAdmin::findOrFail($adminId);

            if ($targetAdmin->id === $user->id) {
                abort(403, 'Unauthorized access to this resource.');
            }
        }

        return $next($request);
    }
}
