<?php

namespace App\Filament\Resources\ReuniaoResource\Pages;

use App\Filament\Resources\ReuniaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateReuniao extends CreateRecord
{
    protected static string $resource = ReuniaoResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Reunião criada!')
            ->body('A reunião foi criada com sucesso.')
            ->duration(5000);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->submit(null)
            ->keyBindings(['mod+s'])
            ->action(function () {
                $this->closeActionModal();
                $this->create();
            });
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Garantir que a data está no formato correto
        if (isset($data['data_reuniao'])) {
            $data['data_reuniao'] = \Carbon\Carbon::parse($data['data_reuniao'])->format('Y-m-d H:i:s');
        }

        return $data;
    }
}