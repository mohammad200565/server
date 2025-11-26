<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FavoriteResource;
use App\Models\Department;
use Illuminate\Support\Facades\Request;

class FavoriteController extends BaseApiController
{

    public function userFavorites()
    {
        $user = Request()->user();
        $favorites = $user->favorites()->with('department')->paginate(20);
        return $this->successResponse('Favorite list loaded', $favorites);
    }
    public function toggle(Request $request, Department $department)
    {
        $user = request()->user();
        $deleted = $user->favorites()->detach($department['id']);
        if ($deleted) {
            $department['favoritesCount'] -= 1 ;
            $department->save();
            return $this->successResponse('Removed from favorites');
        }
        $favorite = $user->favorites()->attach($department['id']);
        $department['favoritesCount'] += 1;
        $department->save();
        return $this->successResponse('Added to favorites',[], 201);
    }
}
