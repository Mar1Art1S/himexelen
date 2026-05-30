<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Назва відео')
                    ->required()
                    ->maxLength(255),

                TextInput::make('youtube_id')
                    ->label('YouTube ID або URL посилання')
                    ->required()
                    ->helperText('Введіть 11-значний код відео або просто вставте повне посилання з YouTube.')
                    ->dehydrateStateUsing(fn ($state) => static::extractYoutubeId($state)),

                FileUpload::make('image_path')
                    ->label('Обкладинка відео')
                    ->disk('public')
                    ->image()
                    ->directory('videos/thumbnails')
                    ->required()
                    ->helperText('Завантажте зображення для прев’ю відео.'),

                Select::make('video_category_id')
                    ->label('Категорія відображення')
                    ->relationship('category', 'name')
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    /**
     * Extracts the 11-character YouTube video ID from a URL or returns the ID if already valid.
     */
    protected static function extractYoutubeId(?string $state): ?string
    {
        if (blank($state)) {
            return null;
        }

        $state = trim($state);

        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
        if (preg_match($pattern, $state, $matches)) {
            return $matches[1];
        }

        return $state;
    }
}
