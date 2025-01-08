<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipoResource\Pages;
use App\Filament\Resources\EquipoResource\RelationManagers;
use App\Models\Equipo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;


use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\MaxWidth;

use Filament\Tables\Actions\ActionGroup;

use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Auth;



class EquipoResource extends Resource
{
    protected static ?string $model = Equipo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('idSecc')
                    ->maxLength(191),
                Forms\Components\TextInput::make('idSubSecc')
                    ->maxLength(191),
                Forms\Components\TextInput::make('codEquipo')
                    ->maxLength(191),
                Forms\Components\TextInput::make('marca')
                    ->maxLength(191),
                Forms\Components\TextInput::make('modelo')
                    ->maxLength(191),
                Forms\Components\TextInput::make('det1')
                    ->maxLength(191),
                Forms\Components\TextInput::make('det2')
                    ->maxLength(191),
                Forms\Components\TextInput::make('det3')
                    ->maxLength(191),
                Forms\Components\TextInput::make('det4')
                    ->maxLength(191),
                Forms\Components\TextInput::make('det5')
                    ->maxLength(191),
                Forms\Components\TextInput::make('histEquipo')
                    ->numeric(),
                Forms\Components\TextInput::make('creador')
                    ->maxLength(191),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
          //  Tables\Columns\TextColumn::make('idSecc')
         //       ->searchable(),
          //  Tables\Columns\TextColumn::make('idSubSecc')
        ///        ->searchable(),
           Tables\Columns\TextColumn::make('codEquipo')
               ->searchable(),
            Tables\Columns\TextColumn::make('marca')
                ->searchable(),
            Tables\Columns\TextColumn::make('modelo')
                ->searchable(),
         /*  Tables\Columns\TextColumn::make('det1')
                ->searchable(),
            Tables\Columns\TextColumn::make('det2')
                ->searchable(),
            Tables\Columns\TextColumn::make('det3')
                ->searchable(),
            Tables\Columns\TextColumn::make('det4')*/
         //       ->searchable(),
            Tables\Columns\TextColumn::make('det5')
                ->searchable(),
        /*    Tables\Columns\TextColumn::make('histEquipo')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('creador')
                ->searchable(),
            Tables\Columns\TextColumn::make('slug')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),*/
        ])
        ->filters([
            // Puedes agregar filtros aquí
        ])
        ->actions([
            ActionGroup::make([
                // Opción 0: Editar
                Tables\Actions\EditAction::make()
                    ->label('Editar equipo')
                    ->icon('heroicon-o-pencil')  
                    ->tooltip('Editar el registro'),
        
                // Opción 1: Ver Repuestos
                Action::make('verRepuestos')
                    ->label('Ver repuestos')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Repuestos vinculados al equipo')
                    ->modalWidth('xl')
                    ->modalContent(function ($record) {
                        $repuestos = $record->repuestos; // Relación con los repuestos
                        return view('filament.equipos.repuestos-modal', [
                            'repuestos' => $repuestos,
                        ]);
                    }),
//*********************************************************************************************************** */

Action::make('OrdenDeTrabajo')
    ->label('Abrir y Cerrar orden de trabajo')
    ->icon('heroicon-o-home')
    ->color('success')
    ->tooltip('Crea una orden de trabajo a este equipo')
    ->form([
        Forms\Components\Tabs::make('ordenTrabajoTabs')
            ->tabs([
                Forms\Components\Tabs\Tab::make('Cerrar órdenes')
                    ->schema([
                        // Aquí puedes agregar campos si es necesario
                    ]),

                Forms\Components\Tabs\Tab::make('Listado de órdenes')
                    ->schema([
                        // Aquí puedes agregar campos si es necesario
                    ]),

                Forms\Components\Tabs\Tab::make('Abrir Orden')
                    ->schema([
                        Forms\Components\TextInput::make('solicitante')
                            ->label('Solicitante')
                            ->default(Auth::user()->name)
                            ->required()
                            ->readonly(),
                        Forms\Components\Select::make('asignadoA')
                            ->label('Destinatario')
                            ->options(\App\Models\User::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\DatePicker::make('fechaNecesidad')
                            ->label('Fecha de necesidad')
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
                    ]),
            ]),
    ])
    ->action(function (array $data, $record) { // $record es el equipo actual
        // Obtener el nombre del usuario asignado
         $asignadoNombre = \App\Models\User::find($data['asignadoA'])->name ?? 'Usuario desconocido';

        // Proporcionar valores predeterminados
        $dataToInsert = [
            'equipo_id' => $record->id, // ID del equipo actual
            'solicitante' => $data['solicitante'],
            'asignadoA' => $asignadoNombre, // Guardar el nombre del usuario
            'fechaNecesidad' => $data['fechaNecesidad'],
            'prioridad' => $data['prioridad'],
            'det1' => $data['det1'],
        ];

        // Crear la orden de trabajo
        \App\Models\OrdenTrabajo::create($dataToInsert);

        // Usar notificación de Filament
        return \Filament\Notifications\Notification::make()
            ->title('Orden creada')
            ->body('La orden de trabajo ha sido creada correctamente.')
            ->success()
            ->send();
    }),

    //******************************************************************************************************************** */
                        Action::make('verTodasOrdenes')
                        ->label('Ver todas las Ordenes')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->tooltip('Ver todas las órdenes abiertas') // Tooltip informativo
                        ->url(fn () => route('ordentrabajo.index')) // Redirige a la ruta index de las órdenes de trabajo
                        ->openUrlInNewTab(), // Abre en nueva pestaña (opcional)

        
    
     //********************************************************************************************************** */  
                         // Opción 4: Ver Estadísticas
                Action::make('estadisticas')
                    ->label('Ver Estadísticas')
                    ->icon('heroicon-o-chart-bar')
                    ->color('primary')
                    ->tooltip('Explora los datos y gráficos')
                    ->action(function () {
                        return redirect()->route('estadisticas.index');
                    }),
        
                // Opción 5: Gestión de Usuarios
                Action::make('gestionUsuarios')
                    ->label('Gestión de Usuarios')
                    ->icon('heroicon-o-users')
                    ->color('info')
                    ->tooltip('Administra roles y permisos'),
        
                // Opción 6: Generar Reporte
                Action::make('generarReporte')
                    ->label('Generar Reporte')
                    ->icon('heroicon-o-document-text')
                    ->color('secondary')
                    ->tooltip('Crea informes detallados'),
        
                // Opción 7: Notificaciones
                Action::make('notificaciones')
                    ->label('Notificaciones')
                    ->icon('heroicon-o-bell')
                    ->color('danger')
                    ->tooltip('Revisa alertas importantes'),
        
                // Opción 8: Ajustes Avanzados
                Action::make('ajustesAvanzados')
                    ->label('Ajustes Avanzados')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->color('gray')
                    ->tooltip('Explora opciones avanzadas'),
        
                // Opción 9: Salir
                Action::make('salir')
                    ->label('Salir')
                    ->icon('heroicon-o-arrow-left-on-rectangle')
                    ->color('danger')
                    ->tooltip('Cierra sesión de forma segura'),
            ])
            ->label('Acciones')
            ->icon('heroicon-m-ellipsis-vertical')
            ->size(ActionSize::Small)
            ->color('primary')
            ->button()
            ->dropdownPlacement('bottom-end')
            ->dropdownWidth(MaxWidth::Large)
            ->dropdownOffset(12),
        ])
        
        
        
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipos::route('/'),
            'create' => Pages\CreateEquipo::route('/create'),
            'edit' => Pages\EditEquipo::route('/{record}/edit'),
        ];
    }
}
