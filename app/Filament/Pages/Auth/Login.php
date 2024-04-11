<?php

namespace App\Filament\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as AuthLogin;
use Illuminate\Validation\ValidationException;
use Leandrocfe\FilamentPtbrFormFields\Document;

class Login extends AuthLogin
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getloginFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
    public function getloginFormComponent(): Component
    {
        return Document::make('login')
            ->label('CPF ou CNPJ')
            ->dynamic()
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'document_number' => $data['login'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }


}
