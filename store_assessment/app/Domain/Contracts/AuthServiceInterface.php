<?php

namespace App\Domain\Contracts;

interface AuthServiceInterface
{
    /**
     * Attempt login and return API token.
     *
     * @param  string  $email
     * @param  string  $password
     * @return string|null
     */
    public function login(string $email, string $password): ?string;
}