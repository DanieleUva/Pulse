<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
{
    $response = $next($request);

    // 1. Protezione contro il Clickjacking
    $response->headers->set('X-Frame-Options', 'DENY');
    
    // 2. Protezione contro il Mime-Sniffing (ZAP lo adora)
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    
    // 3. Protezione XSS base per i browser più vecchi
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    
    // 4. Content Security Policy (CSP) - La più importante
    // Inizia con questa "morbida", poi si può stringere
     $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; frame-ancestors 'none'; upgrade-insecure-requests;");

    return $response;
}
}
