<?php

namespace App\Http\Controllers\Api;

use App\Filters\DepartmentFilter;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends BaseApiController
{
    private $relations = ['images', 'reviews', 'user'];
    public function index(Request $request)
    {
        $filters = new DepartmentFilter($request);
        $query = Department::query();
        $departments = $this->loadRelations($request, $query, $this->relations)
            ->filter($filters)
            ->paginate(20);
        return $this->successResponse('Departments retrieved successfully', DepartmentResource::collection($departments));
    }
    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = request()->user()->id;
        $department = Department::create($data);
        // i still didnt do the logic of image uploading
        $department->load('images', 'user');
        return $this->successResponse('Department created successfully', new DepartmentResource($department), 201);
    }
    public function show(Request $request, Department $department)
    {
        $this->loadRelations($request, $department, $this->relations);
        return $this->successResponse('Department retrieved successfully', new DepartmentResource($department));
    }
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->authorize('update', $department);
        $data = $request->validated();
        $department->update($data);
        // i still didnt do the logic of image uploading
        $department->load('images', 'user');
        return $this->successResponse('Department updated successfully', new DepartmentResource($department));
    }
    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);
        $department->delete();
        return $this->successResponse('Department deleted successfully');
    }
}
