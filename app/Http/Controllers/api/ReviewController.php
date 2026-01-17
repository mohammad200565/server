<?php

namespace App\Http\Controllers\Api;

use App\Filters\ReviewFilter;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Department;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Rent;


class ReviewController extends BaseApiController
{
    private $relations = ['user', 'department'];
    public function index(Request $request, Department $department)
    {
        $filter = new ReviewFilter($request);
        $query = $department->reviews()->getQuery();
        $reviews = $this->loadRelations($request, $query, $this->relations)->filter($filter)->paginate(20);
        return $this->successResponse('Reviews retrieved successfully', ReviewResource::collection($reviews));
    }

    public function store(StoreReviewRequest $request, Department $department)
    {
        $data = $request->validated();
        $userId = $request->user()->id;

//////////
        $hasCompletedRent = Rent::where('user_id', $userId)
        ->where('department_id', $department->id)
        ->where('status', 'completed')
        ->exists();

    if (!$hasCompletedRent) {
        return $this->errorResponse(
            'You can only review this apartment after completing a rent.',
            403
        );
    }
//////////

        $review = Review::where('user_id', $userId)
            ->where('department_id', $department->id)
            ->first();
        if ($review) {
            $review->update($data);
            $review->load('user');
            return $this->successResponse('Review updated successfully', new ReviewResource($review), 200);
        }
        $data['user_id'] = $userId;
        $review = new Review($data);
        $review->department()->associate($department);
        $review->load('user');
        $review->save();
        return $this->successResponse('Review created successfully', new ReviewResource($review), 201);
    }

    public function show(Request $request, Department $department, Review $review)
    {
        $this->loadRelations($request, $review, $this->relations);
        return $this->successResponse('Review retrieved successfully', new ReviewResource($review));
    }
    public function update(UpdateReviewRequest $request, Department $department, Review $review)
    {
        $this->authorize('update', $review);
        $data = $request->validated();
        $review->update($data);
        $review->load('user');
        return $this->successResponse('Review updated successfully', new ReviewResource($review));
    }
    public function destroy(Department $department, Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return $this->successResponse('Review deleted successfully');
    }
}
