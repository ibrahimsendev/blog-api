<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(private CommentService $service) {}

    public function index(): JsonResponse
    {
        return response()->json(CommentResource::collection($this->service->getAll()));
    }

    public function store(CommentStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $comment = $this->service->create($data);

        return response()->json(new CommentResource($comment), 201);
    }

    public function update(CommentUpdateRequest $request, int $id): JsonResponse
    {
        $updated = $this->service->update($id, $request->validated());

        return $updated
            ? response()->json(new CommentResource($this->service->getById($id)))
            : response()->json(['message' => 'Comment not found'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->service->delete($id)
            ? response()->json(['message' => 'Comment deleted'])
            : response()->json(['message' => 'Comment not found'], 404);
    }
}
