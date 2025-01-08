<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenTrabajoResource\Pages;
use App\Models\OrdenTrabajo;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Facades\Auth;

class OrdenTrabajoResource extends Resource
{
    protected static ?string $model = OrdenTrabajo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Configuración del formulario
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('solicitante')
                ->label('Solicitante')
                ->default(fn () => Auth::check() ? Auth::user()->name : null)
                ->required(),
            Forms\Components\Select::make('asignadoA')
                ->label('Destinatariosssssssssssssssssssssssss')
                ->options(\App\Models\User::pluck('name', 'id'))
                ->searchable()
                ->required(),
            Forms\Components\Select::make('equipo_id')
                ->label('Equipo')
                ->options(\App\Models\Equipo::pluck('codEquipo', 'id'))
                ->searchable()
                ->required(),
            Forms\Components\DatePicker::make('fechaNecesidad')
                ->label('Fecha de Necesidad')
                ->required(),
            Forms\Components\Select::make('prioridad')
                ->label('Prioridad')
                ->options(['alta' => 'Alta', 'media' => 'Media', 'baja' => 'Baja'])
                ->required(),
            Forms\Components\Textarea::make('det1')
                ->label('Detalles')
                ->maxLength(500),
            Forms\Components\Hidden::make('estado')
                ->default('Abierta'),
        ]);
    }

    // Configuración de la tabla
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Nº de Orden'),
                Tables\Columns\TextColumn::make('solicitante')->label('Solicitante/Receptor'),
                Tables\Columns\TextColumn::make('estado')->label('Estado'),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de Apertura')->date(),
                Tables\Columns\TextColumn::make('updated_at')->label('Fecha de Cierre')->date(),
            ])
            ->actions([
                Tables\Actions\Action::make('abrir')
                    ->label('Abrir Orden')
                    ->action(fn (OrdenTrabajo $record) => self::abrirOrden($record))
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('cerrar')
                    ->label('Cerrar Orden')
                    ->form([
                        Forms\Components\Textarea::make('det2')
                            ->label('Detalles del Trabajo Realizado')
                            ->required()
                            ->maxLength(500),
                        Forms\Components\Textarea::make('det3')
                            ->label('Observaciones')
                            ->maxLength(500),
                    ])
                    ->action(fn (OrdenTrabajo $record, array $data) => self::cerrarOrden($record, $data))
                    ->requiresConfirmation(),
            ])
            ->bulkActions([]);
    }

    // Método para abrir una orden de trabajo
    public static function abrirOrden(OrdenTrabajo $ordenTrabajo)
    {
        $ordenTrabajo->update([
            'estado' => 'Abierta',
        ]);
    }

    // Método para cerrar una orden de trabajo
    public static function cerrarOrden(OrdenTrabajo $ordenTrabajo, array $data)
    {
        $ordenTrabajo->update([
            'estado' => 'Cerrada',
            'fechaEntrega' => now(),
            'aprobadoPor' => Auth::user()->name,
            'det2' => $data['det2'],
            'det3' => $data['det3'],
        ]);
    }

    // Métodos adicionales relacionados con equipos
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrdenTrabajos::route('/'),
            'create' => Pages\CreateOrdenTrabajo::route('/create'),
            'edit' => Pages\EditOrdenTrabajo::route('/{record}/edit'),
        ];
    }
}
