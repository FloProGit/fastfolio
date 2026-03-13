<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->segment(1);

        if (in_array($locale, ['fr', 'en'])) {
            app()->setLocale($locale);
        } else {
            // Pas de locale dans l'URL → redirige vers la locale par défaut
            return redirect('/'.config('app.locale').'/'.$request->path());
        }

        // Pour que route() génère les URLs avec le prefix
        URL::defaults(['locale' => app()->getLocale()]);

        return $next($request);
    }
}
