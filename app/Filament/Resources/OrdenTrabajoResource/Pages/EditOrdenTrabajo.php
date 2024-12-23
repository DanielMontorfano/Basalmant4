<?php

namespace App\Filament\Resources\OrdenTrabajoResource\Pages;

use App\Filament\Resources\OrdenTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;




class EditOrdenTrabajo extends EditRecord
{
    protected static string $resource = OrdenTrabajoResource::class;
    
   
    

      protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getTitle(): string
{
    return $this->record
        ? 'Editar Orden de Trabajo: ' . $this->record->id
        : 'Editar Orden de Trabajo';
}



}