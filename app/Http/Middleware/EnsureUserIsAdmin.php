<?php

namespace App\Http\Middleware;

use App\Utils\Trait\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    use ApiResponse;
    public function handle(Request $request, Closure $next): Response
    {
        if (!Gate::allows('is-admin')) {
            $this->validationRequest('This action is not allowed.', 403);
        }

        return $next($request);
    }
}
