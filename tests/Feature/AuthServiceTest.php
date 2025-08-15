<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    protected AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService(new UserRepository());
    }

    /** @test */
    public function it_fails_if_required_fields_are_missing()
    {
        $data = [];

        $response = $this->authService->register($data);
        $responseArray = json_decode($response->getContent(), true);

        $this->assertFalse($responseArray['success']);
        $this->assertEquals(422, $response->getStatusCode());

        // Validation errors are inside 'data'
        $this->assertArrayHasKey('data', $responseArray);
        $errors = $responseArray['data'];

        // $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('password', $errors);
    }

    /** @test */
    public function it_registers_a_user_successfully()
    {
        $email = 'user_' . uniqid() . '@example.com';

        $data = [
            'name' => 'John Doe',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->authService->register($data);
        $responseArray = json_decode($response->getContent(), true);

        $this->assertTrue($responseArray['success']);
        $this->assertEquals(201, $response->getStatusCode());

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertArrayHasKey('token', $responseArray['data']);
    }

    /** @test */
    public function it_fails_if_email_already_exists()
    {
        $email = 'existing_user@example.com';

        // Ensure the user exists
        User::firstOrCreate(['email' => $email], [
            'name' => 'Existing User',
            'password' => bcrypt('password'),
        ]);

        $data = [
            'name' => 'Jane Doe',
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->authService->register($data);
        $responseArray = json_decode($response->getContent(), true);

        $this->assertFalse($responseArray['success']);
        $this->assertEquals(422, $response->getStatusCode());

        // Validation errors are inside 'data'
        $this->assertArrayHasKey('data', $responseArray);
        $errors = $responseArray['data'];
        $this->assertArrayHasKey('email', $errors);
    }
}
