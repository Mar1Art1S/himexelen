<?php

namespace App\Filament\Resources\Instructions;

use App\Filament\Resources\Instructions\Pages\CreateInstruction;
use App\Filament\Resources\Instructions\Pages\EditInstruction;
use App\Filament\Resources\Instructions\Pages\ListInstructions;
use App\Filament\Resources\Instructions\Schemas\InstructionForm;
use App\Filament\Resources\Instructions\Tables\InstructionsTable;
use App\Models\Instruction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InstructionResource extends Resource
{
    protected static ?string $model = Instruction::class;

    protected static ?string $navigationLabel = 'PDF Інструкції';

    protected static ?string $pluralLabel = 'PDF Інструкції';

    protected static ?string $modelLabel = 'Інструкція';

    protected static string|\UnitEnum|null $navigationGroup = 'Керування контентом';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    public static function form(Schema $schema): Schema
    {
        return InstructionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstructionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInstructions::route('/'),
            'create' => CreateInstruction::route('/create'),
            'edit' => EditInstruction::route('/{record}/edit'),
        ];
    }
}
