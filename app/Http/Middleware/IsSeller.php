<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSeller
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isSeller()) {
            return redirect()->route('profile.become-seller')
                ->with('info', 'Necesitas activar tu cuenta de vendedor para acceder a esta sección.');
        }

        return $next($request);
    }
}
