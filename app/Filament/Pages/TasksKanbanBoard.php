<?php

namespace App\Filament\Pages;

use App\Models\Task;
use App\Enums\TaskStatus;
use Filament\Actions\CreateAction;

use function Laravel\Prompts\text;
use Illuminate\Support\Collection;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class TasksKanbanBoard extends KanbanBoard
{

    protected static ?string $navigationGroup = 'Agendas e Tarefas';
    protected static ?string $title = 'Minhas Atividades';
    protected static ?string $navigationLabel = 'Quadro Kanban';
    protected static ?string $navigationIcon = 'fas-list-check';
    protected static ?int $navigationSort = 5;
    protected static string $recordTitleAttribute = 'title';
    protected static string $recordStatusAttribute = 'status';

    protected static string $model = Task::class;
    protected static string $statusEnum = TaskStatus::class;


    protected function statuses(): Collection
    {
        return TaskStatus::statuses();
    }

    protected function records(): Collection
    {
        return Task::ordered()->get();
    }

    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
                    TextInput::make('title'),
                    TextInput::make('project'),
                    Textarea::make('description'),
                    DatePicker::make('due_date'),
        ];
    }

    protected function getEditModalRecordData($recordId, $data): array
    {
        return Task::find($recordId)->toArray();
    }

    protected function editRecord($recordId, array $data, array $state): void
    {
        Task::find($recordId)->update([

            "title" => $data['title'],
            "project" => $data['project'],
            "description" => $data['description'],
            "due_date" => $data['due_date'],

        ]);
    }

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()
                ->model(Task::class)
                ->form([
                    TextInput::make('company'),
                    TextInput::make('title'),
                    TextInput::make('project'),
                    Textarea::make('description'),
                    DatePicker::make('due_date'),
                ])
        ];
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        Task::find($recordId)->update(['status' => $status]);
        Task::setNewOrder($toOrderedIds);
    }

    public function onSortChanged(int $recordId, string $status, array $orderedIds): void
    {
        Task::setNewOrder($orderedIds);
    }

}

