<?php

namespace App\Http\Controllers\Api;

use App\Filters\RentFilter;
use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Http\Resources\RentResource;
use App\Models\Rent;
use Illuminate\Http\Request;

use function Symfony\Component\Translation\t;

class RentController extends BaseApiController
{
    private $relations = ['user', 'department', 'department.user'];
    public function index(Request $request)
    {
        $filters = new RentFilter($request);
        $user = request()->user();
        $query = $user->rents()->getQuery();
        $rents = $this->loadRelations($request, $query, $this->relations)
            ->filter($filters)->paginate(15);
        return $this->successResponse("Rents fetched successfully", RentResource::collection($rents),);
    }
    public function store(StoreRentRequest $request)
    {
        $data = $request->validated();
        $overlap = Rent::where('department_id', $data['department_id'])->where('status', 'onRent')
            ->where(function ($query) use ($data) {
                $query->where('startRent', '<=', $data['endRent'])
                    ->where('endRent', '>=', $data['startRent']);
            })
            ->exists();
        if ($overlap) {
            return $this->errorResponse("This house is rented during this period, please choose another time.", 422);
        }
        $data['user_id'] = request()->user()->id;
        $rent = Rent::create($data);
        $department = $rent->department;
        $department->increment('rentCounter');
        $rent->load('department', 'user');
        return $this->successResponse("Rent created successfully", new RentResource($rent),);
    }
    public function show(Request $request, Rent $rent)
    {
        $this->authorize('view', $rent);
        $this->loadRelations($request, $rent, $this->relations);
        return $this->successResponse("Rent fetched successfully", new RentResource($rent));
    }
    public function update(UpdateRentRequest $request, Rent $rent)
    {
        $this->authorize('update', $rent);
        $rent->update($request->validated());
        $rent->load('department', 'user');
        return $this->successResponse("Rent updated successfully", new RentResource($rent));
    }
    public function destroy(Rent $rent)
    {
        $this->authorize('delete', $rent);
        $rent->delete();
        return $this->successResponse("Rent deleted successfully");
    }
    public function cancelRent(Request $request, Rent $rent)
    {
        $this->authorize('cancelRent', $rent);
        if ($rent->status !== 'onRent') {
            return $this->errorResponse("Only rents with status 'onRent' can be cancelled.", 422);
        }
        $rent->status = 'cancelled';
        $department = $rent->department;
        $department->isAvailable = true;
        $department->save();
        $rent->save();
        $rent->load('department', 'user');
        return $this->successResponse("Rent cancelled successfully", new RentResource($rent));
    }
    public function completeRent(Request $request, Rent $rent)
    {
        $this->authorize('completeRent', $rent);
        if ($rent->status !== 'onRent') {
            return $this->errorResponse("Only rents with status 'onRent' can be completed.", 422);
        }
        $rent->status = 'completed';
        $department = $rent->department;
        $department->isAvailable = true;
        $department->save();
        $rent->save();
        $rent->load('department', 'user');
        return $this->successResponse("Rent completed successfully", new RentResource($rent));
    }
    public function approveRent(Request $request, Rent $rent)
    {
        $this->authorize('approveRent', $rent);
        if ($rent->status !== 'pending') {
            return $this->errorResponse("Only rents with status 'pending' can be approved.", 422);
        }
        $department = $rent->department;
        $overlap = Rent::where('department_id', $department->id)->where('status', 'onRent')
            ->where(function ($query) use ($rent) {
                $query->where('startRent', '<=', $rent->endRent)
                    ->where('endRent', '>=', $rent->startRent);
            })
            ->exists();
        if ($overlap) {
            return $this->errorResponse("This house is rented during this period", 422);
        }
        $rent->status = 'onRent';
        $department->isAvailable = false;
        $department->save();
        $rent->save();
        $rent->load('department', 'user');
        return $this->successResponse("Rent approved successfully", new RentResource($rent));
    }
    public function rejectRent(Request $request, Rent $rent)
    {
        $this->authorize('rejectRent', $rent);
        if ($rent->status !== 'pending') {
            return $this->errorResponse("Only rents with status 'pending' can be rejected.", 422);
        }
        $rent->status = 'cancelled';
        $department = $rent->department;
        $department->isAvailable = true;
        $department->save();
        $rent->save();
        $rent->load('department', 'user');
        return $this->successResponse("Rent rejected successfully", new RentResource($rent));
    }
}
