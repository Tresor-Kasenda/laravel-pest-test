<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Users;

use App\Repositories\UsersRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DeleteUserController
{
    public function __construct(protected readonly UsersRepository $repository)
    {
    }

    public function __invoke(string $id): JsonResponse
    {
        $this->repository->delete(id: $id);
        return response()->json(
            data: [],
            status: Response::HTTP_NO_CONTENT
        );
    }
}
