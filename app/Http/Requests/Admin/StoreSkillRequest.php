<?php

namespace App\Http\Requests\Admin;

use App\Domain\Skill\Enums\SkillCategory;
use App\Domain\Skill\Enums\SkillLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name.fr'    => ['required', 'string', 'max:255'],
            'name.en'    => ['required', 'string', 'max:255'],
            'category'   => ['required', new Enum(SkillCategory::class)],
            'level'      => ['required', new Enum(SkillLevel::class)],
            'icon'       => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
