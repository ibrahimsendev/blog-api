<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Interfaces\Services\PostServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use AuthorizesRequests, ApiResponse;

    public function __construct(private PostServiceInterface $postService) {}

    public function index(): JsonResponse
    {
        $filters = request()->only(['search', 'category_id', 'author_id']);
        $posts = $this->postService->search($filters);

        return $this->successResponse(
            [
                'posts' => PostResource::collection($posts),
                'meta' => [
                    'current_page' => $posts->currentPage(),
                    'last_page' => $posts->lastPage(),
                    'total' => $posts->total(),
                ],
            ],
            'Posts retrieved successfully.'
        );
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getById($id);

        return $post
            ? $this->successResponse(
                new PostResource($post),
                'Post retrieved successfully.'
            )
            : $this->errorResponse('Post not found.', 404);
    }

    public function store(PostStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $post = $this->postService->create($data);

        return $this->successResponse(
            new PostResource($post),
            'Post created successfully.',
            201
        );
    }

    public function update(PostUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $post = $this->postService->getById($id);

        if (!$post) {
            return $this->errorResponse('Post not found.', 404);
        }

        $this->authorize('update', $post);

        $updated = $this->postService->update($id, $data);

        return $this->successResponse(
            new PostResource($updated),
            'Post updated successfully.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $post = $this->postService->getById($id);

        if (!$post) {
            return $this->errorResponse('Post not found', 404);
        }

        $this->authorize('delete', $post);

        $this->postService->delete($id);

        return $this->successResponse(null, 'Post deleted successfully.');
    }
}
