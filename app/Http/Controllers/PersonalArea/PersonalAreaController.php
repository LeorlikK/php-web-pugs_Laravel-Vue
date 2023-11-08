<?php

namespace App\Http\Controllers\PersonalArea;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\UpdateMeRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonalAreaController extends Controller
{
    public function me(): JsonResponse
    {
        $user = auth()->user();
        return response()->json(['user' => $user]);
    }

    public function update(UpdateMeRequest $request): JsonResponse
    {
        $request = $request->validated();

        $user = auth()->user();

        if (isset($request['avatar'])) {
            Storage::disk('public')->delete('/' . $user->avatar);
            $request['avatar'] = '/' . Storage::disk('public')->put('/images/avatars', $request['avatar']);
        }

        $user->update($request);
        $user->refresh();

        return response()->json([
            'user' => $user
        ], 200);
    }
}
