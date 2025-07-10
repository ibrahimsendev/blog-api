<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository) {}

    public function getAll(): Collection
    {
        return $this->categoryRepository->all();
    }

    public function getById(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    public function create(array $data): Category
    {
        return $this->categoryRepository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }
}