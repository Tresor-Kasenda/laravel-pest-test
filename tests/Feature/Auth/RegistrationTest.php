<?php

declare(strict_types=1);

use function Pest\Laravel\post;

it('new users can register', function (): void {
    post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])
        ->assertNoContent();

    $this->assertAuthenticated();

    expect('password')
        ->toBe('password');
});
