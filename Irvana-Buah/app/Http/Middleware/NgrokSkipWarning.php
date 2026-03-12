<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NgrokSkipWarning
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya aktif di local/development dengan ngrok
        if (! app()->isProduction()) {
            $response->headers->set('ngrok-skip-browser-warning', 'true');
        }

        return $response;
    }
}
