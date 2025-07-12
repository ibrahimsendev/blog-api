<?php

namespace App\Services;

use App\Interfaces\Repositories\AuthRepositoryInterface;
use App\Interfaces\Services\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function register(array $data): User
    {
        return $this->authRepository->createUser($data);
    }

    public function login(string $email, string $password): ?User
    {
        $user = $this->authRepository->findByEmail($email);

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function logout($user): void
    {
        $user->tokens()->delete();
    }
}