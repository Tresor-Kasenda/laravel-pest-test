<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Http\Requests\Api\Users\EditUserRequest;
use App\Http\Resources\Api\Users\ListUsersResources;
use App\Repositories\UsersRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UpdateUsersController
{
    public function __construct(
        protected readonly UsersRepository $repository
    )
    {
    }

    public function __invoke(EditUserRequest $request, string $id): JsonResponse
    {
        $user = $this->repository->update(
            request: $request,
            id: $id
        );

        return response()->json(
            data: ListUsersResources::make($user),
            status: Response::HTTP_CREATED
        );
    }
}
