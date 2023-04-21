<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Api\Users\StoreUsersRequest;
use App\Repositories\UsersRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class RegisteredUserController
{
    public function __construct(protected readonly UsersRepository $repository)
    {
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUsersRequest $request): Response
    {
        $user = $this->repository->storeUsers($request);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
