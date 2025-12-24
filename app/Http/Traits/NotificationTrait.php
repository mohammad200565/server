<?php

namespace App\Http\Traits;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\AndroidConfig;

trait NotificationTrait
{
    public function sendNotification($user, string $title, string $body): void
    {
        $messaging = Firebase::messaging();
        $tokens = $user->fcmTokens->pluck('token')->toArray();
        if (empty($tokens))
            return;
        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))->withAndroidConfig(AndroidConfig::fromArray([
                'priority' => 'high',
                'notification' => [
                    'sound' => 'default',
                ],
            ]));
        try {
            $report = $messaging->sendMulticast($message, $tokens);
        } catch (\Throwable $e) {
            Log::error("Notification failed for user {$user->id}: " . $e->getMessage());
        }
    }
}
