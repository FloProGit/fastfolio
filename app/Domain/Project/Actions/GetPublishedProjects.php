<?php

namespace App\Domain\Project\Actions;

use App\Domain\Project\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPublishedProjects
{
    public function execute(int $perPage = 15): LengthAwarePaginator
    {
        return Project::published()
            ->ordered()
            ->with(['skills', 'images'])
            ->paginate($perPage);
    }
}
