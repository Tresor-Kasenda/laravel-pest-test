<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Http\Resources\Api\Users\ListUsersResources;
use App\Repositories\UsersRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class EditUserController
{
    public function __construct(
        protected readonly UsersRepository $repository
    )
    {
    }

    public function __invoke(string $id): JsonResponse
    {
        $user = $this->repository->showUser(id: $id);

        return response()->json(
            data: ListUsersResources::make($user),
            status: Response::HTTP_CREATED
        );
    }
}
