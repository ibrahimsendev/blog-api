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

    public function getAll(): Collection
    {
        return $this->postRepository->all();
    }

    public function getById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function create(array $data): Post
    {
        return $this->postRepository->create($data);
    }

    public function update(int $id, array $data): ?Post
    {
        $post = $this->postRepository->find($id);
        if (!$post) {
            return null;
        }

        $updated = $this->postRepository->update($id, $data);

        if (!$updated) {
            return null;
        }

        return $post->fresh();
    }

    public function delete(int $id): bool
    {
        return $this->postRepository->delete($id);
    }

    public function search(array $filters): LengthAwarePaginator
    {
        return $this->postRepository->search($filters);
    }
}
