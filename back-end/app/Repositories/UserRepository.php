<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($data)
    {
        $user = new $this->user;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->remember_token = $data['remember_token'];

        $user->save();

        return $user;
    }

    public function getUserByEmail($email){
        return $this->user->where('email', $email)->first();
    }

}
