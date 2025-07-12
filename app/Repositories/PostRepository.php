<?php

namespace App\Repositories;

use App\Interfaces\Repositories\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function all(): Collection
    {
        return Post::all();
    }

    public function find(int $id): ?Post
    {
        return Post::find($id);
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $post = $this->find($id);
        if (!$post) return false;
        return $post->update($data);
    }

    public function delete(int $id): bool
    {
        $post = $this->find($id);
        if (!$post) return false;
        return $post->delete();
    }

    public function search(array $filters): LengthAwarePaginator
    {
        $query = Post::query();

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['author_id'])) {
            $query->where('user_id', $filters['author_id']);
        }

        return $query->latest()->paginate(10);
    }
}
