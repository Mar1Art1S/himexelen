<?php

namespace App\Filament\Resources\VideoCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class VideoCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Назва категорії')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                TextInput::make('slug')
                    ->label('Slug (посилання)')
                    ->required()
                    ->unique('video_categories', 'slug', ignoreRecord: true)
                    ->maxLength(255),

                Select::make('type')
                    ->label('Тип відео')
                    ->options([
                        'general' => 'Вкладка "Відео" (Загальні огляди)',
                        'assembly' => 'Вкладка "Інструкція" (Відео збірки)',
                    ])
                    ->default('assembly')
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
