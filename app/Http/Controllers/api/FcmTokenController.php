<?php

namespace App\Http\Controllers\Api;

use App\Models\FcmToken;
use Illuminate\Http\Request;

class FcmTokenController extends BaseApiController
{
    public function store(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);
        $user = $request->user();
        FcmToken::updateOrCreate(
            ['user_id' => $user->id, 'token' => $request->fcm_token],
            ['token' => $request->fcm_token]
        );
        return $this->successResponse('Fcm token updated successfully');
    }
}
