<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];
    protected $dontReport = [];
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (ModelNotFoundException $e, $request) {
            return response()->json([
                'sõnum' => 'Ressurssi ei leitud'
            ], 404);
        });

        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'sõnum' => 'Valideerimisviga',
                'vead' => $e->errors(),
            ], 422);
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'sõnum' => 'Pole autentitud'
            ], 401);
        });
    }
}
