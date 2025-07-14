<?php

namespace App\Interfaces\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PostServiceInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?Post;

    public function create(array $data): Post;

    public function update(int $id, array $data): ?Post;

    public function delete(int $id): bool;

    public function search(array $filters): LengthAwarePaginator;
}