<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Resources\UserResource\Pages;
use Leandrocfe\FilamentPtbrFormFields\Document;


class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'fas-users';
    protected static ?string $navigationGroup = 'Usuários e Segurança';
    protected static ?string $navigationLabel = 'Cadastro de Usuários';
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $modelLabelPlural = "Usuários";
    protected static ?int $navigationSort = 2;
    public static bool $formActionsAreSticky = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Document::make('document_number')
                    ->label('CPF ou CNPJ')
                    ->dynamic()
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->maxLength(255),
            
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required()
                    ->maxLength(255),

                Select::make('roles')
                    ->label('Permissão')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('document_number')
                    ->label('CPF ou CNPJ')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                ToggleColumn::make('is_admin')
                    ->label('Administrador'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
