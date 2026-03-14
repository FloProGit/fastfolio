<?php

namespace App\Http\Requests\Admin;

use App\Domain\Project\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'array'],
            'title.fr' => ['required', 'string', 'max:255'],
            'title.en' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'array'],
            'slug.fr' => ['required', 'string', 'max:255', 'unique:projects,slug->fr'],
            'slug.en' => ['required', 'string', 'max:255', 'unique:projects,slug->en'],
            'excerpt' => ['nullable', 'array'],
            'excerpt.fr' => ['nullable', 'string'],
            'excerpt.en' => ['nullable', 'string'],
            'description' => ['required', 'array'],
            'description.fr' => ['required', 'string'],
            'description.en' => ['required', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'repository_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'featured' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
            'completed_at' => ['nullable', 'date'],
            'skill_ids' => ['nullable', 'array'],
            'skill_ids.*' => ['exists:skills,id'],
            'images' => ['nullable', 'array'],
            'images.*.file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'images.*.alt_fr' => ['nullable', 'string', 'max:255'],
            'images.*.alt_en' => ['nullable', 'string', 'max:255'],
            'images.*.is_main' => ['boolean'],
        ];
    }
}
