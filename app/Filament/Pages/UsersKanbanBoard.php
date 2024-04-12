<?php

namespace App\Filament\Pages;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class UsersKanbanBoard extends KanbanBoard
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Usuários e Segurança';
    protected static ?string $title = 'Usuários do Kanban';
    protected static ?string $navigationLabel = 'Usuários do Kanban';
    
    protected static ?int $navigationSort = 4;


    protected static string $model = User::class;
    protected static string $statusEnum = UserStatus::class;

    protected static string $recordTitleAttribute = "name";
    protected static string $recordStatusAttribute = 'status';

    protected function statuses(): Collection
    {
        return UserStatus::statuses();
    }

    protected function records(): Collection
    {
        return User::ordered()->get();

    }
}

