<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Interfaces\Services\CommentServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
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
        $updated = $this->commentService->update($id, $request->validated());

        return $updated
            ? response()->json(new CommentResource($this->commentService->getById($id)))
            : response()->json(['message' => 'Comment not found'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->commentService->delete($id)
            ? response()->json(['message' => 'Comment deleted'])
            : response()->json(['message' => 'Comment not found'], 404);
    }
}
