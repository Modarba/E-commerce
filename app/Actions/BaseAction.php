<?php
namespace App\Actions;
 use App\Enum\StatusCode;
 use App\Trait\ApiResponse;
 use Couchbase\AuthenticationException;
 use Exception;
 use Illuminate\Database\Eloquent\ModelNotFoundException;
 use Illuminate\Http\JsonResponse;
 use Illuminate\Validation\ValidationException;
 abstract class BaseAction
{
     use ApiResponse;
     abstract protected function execute(array $data);
     abstract protected function resource($result);
     public function handle(array $data): JsonResponse
     {
         try {
             $this->validate($data);
             $result = $this->execute($data);
             return $this->successResponse(
                 $this->resource($result),
                 StatusCode::SUCCESS->value
             );
         }
         catch (ValidationException $e) {
             return $this->errorResponse(
                 $e->errors(),
                 StatusCode::BAD_REQUEST->value
             );
         }
         catch (ModelNotFoundException $e) {
             return $this->errorResponse(
                 'Element Not Found',
                 StatusCode::NOTFOUND->value
             );
         }
         catch (AuthenticationException $e) {
             return $this->errorResponse(
                 'Unauthorized User',
                 StatusCode::UNAUTHORIZED->value
             );
         }
         catch (\App\Exceptions\BaseBusinessException $e) {
             return $this->errorResponse(
                 $e->getMessage(),
                 $e->getStatusCode()
             );
         }
         catch (Exception $e) {
             return $this->errorResponse(
                 'An unexpected error occurred',
                 StatusCode::INTERNAL_SERVER_ERROR->value
             );
         }
     }
     protected function validate(array $data)
     {
     }
}
