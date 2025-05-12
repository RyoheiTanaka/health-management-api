<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreAuthenticatedSessionFormRequest;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticatedSessionController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Handle the incoming request.
     *
     * @throws AuthenticationException
     */
    public function store(StoreAuthenticatedSessionFormRequest $request): Response
    {
        $credentials = $request->only(['email', 'password']);

        return $this->authService->login($credentials, $request);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        return $this->authService->logout($request);
    }
}
