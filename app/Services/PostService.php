<?php

namespace App\Services;

use App\Interfaces\Repositories\PostRepositoryInterface;
use App\Interfaces\Services\PostServiceInterface;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostService implements PostServiceInterface
{
    public function __construct(private PostRepositoryInterface $postRepository) {}

    public function getAllPosts(): Collection
    {
        return $this->postRepository->all();
    }

    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function createPost(array $data): Post
    {
        return $this->postRepository->create($data);
    }

    public function updatePost(int $id, array $data): bool
    {
        return $this->postRepository->update($id, $data);
    }

    public function deletePost(int $id): bool
    {
        return $this->postRepository->delete($id);
    }

    public function searchPosts(array $filters): LengthAwarePaginator
    {
        return $this->postRepository->search($filters);
    }
}
