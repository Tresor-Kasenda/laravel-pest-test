<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Projects;

use App\Http\Resources\Api\Projects\ListProjectResource;
use App\Repositories\ProjectRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListsProjectController
{
    public function __construct(
        protected readonly ProjectRepository $repository
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        return response()->json(
            data: ListProjectResource::make($this->repository->projects()),
            status: Response::HTTP_OK
        );
    }
}
