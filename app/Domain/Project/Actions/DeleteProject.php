<?php

namespace App\Domain\Project\Actions;

use App\Domain\Project\Models\Project;

class DeleteProject
{
    public function execute(Project $project): void
    {
        $project->delete();
    }
}
