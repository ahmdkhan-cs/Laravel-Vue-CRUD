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
            $data = $this->authService->userRegister($data);
            $result['token'] = $data['token'];
            $result['data'] = $data['data'];
        }catch(Exception $e){
            $result = [
                'status' => 400,
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
            $data = $this->authService->userLogin($data);
            $result['token'] = $data['token'];
            $result['data'] = $data['data'];
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
