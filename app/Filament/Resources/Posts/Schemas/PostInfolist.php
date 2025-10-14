<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                ImageEntry::make('image')
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('body')
                    ->columnSpanFull(),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('is_published')
                    ->boolean(),
                IconEntry::make('is_featured')
                    ->boolean(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Post $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
