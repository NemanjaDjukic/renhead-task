<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class UserController extends Controller
{

    public function register(UserRegisterRequest $userRequest)
    {
        try {
            $user = new User($userRequest->validated());
            $user->save();
            return response()->json([
                'message' => 'Successful registration.'
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(UserLoginRequest $userLoginRequest)
    {
        try {
            $validated = $userLoginRequest->validated();
            $user = User::findOrFail($validated['id']);

            if (Hash::check($validated['password'], $user->password)) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message' => 'Successful logged in.',
                    'access_token' => $token,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    "message" => "Incorrect password."
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'message' => 'Successful logged out.',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
