<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Video;
use Filament\Resources\Pages\CreateRecord;

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

    protected function handleVideos(): void{
        $videoData = $this->form->getState()['videos_uploader'] ?? [];
        $videos = [];
        foreach ($videoData as $data) {
            $videos[] = Video::create($data);
        }
        $this->record->videos()->sync(collect($videos)->pluck('id'));
    }
}
