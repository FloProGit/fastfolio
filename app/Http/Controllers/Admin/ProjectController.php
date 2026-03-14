<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Project\Actions\CreateProject;
use App\Domain\Project\Actions\StoreProjectImages;
use App\Domain\Project\Actions\UpdateProject;
use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Project\Models\Project;
use App\Domain\Skill\Models\Skill;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::ordered()->with(['skills', 'images'])->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create', [
            'statuses' => ProjectStatus::cases(),
            'skills' => Skill::ordered()->get(),
        ]);
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', [
            'project' => $project->load(['skills', 'images']),
            'statuses' => ProjectStatus::cases(),
            'skills' => Skill::ordered()->get(),
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', __('Projet supprimé.'));
    }

    public function store(StoreProjectRequest $request, CreateProject $action, StoreProjectImages $imageAction)
    {
        $project = $action->execute($request->validated());

        if ($request->has('images')) {
            $imageAction->execute($project, $request->validated('images'));
        }

        return redirect()->route('admin.projects.index')
            ->with('success', __('Projet créé.'));
    }

    public function update(UpdateProjectRequest $request, Project $project, UpdateProject $action, StoreProjectImages $imageAction)
    {
        $action->execute($project, $request->validated());

        if ($request->has('delete_images')) {
            /** @var \App\Domain\Project\Models\ProjectImage $image */
            foreach ($project->images()->whereIn('id', $request->validated('delete_images'))->get() as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }
        // Ajouter les nouvelles images
        if ($request->has('images')) {
            $imageAction->execute($project, $request->validated('images'));
        }

        return redirect()->route('admin.projects.index')
            ->with('success', __('Projet modifié.'));
    }
}
