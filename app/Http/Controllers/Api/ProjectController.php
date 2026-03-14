<?php

namespace App\Http\Controllers\Api;

use App\Domain\Project\Actions\GetProject;
use App\Domain\Project\Actions\GetPublishedProjects;
use App\Domain\Project\Models\Project;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController
{
    // Public

    public function index(GetPublishedProjects $action): AnonymousResourceCollection
    {
        return ProjectResource::collection($action->execute());
    }

    public function show(Project $project, GetProject $action): ProjectResource
    {
        return new ProjectResource($action->execute($project));
    }

    // Admin

    public function adminIndex(): AnonymousResourceCollection
    {
        $projects = Project::ordered()
            ->with(['skills', 'images'])
            ->paginate(15);

        return ProjectResource::collection($projects);
    }
}
