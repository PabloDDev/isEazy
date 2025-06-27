<?php

namespace App\Interface\Http\Controllers\Api\V1;

use App\Infrastructure\Services\AuthService;
use App\Interface\Http\Controllers\Controller;
use App\Interface\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * Handle user login and return API token.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $token = $this->authService->login(
            $validated['email'],
            $validated['password']
        );

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }
}
