<?php

namespace App\Domain\Project\Actions;

use App\Domain\Project\Models\Project;
use Illuminate\Http\UploadedFile;

class StoreProjectImages
{
    public function execute(Project $project, array $images): void
    {
        $currentMaxOrder = $project->images()->max('sort_order') ?? -1;

        foreach ($images as $index => $imageData) {
            /** @var UploadedFile $file */
            $file = $imageData['file'];

            $path = $file->store(
                "projects/{$project->id}",
                'public'
            );

            $project->images()->create([
                'path' => $path,
                'variants' => null,
                'alt' => [
                    'fr' => $imageData['alt_fr'] ?? null,
                    'en' => $imageData['alt_en'] ?? null,
                ],
                'sort_order' => $currentMaxOrder + $index + 1,
                'is_main' => $imageData['is_main'] ?? false,
            ]);
        }
    }
}
