<?php

namespace App\Http\Traits;

use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

trait NotificationTrait
{
    public function sendNotification($token, $title, $body)
    {
        $messaging = Firebase::messaging();

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create(
                $title,
                $body
            ))
            ->withData([
                'type' => 'chat',
                'id' => '123'
            ]);

        try {
            $messaging->send($message);
        } catch (\Throwable $e) {
            logger('Notification failed: ' . $e->getMessage());
        }
    }
}
