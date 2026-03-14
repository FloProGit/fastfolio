<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetApiLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language', 'fr');

        if (in_array($locale, ['fr', 'en'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
