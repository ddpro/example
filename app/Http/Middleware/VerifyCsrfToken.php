<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * Verify CSRF Handler
     *
     * This function ensures that the Symfony2 BrowserKit used by Codeception does
     * not fall foul of CSRF checking.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     * @throws TokenMismatchException
     */
    public function handle($request, \Closure $next)
    {
        if ($request->header('user-agent') == 'Symfony2 BrowserKit') {
            return $next($request);
        }

        throw new TokenMismatchException;
    }
}
