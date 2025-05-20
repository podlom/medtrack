<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Пріоритет: ?lang=uk → session('locale') → заголовок браузера
        $locale = $request->get('lang')
            ?? session('locale')
            ?? substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        // Дозволені мови
        if (! in_array($locale, ['en', 'uk'])) {
            $locale = config('app.fallback_locale', 'en');
        }

        App::setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
    }
}
