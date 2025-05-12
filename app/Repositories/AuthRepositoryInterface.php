<?php

namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function attempt(array $credentials): bool;
    public function logout(): void;
    public function isGuest(): bool;
}
