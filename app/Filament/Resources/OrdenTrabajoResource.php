<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenTrabajoResource\Pages;
use App\Filament\Resources\OrdenTrabajoResource\RelationManagers;
use App\Models\OrdenTrabajo;
use App\Models\Equipo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\LinkColumn;


use Illuminate\Support\Facades\Auth;



class OrdenTrabajoResource extends Resource
{
    protected static ?string $model = OrdenTrabajo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    

    public static function form(Form $form): Form
{
    return $form->schema(function () {

        // Verificamos si estamos en el modo de edición
        if (request()->routeIs('filament.admin.resources.orden-trabajos.edit')) {

            // Obtenemos el ID del registro desde la ruta
            $ordenTrabajoId = request()->route('record');
            
            // Obtenemos el objeto completo de OrdenTrabajo
            $ordenTrabajo = OrdenTrabajo::find($ordenTrabajoId);

            // Verificamos si el estado es "Cerrada"
            if ($ordenTrabajo && $ordenTrabajo->estado === 'Cerrada') {
                // Si está cerrada, deshabilitamos todos los campos
                return [
                    Forms\Components\TextInput::make('aprobadoPor')
                        ->label('Aprobado Por')
                        ->disabled(), // Deshabilitar campo
                    Forms\Components\DatePicker::make('fechaEntrega')
                        ->label('Fecha de Entrega')
                        ->disabled(), // Deshabilitar campo
                    Forms\Components\Textarea::make('realizadoPor')
                        ->label('Realizado Por')
                        ->maxLength(500)
                        ->disabled(), // Deshabilitar campo
                    Forms\Components\DatePicker::make('fechaAprobado')
                        ->label('Fecha de Aprobación')
                        ->disabled(), // Deshabilitar campo
                    Forms\Components\Textarea::make('det2')
                        ->label('Detalle Adicional 2')
                        ->maxLength(500)
                        ->disabled(), // Deshabilitar campo
                    Forms\Components\Textarea::make('det3')
                        ->label('Detalle Adicional 3')
                        ->maxLength(500)
                        ->disabled(), // Deshabilitar campo
                    Forms\Components\Select::make('estado')
                        ->label('Estado')
                        ->options(['Cerrada' => 'Cerrada'])
                        ->default('Cerrada')
                        ->disabled(), // Deshabilitar campo
                ];
            }

            // Verificamos si el estado es "Abierta"
            if ($ordenTrabajo && $ordenTrabajo->estado === 'Abierta') {
                // Si está abierta, mantenemos los campos editables
                return [
                    Forms\Components\TextInput::make('aprobadoPor')
                        ->label('Aprobado Por')
                        ->required(),
                    Forms\Components\DatePicker::make('fechaEntrega')
                        ->label('Fecha de Entrega'),
                    Forms\Components\Textarea::make('realizadoPor')
                        ->label('Realizado Por')
                        ->maxLength(500),
                    Forms\Components\DatePicker::make('fechaAprobado')
                        ->label('Fecha de Aprobación'),
                    Forms\Components\Textarea::make('det2')
                        ->label('Detalle Adicional 2')
                        ->maxLength(500),
                    Forms\Components\Textarea::make('det3')
                        ->label('Detalle Adicional 3')
                        ->maxLength(500),
                    Forms\Components\Select::make('estado')
                        ->label('Estado')
                        ->options(['Abierta' => 'Abierta', 'Cerrada' => 'Cerrada'])
                        ->default('Abierta')
                        ->required(),
                ];
            }

            // Si el estado no es "Abierta" ni "Cerrada" (por alguna razón)
            return [];
        } else {
            // Campos editables solo en modo creación
            return [
                Forms\Components\TextInput::make('solicitante')
                    ->label('Solicitante')
                    ->default(Auth::user()->name)
                    ->required()
                    ->disabled(),
                Forms\Components\Select::make('asignadoA')
                    ->label('Destinatario')
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
                    ->options([
                        'alta' => 'Alta',
                        'media' => 'Media',
                        'baja' => 'Baja',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('det1')
                    ->label('Detalles')
                    ->maxLength(500),
                Forms\Components\Hidden::make('estado')
                    ->default('Abierta'), // Campo oculto para modo creación
            ];
        }
    });
}



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Usamos TextColumn y agregamos el enlace manualmente
                TextColumn::make('id')
                    ->label('Nº de Orden')
                    ->getStateUsing(fn (OrdenTrabajo $record) => "<a href='" . route('ordentrabajo.show', $record->id) . "'>O.d.T-{$record->id}</a>")
                    ->html(), // Esto permite que el estado sea interpretado como HTML

                TextColumn::make('solicitante')
                    ->label('Solicitante/Receptor'),

                TextColumn::make('created_at')
                    ->label('Fecha de apertura')
                    ->date('d/m/Y'), // Formato de fecha

                TextColumn::make('estado')
                    ->label('Estado'),

                TextColumn::make('updated_at')
                    ->label('Fecha de cierre')
                    ->date('d/m/Y'), // Formato de fecha
            ])
            ->filters([
                // Puedes agregar filtros aquí si lo necesitas
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ // Agrupamos las acciones para eliminar
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Aquí puedes definir relaciones si las tienes
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrdenTrabajos::route('/'),
            'create' => Pages\CreateOrdenTrabajo::route('/create'),
            'edit' => Pages\EditOrdenTrabajo::route('/{record}/edit'),
        ];
    }

    // Personalización del breadcrumb
  
    public static function getBreadcrumb(): string
    {
        return 'Gestión de Órdenes de Trabajo';
    }
   
}
