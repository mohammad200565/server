<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FavoriteController extends BaseApiController
{

    public function userFavorites()
    {
        $user = Request()->user();
        $favorites = $user->favorites()
            ->with('images', 'user')
            ->paginate(20);
        return $this->successResponse('Favorite list loaded', DepartmentResource::collection($favorites));
    }

    public function toggle(Request $request, Department $department)
    {
        $user = request()->user();
        $deleted = $user->favorites()->detach($department['id']);
        if ($deleted) {
            $department['favoritesCount'] -= 1;
            $department->save();
            return $this->successResponse('Removed from favorites');
        }
        $user->favorites()->attach($department['id']);
        $department['favoritesCount'] += 1;
        $department->save();
        return $this->successResponse('Added to favorites', [], 201);
    }

    public function isFavorite(Department $department)
    {
        $user = request()->user();
        $isFavorite = $user->favorites()->where('department_id', $department['id'])->exists();
        return $this->successResponse('Favorite status retrieved', ['is_favorite' => $isFavorite]);
    }
    public function sendNot()
    {
        $this->sendNotification('dUB2KW-CT82B3MgdNW_SUd:APA91bGAbyhqyxNvRvuBGGrA7QEy2eEFeTZL6Yalfn62VR91EGktLXqY2gdkWdCMkwJ_jxbBiAflG7MtPeyGvYd-EWwD57KL8Yj0yyGzcOBxcszTZ7rvurM');
    }

    public function sendNotification($token)
    {
        $messaging = Firebase::messaging();

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create(
                'Homsi Notification',
                'Zain Noob'
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

        return response()->json(['status' => 'sent']);
    }
}
