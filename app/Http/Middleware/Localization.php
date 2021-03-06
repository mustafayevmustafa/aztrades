<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{

    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        return $next($request);
    }

    public function locale(string $locale): RedirectResponse
    {
        if (!array_key_exists($locale, config('app.locales')))
        {
            abort(403);
        }

        App::setLocale($locale);
        session()->put('locale', $locale);
        return back();
    }
}
