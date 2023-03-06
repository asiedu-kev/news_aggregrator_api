<?php

namespace App\Filament\Resources\PreferenceResource\Pages;

use App\Filament\Resources\PreferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPreference extends EditRecord
{
    protected static string $resource = PreferenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
