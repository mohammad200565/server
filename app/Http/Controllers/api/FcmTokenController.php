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
        logger('Storing FCM token for user ID: ' . $request->user()->id . ' Token: ' . $request->fcm_token);
        FcmToken::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'token'   => $request->fcm_token,
            ]
        );

        return response()->json([
            'message' => 'FCM token saved successfully'
        ]);
    }
}
