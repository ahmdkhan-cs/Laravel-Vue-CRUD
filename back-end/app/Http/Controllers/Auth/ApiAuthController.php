<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;

class ApiAuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function register (Request $request) {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $result = ['status' => 200];

        try{
            $result['token'] = $this->authService->userRegister($data);
        }catch(Exception $e){
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }

        return response($result,  $result['status']);
    }

    public function login (Request $request) {
        $data = $request->only([
            'email',
            'password'
        ]);
        $result['status'] = 200;

        try{
            $result['token'] = $this->authService->userLogin($data);
        }catch (Exception $e){
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage()
            ];
        }
        return response($result, $result['status']);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $result = ['status' => 200, 'message' => 'You have been successfully logged out!'];
        return response($result, $result['status']);
    }
}
