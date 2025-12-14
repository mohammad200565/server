<?php

namespace App\Http\Controllers\Api;

use App\Filters\RentFilter;
use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Http\Resources\RentResource;
use App\Models\Rent;
use Illuminate\Http\Request;

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
        return $this->successResponse("Rents fetched successfully", [
            'rents' => RentResource::collection($rents),
        ]);
    }
    public function store(StoreRentRequest $request)
    {
        $data = $request->validated();
        $overlap = Rent::where('department_id', $data['department_id'])
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
        $rent->load('department', 'user');
        return $this->successResponse("Rent created successfully", [
            'rent' => new RentResource($rent),
        ]);
    }
    public function show(Request $request, Rent $rent)
    {
        $this->authorize('view', $rent);
        $this->loadRelations($request, $rent, $this->relations);
        return $this->successResponse("Rent fetched successfully", [
            'rent' => new RentResource($rent),
        ]);
    }
    public function update(UpdateRentRequest $request, Rent $rent)
    {
        $this->authorize('update', $rent);
        $rent->update($request->validated());
        $rent->load('department', 'user');
        return $this->successResponse("Rent updated successfully", [
            'rent' => new RentResource($rent),
        ]);
    }
    public function destroy(Rent $rent)
    {
        $this->authorize('delete', $rent);
        $rent->delete();
        return $this->successResponse("Rent deleted successfully");
    }
}
