<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\Projects;

use App\Http\Resources\Api\Users\ListUsersResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class DetailProjectResource extends JsonResource
{
    public $resource = [
        'user' => ListUsersResources::class
    ];

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user' => ListUsersResources::make($this->user),
            'created_at' => $this->created_at,
        ];
    }
}
