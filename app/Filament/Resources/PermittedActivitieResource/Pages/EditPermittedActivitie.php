<?php

namespace App\Filament\Resources\PermittedActivitieResource\Pages;

use App\Filament\Resources\PermittedActivitieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermittedActivitie extends EditRecord
{
    protected static string $resource = PermittedActivitieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
