<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('{locale}/admin')
                ->where(['locale' => 'fr|en'])
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
            $middleware->redirectUsersTo(function ($request) {
                $locale = $request->segment(1);
                if (!in_array($locale, ['fr', 'en'])) {
                    $locale = config('app.locale');
                }
                return route('admin.dashboard', ['locale' => $locale]);
            });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
