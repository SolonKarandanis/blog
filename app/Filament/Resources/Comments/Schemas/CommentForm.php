<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('post_id')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                Textarea::make('body')
                    ->columnSpanFull(),
            ]);
    }
}
