<?php

namespace App\Http\Controllers\Api;

use App\Domain\Skill\Models\Skill;
use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::ordered()->get();

        return SkillResource::collection($skills);
    }
}
