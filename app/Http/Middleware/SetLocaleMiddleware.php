<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;
        if (session()->has('locale') && array_key_exists(session('locale'), config('app.supported_locales'))) {
            $locale = session('locale');
            Log::info('Locale found in session.', ['locale' => $locale]);
        } else {
            $locale = config('app.locale');
            Log::info('Locale not found in session, using default.', ['locale' => $locale]);
        }
        app()->setLocale($locale);

        return $next($request);
    }
}
