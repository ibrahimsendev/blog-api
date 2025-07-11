<?php

namespace App\Services;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    public function __construct(private CommentRepositoryInterface $commentRepository) {}

    public function getAll(): Collection
    {
        return $this->commentRepository->all();
    }

    public function getById(int $id): ?Comment
    {
        return $this->commentRepository->find($id);
    }

    public function create(array $data): Comment
    {
        return $this->commentRepository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->commentRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->commentRepository->delete($id);
    }
}