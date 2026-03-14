<?php

namespace App\Domain\Project\Actions;

use App\Domain\Project\Models\Project;

class CreateProject
{
    public function execute(array $data): Project
    {
        $project = Project::create($data);

        if (! empty($data['skill_ids'])) {
            $project->skills()->sync($data['skill_ids']);
        }

        return $project->load(['skills', 'images']);
    }
}
