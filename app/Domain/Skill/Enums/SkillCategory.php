<?php

namespace App\Domain\Skill\Enums;

enum SkillCategory: string
{
    case Frontend = 'frontend';
    case Backend = 'backend';
    case Devops = 'devops';
    case Other = 'other';

    public function label(): string
    {
        return __('enums.skill_category.' . $this->value);
    }
}
