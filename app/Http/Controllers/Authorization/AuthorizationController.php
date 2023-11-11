<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\LoginRequest;
use App\Http\Requests\Authorization\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthorizationController extends Controller
{
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $request = $request->validated();

        if (isset($request['avatar'])) $request['avatar'] = '/' . Storage::disk('public')->put('/images/avatars', $request['avatar']);
        else $request['avatar'] = '/images/avatars/avatar_default.png';

        $request['password'] = Hash::make($request['password']);
        unset($request['password_confirmation']);

        $user = User::firstOrCreate($request);
        auth()->login($user);

        return response()->json(['login' => $user->login], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            return response()->json(['login' => auth()->user()->login], 200);
        };

        return response()->json(['errors' => ['password' => ['Неверный логин или пароль']]], 422);
    }

    public function logout(): JsonResponse
    {
        $user = auth()->user();
        auth()->logout();
        return response()->json(['user' => $user], 200);
    }
}
