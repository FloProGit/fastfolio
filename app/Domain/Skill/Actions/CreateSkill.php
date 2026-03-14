<?php

namespace App\Domain\Skill\Actions;

use App\Domain\Skill\Models\Skill;

class CreateSkill
{
    public function execute(array $data): Skill
    {
        return Skill::create($data);
    }
}
