<?php

namespace App\Actions\Auth;

use App\Actions\BaseAction;
use App\Http\Resources\UserResource;
use App\Models\Tenant;
use Faker\Provider\Base;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginAction extends  BaseAction
{
    protected function validate(array $data)
    {
        Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ])->validate();
    }
    protected function execute(array $data)
    {
        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return null;
        }
        $user = Auth::user();
            $role = $user->hasRole('admin') ? 'admin' : 'user';
            $token = $user->createToken($role . '_auth_token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token,
                'role' => $role,
            ];
        }
    protected function resource($result): JsonResource
    {
        return new JsonResource([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
            'role'=>$result['role'],
        ]);
    }
}
