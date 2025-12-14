<?php

namespace App\Http\Controllers\Api;

use App\Filters\CommentFilter;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Department;
use Illuminate\Http\Request;

class CommentController extends BaseApiController
{
    private $relations = ['user', 'department'];
    public function index(Request $request, Department $department)
    {
        $filter = new CommentFilter($request);
        $query = $department->comments()->getQuery();
        $comments = $this->loadRelations($request, $query, $this->relations)->filter($filter)->paginate(20);
        return $this->successResponse('Comments retrieved successfully', CommentResource::collection($comments));
    }

    public function store(StoreCommentRequest $request, Department $department)
    {
        $data = $request->validated();
        $data['user_id'] = request()->user()->id;
        $comment = new Comment($data);
        $comment->department()->associate($department);
        $comment->load('user');
        $comment->save();
        return $this->successResponse('Comment created successfully', new CommentResource($comment), 201);
    }

    public function show(Request $request, Department $department, Comment $comment)
    {
        $this->loadRelations($request, $comment, $this->relations);
        return $this->successResponse('Comment retrieved successfully', new CommentResource($comment));
    }

    public function update(UpdateCommentRequest $request, Department $department, Comment $comment)
    {
        $this->authorize('update', $comment);
        $data = $request->validated();
        $comment->update($data);
        $comment->load('user');
        return $this->successResponse('Comment updated successfully', new CommentResource($comment));
    }

    public function destroy(Department $department, Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return $this->successResponse('Comment deleted successfully');
    }
}
