<?php

namespace App\Filament\Resources\PermittedActivitieResource\Pages;

use App\Filament\Resources\PermittedActivitieResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePermittedActivitie extends CreateRecord
{
    protected static string $resource = PermittedActivitieResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
