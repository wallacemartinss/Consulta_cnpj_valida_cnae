<?php

namespace App\Filament\Resources\PermittedActivitieResource\Pages;

use App\Filament\Resources\PermittedActivitieResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePermittedActivities extends ManageRecords
{
    protected static string $resource = PermittedActivitieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
