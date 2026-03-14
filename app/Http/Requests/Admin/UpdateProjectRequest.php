<?php

namespace App\Http\Requests\Admin;

use App\Domain\Project\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'array'],
            'title.fr' => ['required_with:title', 'string', 'max:255'],
            'title.en' => ['required_with:title', 'string', 'max:255'],
            'slug' => ['sometimes', 'array'],
            'slug.fr' => ['required_with:slug', 'string', 'max:255', Rule::unique('projects', 'slug->fr')->ignore($this->route('project'))],
            'slug.en' => ['required_with:slug', 'string', 'max:255', Rule::unique('projects', 'slug->en')->ignore($this->route('project'))],
            'excerpt' => ['nullable', 'array'],
            'excerpt.fr' => ['nullable', 'string'],
            'excerpt.en' => ['nullable', 'string'],
            'description' => ['sometimes', 'array'],
            'description.fr' => ['required_with:description', 'string'],
            'description.en' => ['required_with:description', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'repository_url' => ['nullable', 'url', 'max:255'],
            'status' => ['sometimes', Rule::enum(ProjectStatus::class)],
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
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['exists:project_images,id'],
        ];
    }
}
