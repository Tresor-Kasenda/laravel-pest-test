<?php

declare(strict_types=1);

use App\Mail\Api\Users\StoreUserEmail;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

it('verify if use is authenticated', function (): void {
    post(
        uri: 'api/users'
    )
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect('/login');

    expect()
        ->not
        ->toBeInstanceOf(Response::class);
});

it('can not create users  and displayed errors fields', function (): void {
    actingAs($this->user);
    $users = post(
        uri: 'api/users',
        data: []
    )
        ->assertStatus(302);

    $users->assertSessionHasErrors([
        'name' => 'The name field is required.',
        'email' => 'The email field is required.',
        'password' => 'The password field is required.',
    ]);
});

it('can store user information', function (): void {
    actingAs($this->user)
        ->post(
            uri: 'api/users',
            data: [
                'name' => $this->user->name,
                'email' => 'scotttresor@gmail.com',
                'password' => $this->user->password,
                'password_confirmation' => $this->user->password,
            ]
        )
        ->assertOk()
        ->assertJson([
            'name' => $this->user->name,
            'email' => 'scotttresor@gmail.com'
        ]);

    expect($this->user->email)
        ->not
        ->toBe('scottresor@gmail.com');
});

it('can send confirmation email after register', function (): void {
    Mail::fake();
    actingAs($this->user)
        ->post(
            uri: 'api/users',
            data: [
                'name' => 'kasenda',
                'email' => 'kasenda@gmail.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]
        )
        ->assertOk()
        ->assertJson([
            'name' => 'kasenda',
            'email' => 'kasenda@gmail.com'
        ]);
    Mail::to($this->user->email)->send(new StoreUserEmail($this->user));
    Mail::assertSent(StoreUserEmail::class);

    $this->assertDatabaseHas(User::class, [
        'name' => 'kasenda',
        'email' => 'kasenda@gmail.com',
    ]);
});
