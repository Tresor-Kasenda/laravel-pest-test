<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\post;

beforeEach(fn () => $this->user = User::factory()->create());

it('users can authenticate using the login screen', function (): void {
    post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ])->assertNoContent();

    $this->assertAuthenticated();
});

it('test users can not authenticate with invalid password', function (): void {
    post('/login', [
        'email' => $this->user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
