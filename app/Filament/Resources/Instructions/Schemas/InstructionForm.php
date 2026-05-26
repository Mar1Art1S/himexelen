<?php

namespace App\Filament\Resources\Instructions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InstructionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Назва інструкції')
                    ->required()
                    ->maxLength(255),

                TextInput::make('label')
                    ->label('Мітка комплектації (наприклад: "8 рамок")')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('pdf')
                    ->label('Документ PDF')
                    ->disk('public')
                    ->directory('instructions')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),

                FileUpload::make('image')
                    ->label('Зображення обкладинки')
                    ->disk('public')
                    ->directory('instructions')
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
