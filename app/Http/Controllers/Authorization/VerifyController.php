<?php

namespace App\Http\Controllers\Authorization;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerifyController
{
    public function verify(Request $request): RedirectResponse
    {
        $redirectRoute = '/';

        $user = User::where('id', $request->input('id'))->firstOrFail();
        if (!$user) {
            return redirect()->to($redirectRoute);
        }

        $isValidSignature = URL::hasValidSignature($request);
        if (!$isValidSignature) {
            return redirect()->to($redirectRoute);
        }

        $timeOut = now()->toDateTimeString() < Carbon::createFromTimestamp($request->input('expires'))->toDateTimeString();
        if (!$timeOut) {
            return redirect()->to($redirectRoute);
        }

        $hash = hash_equals($request['hash'], sha1($user->getEmailForVerification()));
        if (!$hash) {
            return redirect()->to($redirectRoute);
        }

        $user->markEmailAsVerified();
        return redirect()->to($redirectRoute);
    }
}
