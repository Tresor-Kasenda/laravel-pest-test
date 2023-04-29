<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\Projects;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class ListProjectResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
