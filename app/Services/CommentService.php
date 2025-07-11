<?php

namespace App\Services;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    public function __construct(private CommentRepositoryInterface $repo) {}

    public function getAll(): Collection
    {
        return $this->repo->all();
    }

    public function getById(int $id): ?Comment
    {
        return $this->repo->find($id);
    }

    public function create(array $data): Comment
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }
}