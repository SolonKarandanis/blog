<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Video;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

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

    protected function afterSave(): void{
        $this->handleVideos();
    }

    protected function handleVideos(): void{
        $videoData = $this->form->getState()['videos_uploader'] ?? [];
        $videos = [];
        foreach ($videoData as $data) {
            // Here you might want to check if the video already exists
            // For simplicity, we'll create new ones. A more robust solution
            // would involve updating existing records if an ID is passed.
            $videos[] = Video::create($data);
        }
        $this->record->videos()->sync(collect($videos)->pluck('id'));
    }
}
