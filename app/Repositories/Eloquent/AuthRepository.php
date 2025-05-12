<?php

namespace App\Repositories\Eloquent;

use App\Repositories\AuthRepositoryInterface;
use Illuminate\Auth\AuthManager;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(private AuthManager $auth) {}

    public function attempt(array $credentials): bool
    {
        return $this->auth->guard()->attempt($credentials);
    }

    public function logout(): void
    {
        $this->auth->guard()->logout();
    }

    public function isGuest(): bool
    {
        return $this->auth->guard()->guest();
    }
}
