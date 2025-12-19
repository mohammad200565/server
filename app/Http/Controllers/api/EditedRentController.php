<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\EditedRentResource;
use App\Http\Resources\RentResource;
use App\Models\EditedRent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EditedRentController extends BaseApiController
{
    private $relations = ['original_rent', 'user', 'department', 'department.user'];
    
    public function show(Request $request, EditedRent $rent)
    {
        $this->authorize('view', $rent);
        $this->loadRelations($request, $rent, $this->relations);
        return $this->successResponse("Rent fetched successfully", new EditedRentResource($rent));
    }

    public function approve(Request $request, EditedRent $editedRent) {
        DB::beginTransaction();

        $rent = $editedRent->rent;

        $attributesToUpdate = $editedRent->getAttributes();

        $attributesToUpdate = Arr::except($attributesToUpdate, [
            'id',         
            'rent_id',    
            'created_at', 
        ]);

        $rent->update($attributesToUpdate);

        $editedRent->delete();

        DB::commit();

        return $this->successResponse(
            "Approved successfully.",
            new RentResource($rent)
        );
    }
    public function reject(EditedRent $editedRent)
    {
        if (request()->user()->id !== $editedRent->rent->user_id) {
            abort(403, 'UNAUTHORIZED ACTION');
        }

        $editedRent->delete();

        return $this->successResponse(
            "Rejected successfully",
        );
    }
}
