<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Main Content')->schema(
                    [
                        TextInput::make('title')
                            ->live()
                            ->required()->minLength(1)->maxLength(150)
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                if ($operation === 'edit') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord: true)->maxLength(150),
                        RichEditor::make('body')
                            ->required()
                            ->extraInputAttributes(['style'=>'min-height: 20rem; max-height: 50vh; overflow-y: auto'])
                            ->fileAttachmentsDirectory('posts/images')->columnSpanFull(),
                        TextInput::make('meta_title'),
                        TextInput::make('meta_description'),
                    ]
                )->columns(2),
                Section::make('Meta')->schema(
                    [
                        FileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->directory('posts/thumbnails')
                            ->visibility('public'),
                        Repeater::make('videos_uploader')
                            ->label('Videos')
                            ->schema([
                                Hidden::make('id'),
                                FileUpload::make('path')
                                    ->required()
                                    ->disk('public')
                                    ->directory('videos')
                                    ->visibility('public'),
                                TextInput::make('title')
                                    ->label('Video Title'),
                            ])
                            ->dehydrated(false) // IMPORTANT: This tells Filament not to try and save this to the 'posts' table directly
                            ->columnSpanFull(),
                        DateTimePicker::make('published_at')->nullable(),
                        Checkbox::make('is_featured'),
                        Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->searchable(),
                    ]
                ),
            ]);
    }
}
