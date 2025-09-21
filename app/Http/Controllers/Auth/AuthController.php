<?php
namespace App\Http\Controllers\Auth;
use App\Enum\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
class AuthController extends Controller
{
    public function __construct(
        protected User $userModel
    )
    {
    }
    public function register(RegisterRequest $request)
    {
        $user = $this->userModel::registerUser($request->validated());
        return $this->successResponse(new UserResource($user),  StatusCode::CREATED->value);
    }
    public function login(LoginRequest $request)
    {
        $data = $this->userModel::attemptLogin($request->validated());
        return $this->successResponse([
            'user' => new UserResource($data['user']),
            'token' => $data['token'],
            'role' => $data['role']
        ],  StatusCode::SUCCESS->value);
    }
    public function logout()
    {
        return $this->successResponse($this->userModel->logout(),  StatusCode::SUCCESS->value);
    }
}
