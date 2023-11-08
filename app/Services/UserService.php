<?php

namespace App\Services;

use App\Models\User;

use Hash;

class UserService
{
    public function loginCheck($email, $password): ?User {
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function add($name, $email, $password): ?User {
        $fields = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ];

        $new_user = User::create($fields);

        if ($new_user && $new_user->id) {
            return $new_user;
        }

        return null;
    }

    public function generateToken(User $user) {
        $token = $user->createToken('myapptoken')->plainTextToken;
        return $token;
    }
}