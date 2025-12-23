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

// <?php

// namespace App\Http\Traits;

// use Kreait\Firebase\Messaging\Notification;
// use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Laravel\Firebase\Facades\Firebase;

// trait NotificationTrait
// {
//     public function sendNotification($token, $title, $body, $url = null)
//     {
//         $messaging = Firebase::messaging();
//         $notification = Notification::create($title, $body);
//         $message = CloudMessage::withTarget('token', $token)
//             ->withNotification($notification)
//             ->withData([
//                 'type' => 'chat',
//                 'id' => '123',
//             ]);
//         $androidConfig = [
//             'sound' => 'notification_sound.mp3', 
//         ];
//         $apnsConfig = [
//             'payload' => [
//                 'aps' => [
//                     'url' => $url,  
//                 ],
//             ],
//         ];
//         $message = $message
//             ->withAndroidConfig($androidConfig) 
//             ->withApnsConfig($apnsConfig);      

//         try {
//             $messaging->send($message);
//         } catch (\Throwable $e) {
//             logger('Notification failed: ' . $e->getMessage());
//         }
//     }
// }
