<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\FavoriteResource;
use App\Models\Department;
use Illuminate\Support\Facades\Request;

class FavoriteController extends BaseApiController
{
    public function toggle(Request $request, Department $department)
    {
        $user = request()->user();
        $deleted = $user->favorites()->where('department_id', $department['id'])->delete();
        if ($deleted) return $this->successResponse('Removed from favorites');
        $favorite = $user->favorites()->create(['department_id' => $department['department_id']]);
        return $this->successResponse('Added to favorites', new FavoriteResource($favorite), 201);
    }
}
