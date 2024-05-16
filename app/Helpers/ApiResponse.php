<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse {
    // Success Responses
    public static function success($data = null, string $message = 'Success', int $statusCode = Response::HTTP_OK, array $headers = []): JsonResponse {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode, $headers);
    }

    public static function created($data = null, string $message = 'Resource created successfully'): JsonResponse {
        return self::success($data, $message, Response::HTTP_CREATED);
    }

    public static function noContent(string $message = 'No content'): JsonResponse {
        return self::success(null, $message, Response::HTTP_NO_CONTENT);
    }

    // Error Responses
    public static function error(string $message = 'Error', $errors = [], int $statusCode = Response::HTTP_BAD_REQUEST, array $headers = []): JsonResponse {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $statusCode, $headers);
    }

    public static function notFound(string $message = 'Resource not found'): JsonResponse {
        return self::error($message, [], Response::HTTP_NOT_FOUND);
    }

    public static function unauthorized(string $message = 'Unauthorized'): JsonResponse {
        return self::error($message, [], Response::HTTP_UNAUTHORIZED);
    }

    public static function forbidden(string $message = 'Forbidden'): JsonResponse {
        return self::error($message, [], Response::HTTP_FORBIDDEN);
    }

    public static function validationError(string $message = 'Validation errors', array $errors = []): JsonResponse {
        return self::error($message, $errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function serverError(string $message = 'Internal Server Error'): JsonResponse {
        return self::error($message, [], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
