<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    protected function bootstrappers()
    {
        $bootstrappers = parent::bootstrappers();

        // Swap out the default Laravel ConfigureLogging class with our own.
        foreach ($bootstrappers as $key => $value) {
            if ($value == 'Illuminate\Foundation\Bootstrap\ConfigureLogging') {
                $bootstrappers[$key] = 'Delatbabel\Applog\Bootstrap\ConfigureLogging';
            }
        }

        return $bootstrappers;
    }

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
    ];
}
