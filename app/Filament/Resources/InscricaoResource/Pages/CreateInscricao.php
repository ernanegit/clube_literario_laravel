<?php

namespace App\Filament\Resources\InscricaoResource\Pages;

use App\Filament\Resources\InscricaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateInscricao extends CreateRecord
{
    protected static string $resource = InscricaoResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Inscrição criada!')
            ->body('A inscrição foi realizada com sucesso.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}