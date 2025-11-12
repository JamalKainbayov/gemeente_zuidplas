<?php

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsAdmin;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        'auth' => Authenticate::class,
        'verified' => EnsureEmailIsVerified::class,
        'is_admin' => IsAdmin::class,
    ];

}
