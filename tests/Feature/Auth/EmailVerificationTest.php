<?php

declare(strict_types=1);

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

use function Pest\Laravel\actingAs;

beforeEach(fn () => $this->user = User::factory()->create([
    'email_verified_at' => null,
]));

it('test_email_can_be_verified', function (): void {
    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
    );

    actingAs($this->user)
        ->get($verificationUrl)
        ->assertRedirect(config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1');

    Event::assertDispatched(Verified::class);
    $this->assertTrue($this->user->fresh()->hasVerifiedEmail());
});

it('test_email_is_not_verified_with_invalid_hash', function (): void {
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1('wrong-email')]
    );

    actingAs($this->user)->get($verificationUrl);

    $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
});
