<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * Define los tipos de excepciones que no deben reportarse.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];



    /**
     * Define los inputs que nunca deben ser devueltos en errores de validación.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra las funciones de manejo de excepciones para la aplicación.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    //METODO PARA REDIRIGIR AL 419
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return response()->view('error.419', [], 419);
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
    }



}
