<?php

namespace App\Filament\Resources\Posts\Widgets;

use App\Models\Post;
use App\Models\PostView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class PostOverviewWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Post Statistics';

    protected int | string | array $columnSpan = 'full';

    public ?Model $record=null;

    protected function getStats(): array
    {
        return [
            Stat::make('View Count',PostView::query()->where('post_id','=',$this->record->id)->count()),
            Stat::make('Post Likes',Post::query()->where('id','=',$this->record->id)->withCount('likes')->count()),
        ];
    }
}
