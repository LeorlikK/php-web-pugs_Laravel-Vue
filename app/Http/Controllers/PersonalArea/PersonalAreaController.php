<?php

namespace App\Http\Controllers\PersonalArea;

use App\Events\FeedbackSendEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authorization\UpdateMeRequest;
use App\Http\Requests\FeedbackRequest;
use Illuminate\Http\JsonResponse;
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
            if ($user->avatar !== config('media.default.avatar')) {
                Storage::disk('public')->delete($user->avatar);
            }
            $request['avatar'] = Storage::disk('public')->put(config('media.images.avatars'), $request['avatar']);
        }

        $user->update($request);
        $user->refresh();

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function feedback(FeedbackRequest $request): JsonResponse
    {
        $request->validated();
        $feedback = $request->input('feedback') ?? '';
        $from = auth()->user()->email;

        event(new FeedbackSendEvent($from, $feedback));

        return response()->json(['success' => true]);
    }
}
