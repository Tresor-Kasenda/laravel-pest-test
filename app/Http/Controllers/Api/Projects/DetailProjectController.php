<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Projects;

use App\Http\Resources\Api\Projects\DetailProjectResource;
use App\Repositories\ProjectRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DetailProjectController
{
    public function __construct(
        protected readonly ProjectRepository $repository
    )
    {
    }

    public function __invoke(string $id): JsonResponse
    {
        return response()->json(
            data: DetailProjectResource::make(
                $this->repository->getProject(id: $id)
            ),
            status: Response::HTTP_OK,
        );
    }
}
