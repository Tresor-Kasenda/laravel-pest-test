<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Http\Resources\Api\Users\ListUsersResources;
use App\Repositories\UsersRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListeUsersController
{
    public function __construct(protected readonly UsersRepository $repository)
    {
    }

    public function __invoke(): JsonResponse
    {
        return response()->json(
            data: ListUsersResources::make($this->repository->getUsersLists()),
            status: Response::HTTP_OK
        );
    }
}
