<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

class DepartmentController extends BaseApiController
{
    public function index()
    {
        $departments = Department::paginate(20);
        return $this->successResponse('Departments retrieved successfully', DepartmentResource::collection($departments));
    }
    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->validated();
        $department = Department::create($data);
        return $this->successResponse('Department created successfully', new DepartmentResource($department), 201);
    }
    public function show(Department $department)
    {
        return $this->successResponse('Department retrieved successfully', new DepartmentResource($department));
    }
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $data = $request->validated();
        $department->update($data);
        return $this->successResponse('Department updated successfully', new DepartmentResource($department));
    }
    public function destroy(Department $department)
    {
        $department->delete();
        return $this->successResponse('Department deleted successfully');
    }
}
