<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Skill\Actions\CreateSkill;
use App\Domain\Skill\Enums\SkillCategory;
use App\Domain\Skill\Enums\SkillLevel;
use App\Domain\Skill\Models\Skill;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillRequest;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::ordered()->get();

        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create', [
            'categories' => SkillCategory::cases(),
            'levels' => SkillLevel::cases(),
        ]);
    }

    public function store(StoreSkillRequest $request, CreateSkill $action)
    {
        $action->execute($request->validated());

        return redirect()->route('admin.skills.index')
            ->with('success', 'Compétence créée.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', [
            'skill' => $skill,
            'categories' => SkillCategory::cases(),
            'levels' => SkillLevel::cases(),
        ]);
    }

    public function update(StoreSkillRequest $request, Skill $skill)
    {
        $skill->update($request->validated());

        return redirect()->route('admin.skills.index')
            ->with('success', 'Compétence modifiée.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Compétence supprimée.');
    }
}
