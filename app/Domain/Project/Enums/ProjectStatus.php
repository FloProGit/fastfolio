<?php

namespace App\Domain\Project\Enums;

enum ProjectStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    public function label(): string
    {
        return __('enums.project_status.'.$this->value);
    }
}
