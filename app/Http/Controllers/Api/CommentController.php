<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Interfaces\Services\CommentServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private CommentServiceInterface $commentService) {}

    public function index(): JsonResponse
    {
        return response()->json(CommentResource::collection($this->commentService->getAll()));
    }

    public function store(CommentStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $comment = $this->commentService->create($data);

        return response()->json(new CommentResource($comment), 201);
    }

    public function update(CommentUpdateRequest $request, int $id): JsonResponse
    {
        $comment = $this->commentService->getById($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $this->authorize('update', $comment);

        $updated = $this->commentService->update($id, $request->validated());

        return response()->json(new CommentResource($updated));
    }

    public function destroy(int $id): JsonResponse
    {
        $comment = $this->commentService->getById($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $this->authorize('delete', $comment);

        $this->commentService->delete($id);

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
