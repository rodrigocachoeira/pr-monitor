<?php

namespace App\Builders\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseBuilder
{
    private array $response;
    
    private int $status = Response::HTTP_OK;
    
    static function init(): static
    {
        return new static;
    }
    
    public function data(array $data): ResponseBuilder
    {
        $this->response = $data;
        
        return $this;
    }

    public function status(int $status): ResponseBuilder
    {
        $this->status = $status;

        return $this;
    }
    
    public function build(): JsonResponse
    {
        return response()->json($this->response, $this->status);
    }
}