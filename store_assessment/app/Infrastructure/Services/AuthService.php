<?php

namespace App\Infrastructure\Services;

use App\Domain\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    /**
     * Attempt login and return a plain-text API token on success.
     *
     * @param  string  $email
     * @param  string  $password
     * @return string|null
     */
    public function login(string $email, string $password): ?string
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return null;
        }

        return Auth::user()->createToken('api-token')->plainTextToken;
    }
}
