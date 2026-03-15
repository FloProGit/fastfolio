<?php

namespace App\Http\Resources;

use App\Domain\Profile\Models\Profile;
use App\Domain\Shared\Helpers\QuillSanitizer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Profile */
class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->getTranslation('title'),
            'bio' => QuillSanitizer::clean($this->getTranslation('bio') ?? ''),
            'avatar' => $this->avatar ? asset('storage/'.$this->avatar) : null,
            'resume_url' => $this->getTranslation('resume_url'),
            'location' => $this->getTranslation('location'),
            'email' => $this->email,
            'socials' => $this->socials,
            'seo_title' => $this->getTranslation('seo_title'),
            'seo_desc' => $this->getTranslation('seo_desc'),
        ];
    }
}
