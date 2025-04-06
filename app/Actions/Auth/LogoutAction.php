<?php

namespace App\Actions\Auth;

use App\Actions\BaseAction;
use App\Enum\StatusCode;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LogoutAction extends  BaseAction
{
    protected function execute(array $data)
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
        }
        return ['message' => 'Logged out successfully'];
    }
    protected function resource($result): JsonResource
    {
        return new JsonResource($result);
    }
}
