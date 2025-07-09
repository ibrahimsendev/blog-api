<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
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
}
