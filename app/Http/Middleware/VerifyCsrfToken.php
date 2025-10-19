<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Les URIs qui doivent être exclues de la vérification CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
       'analyze-sentiment',
        '/analyze-sentiment',
        'test-sentiment-no-csrf',
        '/test-sentiment-no-csrf',
        'api/*'
    ];
}
