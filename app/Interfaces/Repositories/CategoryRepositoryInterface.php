<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Category;

    public function create(array $data): Category;

    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
}