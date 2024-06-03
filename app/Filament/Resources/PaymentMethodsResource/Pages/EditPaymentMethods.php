<?php

namespace App\Filament\Resources\PaymentMethodsResource\Pages;

use App\Filament\Resources\PaymentMethodsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentMethods extends EditRecord
{
    protected static string $resource = PaymentMethodsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        
        if (isset($data['configurations'])) {
            $data['configurations'] = json_encode($data['configurations']);
        }
        return $data;
    }
}
