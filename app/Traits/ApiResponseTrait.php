<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successApiResponse($data, $message = "successfully", $code = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $code);
    }
    protected function errorApiResponse($message, $code = 500)
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}
