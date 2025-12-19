<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Support\Facades\Request;

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
}
