<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = 15;
        $page = (int) $request->input('page') ?? 1;
        $sorted = $request->input('sorted') ?? 'id';
        $sortedType = $request->input('sorted_type') ?? 'asc';
        $search = $request->input('search');

        $users = User::when($search, function ($query) use($search) {
            $query->where('email', 'like', "%{$search}%");
        })
            ->orderBy($sorted, $sortedType)
            ->paginate($perPage, '*', 'page', $page);

        return UserResource::collection($users);
    }

    public function edit(User $user): UserResource
    {
        return UserResource::make($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $request = $request->validated();
        unset($request['id']);
        $request['banned'] = $request['banned'] === 'true';

        if (isset($request['avatar'])) {
            if ($user->avatar !== config('media.default.avatar')) {
                Storage::disk('public')->delete($user->avatar);
            }
            $request['avatar'] = Storage::disk('public')->put(config('media.images.avatars'), $request['avatar']);
        }
        $user->update($request);
        $user->refresh();

        return UserResource::make($user);
    }

    public function banned(User $user): UserResource
    {
        $user->banned = !$user->banned;
        $user->save();
        $user->refresh();

        return UserResource::make($user);
    }
}
