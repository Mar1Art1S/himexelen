<?php

namespace App\Filament\Resources\ProductComplectations\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductComplectationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_category_id')
                    ->relationship('productCategory', 'name')
                    ->label('Категорія продукту')
                    ->required(),

                TextInput::make('name')
                    ->label('Назва комплектації')
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('Ціна комплекту (грн)')
                    ->numeric()
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Textarea::make('description')
                    ->label('Опис комплекту (текстом)')
                    ->rows(3)
                    ->maxLength(65535)
                    ->helperText('Введіть текстовий опис комплектації. Наприклад: Дно (1 шт), Корпус 145 (4 шт), Криша (1 шт)'),

                Repeater::make('components')
                    ->label('Склад комплекту (для розрахунків)')
                    ->schema([
                        TextInput::make('name')
                            ->label('Назва комплектуючого')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('qty')
                            ->label('Кількість')
                            ->required()
                            ->maxLength(50),

                        TextInput::make('unit')
                            ->label('Одиниця виміру')
                            ->default('шт')
                            ->required()
                            ->maxLength(50),
                    ])
                    ->columns(3)
                    ->default([])
                    ->required()
                    ->helperText('Додайте всі деталі, які входять до цієї комплектації, з відповідними кількостями.'),
            ]);
    }
}
