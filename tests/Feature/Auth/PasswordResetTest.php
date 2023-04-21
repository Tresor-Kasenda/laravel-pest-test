<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\post;

beforeEach(fn () => $this->user = User::factory()->create());

it('reset password link can be requested', function (): void {
    Notification::fake();

    post('/forgot-password', ['email' => $this->user->email]);

    Notification::assertSentTo($this->user, ResetPassword::class);
});

it('password can be reset with valid token', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
        post('/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertSessionHasNoErrors();

        return true;
    });
});
