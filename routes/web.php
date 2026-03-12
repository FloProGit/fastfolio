<?php

use Illuminate\Support\Facades\Route;


Route::prefix('{locale}')
    ->where(['locale' => 'fr|en'])
    ->middleware(\App\Http\Middleware\SetLocale::class)
    ->group(function () {
        Route::get('/', function () {
            return view('welcome');
        });

        // Switch langue
        Route::get('/lang/{newLocale}', function (string $locale, string $newLocale) {
            if (in_array($newLocale, ['fr', 'en'])) {
                $path = preg_replace('#^' . $locale . '#', $newLocale, request()->path());
                return redirect('/' . $path);
            }
            return back();
        })->name('locale.switch');
    });

// Racine → redirige vers la locale par défaut
Route::get('/', fn () => redirect('/' . config('app.locale')));
