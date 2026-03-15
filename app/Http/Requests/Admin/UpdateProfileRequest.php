<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'bio' => ['required', 'array'],
            'bio.fr' => ['required', 'string'],
            'bio.en' => ['required', 'string'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'resume_url' => ['nullable', 'array'],
            'resume_url.fr' => ['nullable', 'url', 'max:255'],
            'resume_url.en' => ['nullable', 'url', 'max:255'],
            'location' => ['nullable', 'array'],
            'location.fr' => ['nullable', 'string', 'max:255'],
            'location.en' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'socials' => ['nullable', 'array'],
            'socials.github' => ['nullable', 'url', 'max:255'],
            'socials.linkedin' => ['nullable', 'url', 'max:255'],
            'socials.twitter' => ['nullable', 'url', 'max:255'],
            'seo_title' => ['nullable', 'array'],
            'seo_title.fr' => ['nullable', 'string', 'max:255'],
            'seo_title.en' => ['nullable', 'string', 'max:255'],
            'seo_desc' => ['nullable', 'array'],
            'seo_desc.fr' => ['nullable', 'string', 'max:255'],
            'seo_desc.en' => ['nullable', 'string', 'max:255'],
        ];
    }
}
