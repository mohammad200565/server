<?php

namespace App\Http\Controllers\Api;

use App\Filters\RentFilter;
use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Http\Resources\EditedRentResource;
use App\Http\Resources\RentResource;
use App\Models\Department;
use App\Models\EditedRent;
use App\Models\Rent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RentController extends BaseApiController
{
    private $relations = ['user', 'department', 'department.user', 'department.rents'];
    public function index(Request $request)
    {
        $filters = new RentFilter($request);
        $user = request()->user();
        $query = Rent::query()
            ->where('user_id', $user->id)
            ->orWhereHas('department', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        $rents = $this->loadRelations($request, $query, $this->relations)
            ->filter($filters)->paginate(15);
        return $this->successResponse("Rents fetched successfully", RentResource::collection($rents),);
    }
    public function store(StoreRentRequest $request)
    {
        $data = $request->validated();
        $user = request()->user();

        $start = Carbon::parse($data['startRent'])->startOfDay();
        $end   = Carbon::parse($data['endRent'])->endOfDay();

        $overlap = Rent::where('department_id', $data['department_id'])
            ->where('status', 'onRent')
            ->where(function ($query) use ($start, $end) {
                $query
                    ->where('startRent', '<=', $end)
                    ->where('endRent', '>=', $start);
            })
            ->exists();

        if ($overlap) {
            return $this->errorResponse("This house is rented during this period, please choose another time.", 422);
        }

        $department = Department::findOrFail($data['department_id']);

        $totalDays = $start->diffInDays($end);
        $totalRentFee = $department->rentFee * $totalDays;

        if (!$user->wallet_balance || $user->wallet_balance < $totalRentFee) {
            return $this->errorResponse(
                "Insufficient balance in your wallet to rent this Department.",
                422
            );
        }

        $data['startRent'] = $start;
        $data['endRent']   = $end;
        $data['user_id']   = $user->id;
        $data['rentFee']   = $totalRentFee;

        $rent = DB::transaction(function () use ($department, $data) {
            $rent = Rent::create($data);
            $department->increment('rentCounter');
            return $rent;
        });

        $rent->load('department', 'user');

        return $this->successResponse(
            "Rent created successfully",
            new RentResource($rent)
        );
    }



    public function show(Request $request, Rent $rent)
    {
        // $this->authorize('view', $rent);
        $this->loadRelations($request, $rent, $this->relations);
        return $this->successResponse("Rent fetched successfully", new RentResource($rent));
    }
    public function update(UpdateRentRequest $request, Rent $rent)
    {
        $this->authorize('update', $rent);
        if ($rent->status == 'pending') {
            $data = $request->validated();
            $department = $rent->department;
            $user = request()->user();
            $start = Carbon::parse($data['startRent']);
            $end = Carbon::parse($data['endRent']);
            $totalDays = $start->diffInDays($end) + 1;
            $totalFee = $department->rentFee * $totalDays;
            $oldFee = $rent->rentFee;

            if ($totalFee > $user->wallet_balance) {
                return $this->errorResponse(
                    "You don't have enough credit to make the edit.",
                    403
                );
            }

            $data['rentFee'] = $department->rentFee * $totalDays;
            $rent->update($data);
            $rent->load('department', 'user');
            return $this->successResponse(
                "Rent updated successfully",
                new RentResource($rent)
            );
        } else if ($rent->status == 'onRent') {
            $data = $request->validated();
            $department = $rent->department;
            $owner = $department->user;
            $user = request()->user();
            $start = Carbon::parse($data['startRent']);
            $end = Carbon::parse($data['endRent']);
            $today = Carbon::today();
            $totalDays = $start->diffInDays($end) + 1;
            $totalFee = $department->rentFee * $totalDays;
            $oldFee = $rent->rentFee;

            if ($today->gt($start) || $today->isSameDay($start)) {
                return $this->errorResponse(
                    "You can't edit the contract after it's begining",
                    403
                );
            }
            if ($totalFee > $user->wallet_balance + $oldFee) {
                return $this->errorResponse(
                    "You don't have enough credit to make the edit.",
                    403
                );
            }
            $data['user_id'] = $user->id;
            $data['department_id'] = $department->id;
            $data['rent_id'] = $rent->id;
            $data['status'] = 'onRent';
            $data['rentFee'] = $totalFee;

            $edited_rent = DB::transaction(function () use ($data, $rent) {
                EditedRent::where('rent_id', $rent->id)->delete();
                $edited_rent = EditedRent::create($data);
                return $edited_rent;
            });

            $this->sendNotification(
                $owner,
                'Rent update verification',
                "The tenant requested to update the rent terms, please read the new terms and approve or reject the tenant request."
            );

            return $this->successResponse(
                "A request is sent for the owner to approve the update.",
                new EditedRentResource($edited_rent)
            );
        } else {
            return $this->errorResponse(
                "Only rents with status 'pending' or haven't started yet can be updated.",
                422
            );
        }
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
        if ($rent->status !== 'onRent' && $rent->status !== 'pending') {
            return $this->errorResponse("Only rents with status 'onRent, pending' can be cancelled.", 422);
        }
        $rent->status = 'cancelled';
        $department = $rent->department;
        $department->isAvailable = true;
        $department->save();
        $rent->save();
        $rent->load('department', 'user');
        return $this->successResponse("Rent cancelled successfully", new RentResource($rent));
    }
    public function approveRent(Request $request, Rent $rent)
    {
        $this->authorize('approveRent', $rent);
        if ($rent->status !== 'pending') {
            return $this->errorResponse("Only rents with status 'pending' can be approved.", 422);
        }
        $department = $rent->department;
        $start = Carbon::parse($rent->startRent)->startOfDay();
        $end   = Carbon::parse($rent->endRent)->endOfDay();
        $overlap = Rent::where('department_id', $department->id)
            ->where('status', 'onRent')
            ->where(function ($query) use ($start, $end) {
                $query
                    ->where('startRent', '<=', $end)
                    ->where('endRent', '>=', $start);
            })
            ->exists();


        if ($overlap) {
            return $this->errorResponse("This house is rented during this period", 422);
        }
        $user = $rent->user;
        if ($user->wallet_balance < $rent->rentFee) {
            return $this->errorResponse(
                "User has insufficient balance in their wallet to approve this rent.",
                422
            );
        }

        DB::transaction(function () use ($rent, $department, $user) {
            $user->decrement('wallet_balance', $rent->rentFee);
            $rent->status = 'onRent';
            $department->isAvailable = false;

            $department->save();
            $rent->save();
        });

        $this->sendNotification(
            $user,
            'Rent request status.',
            "The owner approved your request to rent the appartment."
        );

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
        $user = $rent->user;
        $department->isAvailable = true;
        $department->save();
        $rent->save();
        $this->sendNotification(
            $user,
            'Rent request status.',
            "The owner rejected your request to rent the appartment."
        );
        $rent->load('department', 'user');
        return $this->successResponse("Rent rejected successfully", new RentResource($rent));
    }
}
