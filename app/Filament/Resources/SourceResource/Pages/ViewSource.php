<?php

namespace App\Filament\Resources\SourceResource\Pages;

use App\Filament\Resources\SourceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSource extends ViewRecord
{
    protected static string $resource = SourceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
