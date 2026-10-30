<?php

namespace App\Filament\Resources\VideoSections\Schemas;

use App\Filament\Resources\Videos\Schemas\VideoForm;
use App\Models\VideoCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class VideoSectionForm
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
                    ->dehydrateStateUsing(fn ($state) => VideoForm::extractYoutubeId($state)),

                FileUpload::make('image_path')
                    ->label('Обкладинка відео')
                    ->disk('public')
                    ->image()
                    ->directory('videos/thumbnails')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth('1280')
                    ->imageResizeTargetHeight('720')
                    ->helperText('Необов\'язково. Без обкладинки використовується прев\'ю з YouTube.'),

                Select::make('video_category_id')
                    ->label('Категорія ВІДЕО')
                    ->relationship('category', 'name', fn (Builder $query) => $query->where('type', 'videos'))
                    ->default(fn () => VideoCategory::where('type', 'videos')->orderBy('sort_order')->value('id'))
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
