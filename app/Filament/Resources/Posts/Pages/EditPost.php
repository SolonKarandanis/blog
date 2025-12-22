<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Video;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function fillForm(): void
    {
        $data = $this->record->toArray();
        $data['videos_uploader'] = $this->record->videos->toArray();
        $this->form->fill($data);
    }

    protected function afterSave(): void{
        $this->handleVideos();
    }

    protected function handleVideos(): void
    {
        $videoData = $this->data['videos_uploader'] ?? [];
        if (!is_array($videoData)) {
            return;
        }

        $processedVideoIds = [];

        foreach ($videoData as $data) {
            if (!is_array($data) || !isset($data['path'])) {
                continue;
            }

            $filePath = $data['path'];

            // Handle new file uploads
            if ($filePath instanceof TemporaryUploadedFile) {
                $filePath = $filePath->store('videos', 'public');
            }
            // Handle existing files, which are passed as an array
            elseif (is_array($filePath)) {
                $filePath = current($filePath); // Extract the path string from the array
            }

            if (empty($filePath) || !is_string($filePath)) {
                continue;
            }

            $videoId = $data['id'] ?? null;

            $attributes = [
                'path' => $filePath,
                'title' => $data['title'] ?? null,
            ];

            if ($videoId) {
                $video = Video::find($videoId);
                if ($video) {
                    $video->update($attributes);
                    $processedVideoIds[] = $video->id;
                }
            } else {
                $video = Video::create($attributes);
                $processedVideoIds[] = $video->id;
            }
        }

        $this->record->videos()->sync($processedVideoIds);
    }
}
