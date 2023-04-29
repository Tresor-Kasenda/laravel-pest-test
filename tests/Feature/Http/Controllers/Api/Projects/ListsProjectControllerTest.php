<?php

declare(strict_types=1);

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(function (): void {
    $this->user = User::factory()->create();

});

it('cant access to projects lists if is not authenticated', function (): void {
    get(
        uri: 'api/projects',
    )
        ->assertStatus(Response::HTTP_FOUND)
        ->assertRedirect('/login');
});

it('can display project lists', function (): void {
    $projects = Project::factory()
        ->count(10)
        ->create([
            'user_id' => $this->user->id,
        ]);

    actingAs($this->user)
        ->get(
            uri: 'api/projects',
        )
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonCount(10);

    $this->assertDatabaseCount(Project::class, 10);

    expect($projects)
        ->toBeInstanceOf(Collection::class);
});


it('can see detail of project', function (): void {
    $project = Project::factory()
        ->create([
            'user_id' => $this->user->id,
        ]);

    actingAs($this->user)
        ->get(
            uri: "api/projects/{$project->id}",
        )
        ->assertStatus(Response::HTTP_OK);

    expect($project)
        ->toBeInstanceOf(Project::class)
        ->title
        ->toBe($project->title);
});

it('has projects with authenticated users', function (): void {
    actingAs($this->user);
    $user = User::factory()
        ->has(Project::factory())
        ->create();

    $project = $user->projects;

    expect($project)
        ->toBeInstanceOf(Collection::class)
        ->first()->toBeInstanceOf(Project::class);
});

it('can not create project and required informations', function (): void {
    actingAs($this->user);
    $project = post(
        uri: 'api/projects',
        data: []
    )
        ->assertStatus(Response::HTTP_FOUND)
        ->assertInvalid();

    $project->assertSessionHasErrors([
        'title' => 'The title field is required.',
        'content' => 'The content field is required.',
        'images' => 'The images field is required.',
        'user_id' => 'The user id field is required.',
    ]);
});

it('requires title,content, images and user_id tested with a dataset', function ($data, $error): void {
    actingAs($this->user)
        ->post('api/projects', $data)
        ->assertInvalid($error);
})->with([
    'title required' => [['content' => 'text'], ['title' => 'required']],
    'content required' => [['title' => 'text'], ['content' => 'required']],
    'images required' => [['title' => 'text', 'content' => 'text'], ['images' => 'required']],
    'user_id required' => [['title' => 'text', 'content' => 'text', 'images' => 'image'], ['user_id' => 'required']],
]);
