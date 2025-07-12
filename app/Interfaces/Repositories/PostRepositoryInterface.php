<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Post;

    public function create(array $data): Post;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function search(array $filters): LengthAwarePaginator;
}
