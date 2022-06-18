<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Exception;


class AuthService
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function userRegister($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first(), 400);
        }

        $data['password'] = Hash::make($data['password']);
        $data['remember_token'] = Str::random(10);

        $user = $this->userRepository->create($data);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $data = [
            'data' => $user,
            'token' => $token
        ];

        return $data;

    }

    public function userLogin($data){
        $validator = Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            throw new InvalidArgumentException($validator->errors()->first(), 400);
        }

        $user = $this->userRepository->getUserByEmail($data['email']);

        if(!$user){
            throw new Exception("User not found", 422);
        }

        if (!Hash::check($data['password'], $user->password)){
            throw new Exception("Email or password is incorrect", 422);
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $data = [
            'data' => $user,
            'token' => $token
        ];

        return $data;
    }
}
