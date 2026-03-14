<?php

namespace App\Domain\Project\Actions;

use App\Domain\Project\Models\Project;

class GetProject
{
    public function execute(Project $project): Project
    {
        return $project->load(['skills', 'images']);
    }
}
