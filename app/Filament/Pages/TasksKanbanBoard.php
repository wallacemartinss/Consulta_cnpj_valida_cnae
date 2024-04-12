<?php

namespace App\Filament\Pages;

use App\Enums\TaskStatus;
use App\Models\Task;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class TasksKanbanBoard extends KanbanBoard
{

    protected static ?string $navigationGroup = 'Agendas e Tarefas';
    protected static ?string $title = 'Minhas Atividades';
    protected static ?string $navigationLabel = 'Quadro Kanban';
    protected static ?string $navigationIcon = 'fas-list-check';
    protected static ?int $navigationSort = 5;
    protected static string $recordTitleAttribute = 'name';
    protected static string $recordStatusAttribute = 'Tarefas do Kanban';

    protected static string $model = Task::class;

    protected static string $statusEnum = TaskStatus::class;
}