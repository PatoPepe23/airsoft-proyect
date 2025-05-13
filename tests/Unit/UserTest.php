<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testCreateUser(): void
    {
        $userData = [
            'fullName' => 'Test Testing',
            'email' => 'test@example.com',
            'password' => 'test123',
            'phonenumber' => '1234567890',
            'DNI' => '12345678A',
            'role_id' => 1,
        ];

        $user = new User($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['fullName'], $user->fullName);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['phonenumber'], $user->phonenumber);
        $this->assertEquals($userData['DNI'], $user->DNI);
        $this->assertEquals($userData['role_id'], $user->role_id);
        $this->assertNull($user->id);
    }
}
