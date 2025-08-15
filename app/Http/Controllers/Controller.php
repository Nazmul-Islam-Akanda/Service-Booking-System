<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Service Booking API",
 *      description="API Documentation for Service Booking System"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function responseWithSuccess($data, $message, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'code' => $status,
        ], $status);
    }

    public function responseWithError($data = null, $message, $status = 500): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message,
            'code' => $status,
        ], $status);
    }
}
