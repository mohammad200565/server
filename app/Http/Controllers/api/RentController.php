<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Http\Resources\RentResource;
use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends BaseApiController
{
    private $relations = ['user', 'department'];
    public function index(Request $request)
    {
        $user = request()->user();
        $query = $user->rents();
        $rents = $this->loadRelations($request, $query, $this->relations)
            ->latest()->paginate(15);
        return $this->successResponse("Rents fetched successfully", [
            'rents' => RentResource::collection($rents),
        ]);
    }
    public function store(StoreRentRequest $request)
    {
        $data = $request->validated();
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
