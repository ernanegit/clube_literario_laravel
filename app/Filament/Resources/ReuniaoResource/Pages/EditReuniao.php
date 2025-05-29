<?php

namespace App\Filament\Resources\ReuniaoResource\Pages;

use App\Filament\Resources\ReuniaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditReuniao extends EditRecord
{
    protected static string $resource = ReuniaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Reunião atualizada!')
            ->body('A reunião foi atualizada com sucesso.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}