<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

beforeEach(fn () => $this->user = User::factory()->create());

it('get specific user information', function (): void {
    actingAs($this->user)
        ->get('/api/users/'.$this->user->id)
        ->assertStatus(201);

    expect($this->user)
        ->toBeInstanceOf(Model::class);
});

it('email required informations', function (): void {
    actingAs($this->user);
    $user = put('/api/users/'.$this->user->id, [
        'name' => 'kasenda'
    ])
        ->assertStatus(302);

    $user->assertSessionHasErrors([
        'email' => 'The email field is required.',
    ]);
});

it('name required informations', function (): void {
    actingAs($this->user);
    $user = put('/api/users/'.$this->user->id, [
        'email' => 'kasendatresor@gmail.com'
    ])
        ->assertStatus(302);

    $user->assertSessionHasErrors([
        'name' => 'The name field is required.',
    ]);
});

it('required fields is been empty', function (): void {
    actingAs($this->user);
    $user = put('/api/users/'.$this->user->id, [])
        ->assertStatus(302);

    $user->assertSessionHasErrors([
        'name' => 'The name field is required.',
        'email' => 'The email field is required.',
    ]);
});

it('unauthenticated users information', function (): void {
    put('/api/users/'.$this->user->id, [])
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect('/login');
});

it('update information with users', function (): void {
    actingAs($this->user)
        ->put('/api/users/'.$this->user->id, [
            'name' => 'kasenda',
            'email' => 'kasendatresor@gmail.com'
        ])
        ->assertStatus(201);

    expect($this->user)
        ->toBeInstanceOf(Model::class);
});
