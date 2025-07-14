<?php

namespace App\Services;

use App\Interfaces\Repositories\CommentRepositoryInterface;
use App\Interfaces\Services\CommentServiceInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentService implements CommentServiceInterface
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

    public function update(int $id, array $data): ?Comment
    {
        $comment = $this->commentRepository->find($id);

        if (!$comment) {
            return null;
        }

        $this->commentRepository->update($id, $data);

        return $comment->fresh();
    }

    public function delete(int $id): bool
    {
        $comment = $this->commentRepository->find($id);

        if (!$comment) {
            return false;
        }

        return $this->commentRepository->delete($id);
    }
}