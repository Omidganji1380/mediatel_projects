<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'bot',
        'bot*',
        '5900652188:AAHpEWGV8p97Wg5a3woJ9opg_cBc1rjR6oo',
        '6497087801:AAHiq-cQPrbQASjmGLAqud_G3pLqFKDc8cE',
        '5900652188:AAEgHQwCl9eaV9byWQSzwepOnL7zTqUKD_I',
    ];
}
