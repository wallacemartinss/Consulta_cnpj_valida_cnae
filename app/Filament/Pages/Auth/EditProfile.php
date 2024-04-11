<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }
    public function getFormActionsAlignment(): string | Alignment
    {
        return Alignment::Right;
    }
    public function form(Form $form): Form
    {
        return $form
            
            ->schema([
                Section::make('Informações Pessoais')
                    ->aside()
                    ->schema([
                        Document::make('document_number')
                            ->label('CPF ou CNPJ')
                            ->dynamic()
                            ->disabled(true)
                            ->required(),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getUserPostalCodeFormComponent(),
                       
                    ])
            ]);
    }
    protected function getUserPostalCodeFormComponent(): Component
    {
        return Fieldset::make('Endereço')
            ->relationship('user_address')
            ->schema([
                Cep::make('zip_code')
                    ->label('CEP')
                    ->viaCep(
                        mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                        errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.
                        setFields: [
                            'street' => 'logradouro',
                            'number' => 'numero',
                            'complement' => 'complemento',
                            'district' => 'bairro',
                            'city' => 'localidade',
                            'state' => 'uf'
                        ]
                    ),
                TextInput::make('street')
                    ->label('Endereço')
                    ->required(),

                TextInput::make('number')
                    ->label('Número')
                    ->required(),
                TextInput::make('district')
                    ->label('Bairro')
                    ->required(),
                TextInput::make('city')
                    ->label('Cidade')
                    ->required(),
                TextInput::make('state')
                    ->label('Estado')
                    ->required(),
                TextInput::make('complement')
                    ->label('Complemento'),
                TextInput::make('reference')
                    ->label('Referência'),

            ]);
    }
}
