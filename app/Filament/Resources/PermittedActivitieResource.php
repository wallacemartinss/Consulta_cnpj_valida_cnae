<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermittedActivitieResource\Pages;
use App\Filament\Resources\PermittedActivitieResource\RelationManagers;
use App\Models\PermittedActivitie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;



class PermittedActivitieResource extends Resource
{
    protected static ?string $model = PermittedActivitie::class;
    protected static ?string $navigationIcon = 'fas-file-circle-check';
    protected static ?string $navigationGroup = 'Empresas e Atividades';
    protected static ?string $navigationLabel = 'Atividades Anexo IV';
    protected static ?string $modelLabel = 'Atividade Anexo IV';
    protected static ?string $modelLabelPlural = "Atividades Anexo IV";
    protected static ?int $navigationSort = 2;
    public static bool $formActionsAreSticky = true;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Cod. CNAE')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição CNAE')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Cod. CNAE')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição CNAE')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePermittedActivities::route('/'),
        ];
    }
}
