<?php

namespace App\Domain\Project\Actions;

use App\Domain\Project\Models\Project;

class UpdateProject
{
    public function execute(Project $project, array $data): Project
    {
        $project->update($data);

        if (array_key_exists('skill_ids', $data)) {
            $project->skills()->sync($data['skill_ids']);
        }

        return $project->load(['skills', 'images']);
    }
}
