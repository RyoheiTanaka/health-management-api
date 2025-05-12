<?php

namespace App\Services;

use App\Repositories\AuthRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthService
{
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function login(array $credentials, Request $request): Response
    {
        if ($this->authRepository->attempt($credentials)) {
            $request->session()->regenerate();

            return response([
                'data' => [
                    'is_login' => true,
                    'message' => 'ログインしました。',
                ],
            ]);
        }

        throw new AuthenticationException('ログインできませんでした。');
    }

    public function logout(Request $request): Response
    {
        if ($this->authRepository->isGuest()) {
            return response([
                'data' => [
                    'is_login' => false,
                    'message' => 'ログインしていません。',
                ]
            ]);
        }

        $this->authRepository->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response([
            'data' => [
                'is_login' => false,
                'message' => 'ログアウトしました。',
            ]
        ]);
    }
}
