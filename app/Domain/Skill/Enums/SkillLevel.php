<?php

namespace App\Domain\Skill\Enums;

enum SkillLevel: string
{
    case Beginner = 'beginner';
    case Intermediate = 'intermediate';
    case Advanced = 'advanced';
    case Expert = 'expert';

    public function label(): string
    {
        return __('enums.skill_level.'.$this->value);
    }
}
