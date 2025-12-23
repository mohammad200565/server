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
