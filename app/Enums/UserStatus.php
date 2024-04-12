<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum UserStatus: string
{
    use IsKanbanStatus;

    case Pendente = 'Pending';
    case Ativo = 'Active';
    case Inativo = 'Inactive';

    public static function kanbanCases(): array
    {
        return [
            static::Pendente,
            static::Ativo,
            static::Inativo,
        ];
    }

    public function getTitle(): string
    {
        return $this->name;
    }
}