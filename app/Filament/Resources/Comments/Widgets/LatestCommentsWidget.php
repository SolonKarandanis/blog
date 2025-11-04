<?php

namespace App\Filament\Resources\Comments\Widgets;

use App\Filament\Resources\Comments\CommentResource;
use App\Models\Comment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestCommentsWidget extends TableWidget
{

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Comment::whereDate('created_at', '>', now()->subDays(70)->startOfDay()))
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('post.title'),
                TextColumn::make('comment'),
                TextColumn::make('created_at')->date()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('View')
                    ->url(fn (Comment $record): string => CommentResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
