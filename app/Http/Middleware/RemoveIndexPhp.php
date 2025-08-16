<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveIndexPhp {

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        if (strpos($request->getRequestUri(), '/index.php') !== false) {
            $newUrl = str_replace('/index.php', '', $request->fullUrl());
            return redirect($newUrl, 301);
        }

        return $next($request);
    }
}
