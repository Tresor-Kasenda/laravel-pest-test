<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

final class ProjectRepository
{
    public function projects(): Collection|array
    {
        return Project::query()
            ->with(relations: 'user')
            ->latest()
            ->get();
    }

    public function getProject(string $id): Model|Builder|null
    {
        $project = Project::query()
            ->where('id', '=', $id)
            ->firstOrFail();

        return $project->load(relations: 'user');
    }
}
