<?php

namespace App\Forms\Components;


use Filament\Forms\Components\TextInput;

class UserPostalCode extends TextInput
{

    public function viaCep(): static
    {
    
        $this
            ->mask('99999-999')
            ->minLength(9);
        return $this;

    }


}
