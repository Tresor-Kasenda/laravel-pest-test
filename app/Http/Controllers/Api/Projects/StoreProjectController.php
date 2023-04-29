<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Projects;

use App\Http\Requests\Api\Projects\StoreProjectRequest;
use App\Repositories\ProjectRepository;

final class StoreProjectController
{
    public function __construct(
        protected readonly ProjectRepository $repository
    )
    {
    }

    public function __invoke(StoreProjectRequest $request): void
    {
    }
}
