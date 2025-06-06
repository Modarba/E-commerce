<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;

class AuthController extends Controller
{
    public function __construct(
        protected RegisterAction $registerAction,
        protected LoginAction $loginUserAction,
        protected LogoutAction $logoutAction
    ) {
    }
    public function register(\Illuminate\Http\Request $request)
    {
        return $this->registerAction->handle($request->all());
    }
    public function login(\Illuminate\Http\Request $request)
    {
        return $this->loginUserAction->handle($request->all());
    }
    public  function logout()
    {
        return $this->logoutAction->handle([]);
    }

}
