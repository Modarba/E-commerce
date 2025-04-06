<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;

class AuthController extends Controller
{
    protected $registerAction;
    protected $loginUserAction;
    protected  $logoutAction;
    public function __construct(RegisterAction $registerAction , LoginAction $loginUserAction ,LogoutAction $logoutAction)
    {
        $this->registerAction = $registerAction;
        $this->loginUserAction= $loginUserAction;
        $this->logoutAction = $logoutAction;
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
