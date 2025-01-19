<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreAuthenticatedSession;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticatedSessionController extends Controller
{
    public function __construct(private AuthManager $auth) {}

    /**
     * Handle the incoming request.
     *
     * @throws AuthenticationException
     */
    public function store(StoreAuthenticatedSession $request): Response
    {
        $credentials = $request->only(['email', 'password']);

        if ($this->auth->guard()->attempt($credentials)) {
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

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        if ($this->auth->guard()->guest()) {
            return response([
                'data' => [
                    'is_login' => false,
                    'massage' => 'ログインしていません。',
                ]
            ]);
        }

        $this->auth->guard()->logout();
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
