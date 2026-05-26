<?php

namespace App\Filament\Resources\Sizes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SizeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Назва')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label('Тип зображення / розділ')
                    ->options([
                        'frame' => 'Креслення рамок (Розміри рамок)',
                        'set' => 'Варіанти наборів (Комплектації)',
                        'price_image' => 'Ціни та склад комплектів (Таблиці)',
                    ])
                    ->required()
                    ->live(),

                Textarea::make('description')
                    ->label('Опис')
                    ->helperText('Використовується лише для креслень рамок.')
                    ->visible(fn (callable $get) => $get('type') === 'frame')
                    ->maxLength(500),

                FileUpload::make('image')
                    ->label('Зображення')
                    ->disk('public')
                    ->directory('sizes')
                    ->image()
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
