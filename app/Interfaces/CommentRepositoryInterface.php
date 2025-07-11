<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Comment;
    public function create(array $data): Comment;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}