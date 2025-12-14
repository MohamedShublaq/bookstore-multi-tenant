<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLibraryIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $library = app('library');
        if (!$library->status) {
            abort(404);
        }
        if (!$library->is_published) {
            return response()->view('Website.inactive', [
                'message' => $library->inactive_message ?? 'Library is inactive now!'
            ]);
        }
        return $next($request);
    }
}
