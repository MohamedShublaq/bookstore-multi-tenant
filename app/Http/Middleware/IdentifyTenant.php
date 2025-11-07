<?php

namespace App\Http\Middleware;

use App\Models\Library;
use Closure;

class IdentifyTenant
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $mainDomain = config('app.main_domain', 'bookstore.test');

        $subdomain = str_replace('.' . $mainDomain, '', $host);

        if ($subdomain && $subdomain !== $mainDomain) {
            $library = Library::where('slug', $subdomain)->first();

            if ($library) {
                app()->instance('library', $library);
            } else {
                abort(404, 'Library not found');
            }
        }

        return $next($request);
    }
}
