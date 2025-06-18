<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class signedConsume
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->query('signature');

        if (!$signature || Cache::has("used_signature_{$signature}")) {
            abort(403, 'This link has already been used.');
        }

        // Mark the signature as used
        Cache::put("used_signature_{$signature}", true, now()->addMinutes(10));

        return $next($request);
    }
}
