<?php

namespace Tests\Feature;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Infrastructure\Persistence\Eloquent\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private const LOGIN_ENDPOINT = '/api/v1/login';
    private const VALID_EMAIL = 'user@example.com';
    private const VALID_PASSWORD = 'secret123';

    private function createUser(): User
    {
        return User::factory()->create([
            'email' => self::VALID_EMAIL,
            'password' => bcrypt(self::VALID_PASSWORD),
        ]);
    }

    /** @test */
    #[Test]
    public function it_allows_login_with_valid_credentials(): void
    {
        $this->createUser();

        $response = $this->postJson(self::LOGIN_ENDPOINT, [
            'email' => self::VALID_EMAIL,
            'password' => self::VALID_PASSWORD,
        ]);

        $response->assertOk()
                 ->assertJsonStructure(['token']);
    }

    /** @test */
    #[Test]
    public function it_rejects_login_with_invalid_password(): void
    {
        $this->createUser();

        $response = $this->postJson(self::LOGIN_ENDPOINT, [
            'email' => self::VALID_EMAIL,
            'password' => 'wrong-password',
        ]);

        $response->assertUnauthorized()
                 ->assertJsonStructure(['message']);
    }

    /** @test */
    #[Test]
    public function it_requires_email_and_password(): void
    {
        $response = $this->postJson(self::LOGIN_ENDPOINT, []);

        $response->assertUnprocessable()
                 ->assertJsonValidationErrors(['email', 'password']);
    }
}
