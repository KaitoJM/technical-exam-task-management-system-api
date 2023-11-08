<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Hash;

use App\Models\User;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;

use App\Services\UserService;

class AuthController extends Controller
{
    private UserService $user_service;

    public function __construct() {
        $this->user_service = new UserService;
    }

    public function login(LoginRequest $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Bad credentials' 
            ], 401);
        }

        $token = $this->user_service->generateToken($user);

        $response = [
            'user' => $user,
            'token' => $token
        ];

        Log::info('A user with an id #' . $user->id . ' was logged-in to the system.');
        return response()->json($response, 201);
    }

    public function register(RegistrationRequest $request) {
        $user = $this->user_service->add(
            $request->name,
            $request->email,
            $request->password
        );

        if ($user) {
            Log::info('A new user with email "' . $request->email . '" was registered successfully.');
            return response()->json('User registration completed.', 201);
        }

        Log::error('There was an error while registering a user with "' . $request->email . '" email.');
        return response()->json('Something wen\'t wrong with your request. Please try again.', 400);
    }
}
