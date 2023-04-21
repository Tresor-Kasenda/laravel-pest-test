<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListUsersResources extends JsonResource
{
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
