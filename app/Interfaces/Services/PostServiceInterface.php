<?php

namespace App\Interfaces\Services;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PostServiceInterface
{
    public function getAllPosts(): Collection;

    public function getPostById(int $id): ?Post;

    public function createPost(array $data): Post;

    public function updatePost(int $id, array $data): bool;

    public function deletePost(int $id): bool;

    public function searchPosts(array $filters): LengthAwarePaginator;
}