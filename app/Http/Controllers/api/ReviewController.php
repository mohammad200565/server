<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Department;
use App\Models\Review;

class ReviewController extends BaseApiController
{
    public function index(Department $department)
    {
        $reviews = $department->reviews()->with('user')->paginate(20);
        return $this->successResponse('Reviews retrieved successfully', $reviews);
    }
    public function store(StoreReviewRequest $request, Department $department)
    {
        $data = $request->validated();
        $data['user_id'] = request()->user()->id;
        $review = new Review($data);
        $review->department()->associate($department);
        $review->save();
        return $this->successResponse('Review created successfully', $review, 201);
    }
    public function show(Department $department, Review $review)
    {
        return $this->successResponse('Review retrieved successfully', $review);
    }
    public function update(UpdateReviewRequest $request, Department $department, Review $review)
    {
        $this->authorize('update', $review);
        $data = $request->validated();
        $review->update($data);
        return $this->successResponse('Review updated successfully', $review);
    }
    public function destroy(Department $department, Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return $this->successResponse('Review deleted successfully');
    }
}
