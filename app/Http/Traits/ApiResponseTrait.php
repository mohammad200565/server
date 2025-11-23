<?php

namespace App\Http\Traits;

trait ApiResponseTrait
{
    protected function successResponse($message, $data = null, $status = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'results' => $this->countResults($data),
            'data'    => $data,
        ], $status);
    }

    protected function errorResponse(string $message, int $status = 400, array $errors = null)
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];
        if ($errors) $response['errors'] = $errors;
        return response()->json($response, $status);
    }


    private function countResults($data)
    {
        if ($data instanceof \Illuminate\Http\Resources\Json\ResourceCollection) {
            return $data->resource->count();
        }

        if (is_countable($data)) {
            return count($data);
        }

        return $data ? 1 : 0;
    }
}
