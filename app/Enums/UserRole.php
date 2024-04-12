<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum UserRole: string
{
    use IsKanbanStatus;

    case Usuário = 'user';
    case Administrador = 'admin';

    public function getTitle(): string
    {
        return $this->name;
    }
}