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

    public function index(Request $request)
    {
        $this->authorize('viewAny', EditedRent::class);
        $user = $request->user();
        $query = EditedRent::query()
            ->whereHas('department', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        $editedRents = $this->loadRelations($request, $query, $this->relations)
            ->paginate(15);
        return $this->successResponse(
            "Edited rents fetched successfully",
            EditedRentResource::collection($editedRents)
        );
    }


    public function show(Request $request, $id)
    {
        $editedRent = EditedRent::find($id);
        if (!$editedRent) {
            return $this->errorResponse('Edited rent not found', 404);
        }
        $this->authorize('view', $editedRent);

        return $this->successResponse(
            'Edited rent fetched successfully',
            new EditedRentResource($editedRent)
        );
    }


    public function approve(EditedRent $edited_rent)
    {
        $this->authorize('approveRent', $edited_rent);
        $rent = $edited_rent->original_rent;
        $attributesToUpdate = $edited_rent->getAttributes();
        $attributesToUpdate = Arr::except($attributesToUpdate, [
            'id',
            'rent_id',
            'created_at',
            'updated_at',
        ]);
        $department = $rent->department;
        $tenant = $rent->user;
        $owner = $department->user;
        $newFee = $edited_rent->rentFee;
        $oldFee = $rent->rentFee;
        if ($newFee < $oldFee && $owner->wallet_balance < $oldFee - $newFee) {
            return $this->errorResponse(
                "You don't have enough credit to make the approve",
                403
            );
        }
        DB::transaction(function () use ($tenant, $owner, $oldFee, $newFee, $rent, $attributesToUpdate, $edited_rent) {
            $tenant->decrement('wallet_balance', $newFee);
            $tenant->increment('wallet_balance', $oldFee);
            $owner->increment('wallet_balance', $newFee);
            $owner->decrement('wallet_balance', $oldFee);
            $rent->update($attributesToUpdate);
            $edited_rent->delete();
        });
        $this->sendNotification(
            $tenant,
            'Rent update verification',
            "The owner approved your request, rent updated successfully."
        );
        return $this->successResponse(
            "Approved successfully.",
            new RentResource($rent)
        );
    }
    public function reject(EditedRent $edited_rent)
    {
        $this->authorize('rejectRent', $edited_rent);
        $tenant = $edited_rent->user;
        $edited_rent->delete();
        $this->sendNotification(
            $tenant,
            'Rent update verification',
            "The owner rejected your request to update the rent."
        );
        return $this->successResponse(
            "Rejected successfully",
            200
        );
    }
}
