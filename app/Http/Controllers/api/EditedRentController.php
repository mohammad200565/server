<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\EditedRentResource;
use App\Http\Resources\RentResource;
use App\Models\EditedRent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EditedRentController extends BaseApiController
{
    private $relations = ['original_rent', 'user', 'department', 'department.user'];
    
    public function show(Request $request, EditedRent $edited_rent)
    {
        $user = request()->user;
        if ( $user->verification_state == "verified" && $user->id === $edited_rent->user_id ) {
            return $this->errorResponse(
                'You are not authorized to view this page.',
                403
            );
        }
        $this->loadRelations($request, $edited_rent, $this->relations);
        return $this->successResponse("Edited rent fetched successfully", new EditedRentResource($edited_rent));
    }

    public function approve(EditedRent $edited_rent) {
        $rent = $edited_rent->rent;

        $attributesToUpdate = $edited_rent->getAttributes();

        $attributesToUpdate = Arr::except($attributesToUpdate, [
            'id',         
            'rent_id',    
            'created_at', 
            'updated_at',
        ]);

        $department = $rent->department;
        $tenant = $rent->user;
        $owner = $rent->$department->user;
        $newFee = $edited_rent->rentFee;
        $oldFee = $rent->rentFee;

        if ( $newFee < $oldFee && $owner->wallet_balance < $oldFee-$newFee ) {
            return $this->errorResponse(
                "You don't have enough credit to make the approve",
                403
            );
        }

        DB::transaction(function() use ($tenant, $owner, $oldFee, $newFee, $rent, $attributesToUpdate, $edited_rent) {
            $tenant->wallet_balance += $oldFee;
            $tenant->wallet_balance -= $newFee;
            $tenant->save();

            $owner->wallet_balance += $newFee;
            $owner->wallet_balance -= $oldFee;
            $owner->save();

            $rent->update($attributesToUpdate);

            $edited_rent->delete();
        });

        return $this->successResponse(
            "Approved successfully.",
            new RentResource($rent)
        );
    }
    public function reject(EditedRent $edited_rent)
    {
        if (request()->user()->id !== $edited_rent->rent->user_id) {
            return $this->errorResponse(
                'You are not authorized to view this page.',
                403
            );
        }

        $edited_rent->delete();

        return $this->successResponse(
            "Rejected successfully",
            200
        );
    }
}
