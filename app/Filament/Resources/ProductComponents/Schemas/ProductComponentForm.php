<?php

namespace App\Filament\Resources\ProductComponents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductComponentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_category_id')
                    ->relationship('productCategory', 'name')
                    ->label('Категорія продукту')
                    ->nullable(),

                TextInput::make('name')
                    ->label('Назва комплектуючого')
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('Ціна комплектуючого (грн)')
                    ->numeric()
                    ->required(),

                Select::make('group')
                    ->label('Група розміру (рамковість)')
                    ->options([
                        '8' => '8-рамковий',
                        '10' => '10-рамковий',
                        '12' => '12-рамковий',
                        'інше' => 'інше',
                    ])
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
