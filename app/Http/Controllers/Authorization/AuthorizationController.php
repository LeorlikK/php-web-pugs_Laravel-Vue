<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\LoginRequest;
use App\Http\Requests\Authorization\RegistrationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthorizationController extends Controller
{
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $request = $request->validated();

        if (isset($request['avatar'])) $request['avatar'] = Storage::disk('public')->put(config('media.images.avatars'), $request['avatar']);
        else $request['avatar'] = config('media.default.avatar');

        $request['password'] = Hash::make($request['password']);
        unset($request['password_confirmation']);

        $request['role'] = 'user';
        $request['banned'] = false;

        $user = User::firstOrCreate($request);

//        auth()->login($user);
        event(new Registered($user));

        return response()->json(['success' => true, 'user' => $user], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            return response()->json(['success' => true, 'user' => auth()->user()], 200);
        };

        return response()->json(['success' => false, 'errors' => ['password' => ['Неверный логин или пароль']]], 422);
    }

    public function logout(): JsonResponse
    {
        $user = auth()->user();
        auth()->logout();
        return response()->json(['success' => true, 'user' => $user]);
    }
}
