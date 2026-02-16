<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMasterPassword
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('encryption_key')) {
            return redirect()->route('master-password.show', [
                'redirect' => url()->current()
            ]);
        }

        return $next($request);
    }
}