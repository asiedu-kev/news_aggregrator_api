<?php

namespace App\Filament\Resources\PreferenceResource\Pages;

use App\Filament\Resources\PreferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPreferences extends ListRecords
{
    protected static string $resource = PreferenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
