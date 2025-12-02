<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    /**
     * Retorno de json en API
     */
    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return true;
    }

    /**
     * 401 - No autenticado
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Sin autorización',
            'status' => 401,
        ], 401);
    }

    /**
     * 403 no autorizado
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthorizationException) {
            return response()->json([
                'message' => 'Acceso denegado',
                'status' => 403,
            ], 403);
        }

        return parent::render($request, $e);
    }
}
