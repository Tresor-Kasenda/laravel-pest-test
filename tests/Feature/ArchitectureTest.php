<?php

declare(strict_types=1);

test('no debuggings statements')
    ->expect(['dump', 'dd', 'var_dump', 'print_r'])
    ->not->toBeUsed();

test('We do not directly use Eloquent Models in our APIs.')
    ->expect('App\Models')
    ->not->toBeUsedIn('App\Http\Controllers\Api');

test('never use request in controller')
    ->expect('Illuminate\Http\Request')
    ->not->toBeUsedIn('App\Http\Controllers\Api');

test('used models in to repositories folders')
    ->expect('App\Models')
    ->toBeUsedIn('App\Repositories')
    ->toBeUsedIn('App\Policies');


