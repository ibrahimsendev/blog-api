<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

    public function index(): JsonResponse
    {
        $posts = $this->postService->getAllPosts();
        return response()->json(PostResource::collection($posts));
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getPostById($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json(new PostResource($post));
    }

    public function store(PostStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $post = $this->postService->createPost($data);
        return response()->json(new PostResource($post), 201);
    }

    public function update(PostUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $updated = $this->postService->updatePost($id, $data);
        if (!$updated) {
            return response()->json(['message' => 'Post not found or not updated'], 404);
        }
        $post = $this->postService->getPostById($id);
        return response()->json(new PostResource($post));
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->postService->deletePost($id);
        if (!$deleted) {
            return response()->json(['message' => 'Post not found or not deleted'], 404);
        }
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
