<?php

namespace App\Exceptions;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Psr\Log\LoggerInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @inheritdoc
     */
    public function render($request, Throwable $e): JsonResponse
    {
        $responseMapper = ExceptionMapper::tryFrom($e::class);
        $config = App::make(Repository::class);

        return new JsonResponse(
            [
                'success' => false,
                'data' => $responseMapper?->getResponseBody($e) ?? [
                        'message' => $config->get('app.debug') ? $e->getMessage() : 'Internal server error'
                    ],
                'status_code' => $e->getCode(),
            ],
            $responseMapper?->getHttpCode() ?? 500
        );
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e): void {
            if (!env('APP_DEBUG')) {
                $this->sendError($e);
            }
        });
    }

    public function sendError(Throwable $e): void
    {
        Http::post(
            env('ERROR_HOST'),
            [
                'side' => 'backend',
                'host' => 'admin.eon.estate',
                'error_message' => $e->getMessage()
            ]
        );

        $logger = $this->container->make(LoggerInterface::class);
        $logger->error(
            $e->getMessage() . PHP_EOL . $e->getTraceAsString(),
            [__METHOD__]
        );
    }
}
