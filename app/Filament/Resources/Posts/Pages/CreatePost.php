<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Video;
use Filament\Resources\Pages\CreateRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function afterCreate(): void{
        $this->handleVideos();
    }

    protected function handleVideos(): void
    {
        $videoData = $this->data['videos_uploader'] ?? [];
        if (!is_array($videoData)) {
            return; // Exit if the form data is not an array
        }

        $videoIds = [];

        foreach ($videoData as $data) {
            // Rigorous check for valid data structure
            if (!is_array($data) || !isset($data['path'])) {
                continue;
            }

            $filePath = $data['path'];
            if ($filePath instanceof TemporaryUploadedFile) {
                $filePath = $filePath->store('videos', 'public');
            }

            if (empty($filePath)) {
                continue;
            }

            // Final, clean attributes array
            $attributes = [
                'path' => $filePath,
                'title' => $data['title'] ?? null,
            ];

            $video = Video::create($attributes);
            $videoIds[] = $video->id;
        }

        $this->record->videos()->sync($videoIds);
    }
}
