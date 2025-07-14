<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Interfaces\Services\PostServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private PostServiceInterface $postService) {}

    public function index(): JsonResponse
    {
        $filters = request()->only(['search', 'category_id', 'author_id']);
        $posts = $this->postService->search($filters);

        return response()->json([
            'data' => PostResource::collection($posts),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'total' => $posts->total(),
            ],
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getById($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        
        return response()->json(new PostResource($post));
    }

    public function store(PostStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $post = $this->postService->create($data);

        return response()->json(new PostResource($post), 201);
    }

    public function update(PostUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $post = $this->postService->getById($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $this->authorize('update', $post);

        $updated = $this->postService->update($id, $data);

        return response()->json(['data' => new PostResource($updated)], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $post = $this->postService->getById($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $this->authorize('delete', $post);

        $this->postService->delete($id);

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
