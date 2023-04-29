<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(fn () => $this->user = User::factory()->create());

it('unauthenticated users information', function (): void {
    get('/api/users/')
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect('/login');
});

it('list of users in applications', function (): void {
    $users = User::factory()->count(10)->create();
    actingAs($this->user)
        ->get(uri: 'api/users')
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonCount(11);

    expect($users)
        ->toContainOnlyInstancesOf(Model::class);

});


it('delete user information', function (): void {
    $user = User::factory()->create();
    actingAs($user)
        ->delete(
            uri: '/api/users/'.$user->id
        )
        ->assertStatus(Response::HTTP_NO_CONTENT)
        ->assertNoContent();
});
