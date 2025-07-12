<?php

namespace App\Interfaces\Services;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): User;

    public function login(string $email, string $password): ?User;

    public function logout(User $user): void;
}