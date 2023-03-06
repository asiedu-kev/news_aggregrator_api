<?php

namespace App\Filament\Resources\PreferenceResource\Pages;

use App\Filament\Resources\PreferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPreference extends ViewRecord
{
    protected static string $resource = PreferenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
