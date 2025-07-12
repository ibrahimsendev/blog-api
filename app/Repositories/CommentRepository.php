<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    public function all(): Collection
    {
        return Comment::with(['user', 'post'])->latest()->get();
    }

    public function find(int $id): ?Comment
    {
        return Comment::find($id);
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $comment = $this->find($id);
        return $comment ? $comment->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $comment = $this->find($id);
        return $comment ? $comment->delete() : false;
    }
}