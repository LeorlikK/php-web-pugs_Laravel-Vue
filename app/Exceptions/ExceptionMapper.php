<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Throwable;

enum ExceptionMapper: string
{
    case ValidationException = ValidationException::class;
    case AuthException = AuthException::class;
    case Authentication = AuthenticationException::class;
    case MissingAbility = MissingAbilityException::class;
    case ModelNotFound = ModelNotFoundException::class;
    case QueryException = QueryException::class;
    case UploadException = UploadException::class;

    public function getHttpCode(): int
    {
        return match ($this) {
            self::ValidationException,
            self::AuthException => 422,
            self::Authentication => 401,
            self::MissingAbility => 403,
            self::ModelNotFound => 404,
            self::QueryException => 400,
            self::UploadException => 500
        };
    }

    public function getResponseBody(Throwable $e): array
    {
        return match ($this) {
            self::ValidationException => ['message' => $e->getMessage(), 'errors' => $e->errors()],
            self::AuthException => ['message' => 'The password is incorrect'],
            self::Authentication => ['message' => 'Unauthorized'],
            self::MissingAbility => ['message' => 'Forbidden'],
            self::ModelNotFound => ['message' => 'Not found'],
            self::QueryException => ['message' => 'Query Exception'],
            self::UploadException => ['message' => 'Upload File Exception'],
        };
    }
}
