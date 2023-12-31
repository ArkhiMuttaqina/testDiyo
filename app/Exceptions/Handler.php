<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                if ($e->getPrevious() instanceof ModelNotFoundException) {
                    /** @var ModelNotFoundException $modelNotFound */
                    $modelNotFound = $e->getPrevious();
                    if ($modelNotFound->getModel() === Product::class) {
                        return response()->json([
                            'message' => 'Modules not found.'
                        ], 404);
                    }
                }

                return response()->json([
                    'error' => 404, 'message' => 'Not Found'
                ], 404);
            }else if ($request->is('/*')) {
                if ($e->getPrevious() instanceof ModelNotFoundException) {
                    /** @var ModelNotFoundException $modelNotFound */
                    $modelNotFound = $e->getPrevious();
                    if ($modelNotFound->getModel() === Product::class) {
                        return response()->json([
                            'message' => 'Modules not found.'
                        ], 404);
                    }
                }

                return response()->json([
                    'error' => 404, 'message' => 'Not Found'
                ], 404);
            }
        });
    }

}
