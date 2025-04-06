<?php

namespace App\Actions;

 use App\Enum\StatusCode;
 use App\Trait\ApiResponse;
 use Couchbase\AuthenticationException;
 use Exception;
 use Illuminate\Http\JsonResponse;
 use Illuminate\Http\Resources\Json\JsonResource;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Log;

 abstract class BaseAction
{
    use ApiResponse;
     abstract protected function execute(array $data);
     protected function resource($result): JsonResource
     {
         return new JsonResource($result);
     }
     public function handle(array $data): JsonResponse
     {
         try {
             $this->validate($data);
             $result = $this->execute($data);
             return $this->successResponse([$this->resource($result)],StatusCode::SUCCESS->value);
         }
         catch (Exception $e)
         {
             Log::error($e->getMessage());
             return $this->errorResponse([$e->getMessage()],StatusCode::INTERNAL_SERVER_ERROR->value);
         }
     }
     protected function validate(array $data)
     {
     }
}
