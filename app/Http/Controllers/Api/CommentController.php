<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Interfaces\Services\CommentServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests, ApiResponse;

    public function __construct(private CommentServiceInterface $commentService) {}

    public function index(): JsonResponse
    {
        $comments = $this->commentService->getAll();

        return $this->successResponse(
            CommentResource::collection($comments),
            'Comments retrieved successfully.'
        );
    }

    public function store(CommentStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $comment = $this->commentService->create($data);

        return $this->successResponse(
            new CommentResource($comment),
            'Comment created successfully.',
            201
        );
    }

    public function update(CommentUpdateRequest $request, int $id): JsonResponse
    {
        $comment = $this->commentService->getById($id);

        if (!$comment) {
            return $this->errorResponse('Comment not found.', 404);
        }

        $this->authorize('update', $comment);

        $updated = $this->commentService->update($id, $request->validated());

        return $this->successResponse(
            new CommentResource($updated),
            'Comment updated successfully.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $comment = $this->commentService->getById($id);

        if (!$comment) {
            return $this->errorResponse('Comment not found.', 404);
        }

        $this->authorize('delete', $comment);

        $this->commentService->delete($id);

        return $this->successResponse(null, 'Comment deleted successfully.');
    }
}
