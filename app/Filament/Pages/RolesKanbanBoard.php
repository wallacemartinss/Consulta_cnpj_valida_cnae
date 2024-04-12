<?php

namespace App\Filament\Pages;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class RolesKanbanBoard extends KanbanBoard
{
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Usuários e Segurança';
    protected static ?string $title = 'Funções do Kanban';
    protected static ?string $navigationLabel = 'Funções do Kanban';
    protected static ?int $navigationSort = 3;

      
    protected static string $statusEnum = UserRole::class;
    protected static string $model = User::class;

    protected static string $recordTitleAttribute = 'name';
    protected static string $recordStatusAttribute = 'role';
  

    protected function statuses(): Collection
    {
        return UserRole::statuses();
    }
    protected function records(): Collection
    {
        return User::where('status', UserStatus::Ativo)->ordered()->get();
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        User::find($recordId)->update(['role' => $status]);
        User::setNewOrder($toOrderedIds);
    }
}