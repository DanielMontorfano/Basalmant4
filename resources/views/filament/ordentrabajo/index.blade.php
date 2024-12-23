@extends('filament::page')

@section('title', 'Órdenes de Trabajo')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Listado de Órdenes de Trabajo</h2>
        <x-filament::button href="{{ route('ordentrabajo.create') }}">
            Crear Nueva Orden
        </x-filament::button>
    </div>

    <x-filament::card>
        <x-tables::table>
            <x-slot name="thead">
                <x-tables::header-cell> Nº de Orden </x-tables::header-cell>
                <x-tables::header-cell> Solicitante/Receptor </x-tables::header-cell>
                <x-tables::header-cell> Fecha de Apertura </x-tables::header-cell>
                <x-tables::header-cell> Estado </x-tables::header-cell>
                <x-tables::header-cell> Fecha de Cierre </x-tables::header-cell>
                <x-tables::header-cell> Acciones </x-tables::header-cell>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($ordenes as $ot)
                    <x-tables::row>
                        <x-tables::cell>
                            <a href="{{ route('ordentrabajo.show', $ot->id) }}">O.d.T-{{$ot->id}}</a>
                        </x-tables::cell>
                        <x-tables::cell>
                            {{ $ot->solicitante }} / {{ $ot->asignadoA }}
                        </x-tables::cell>
                        <x-tables::cell>
                            {{ $ot->created_at->format('d-m-Y') }}
                        </x-tables::cell>
                        <x-tables::cell>
                            {{ $ot->estado }}
                        </x-tables::cell>
                        <x-tables::cell>
                            {{ $ot->updated_at->format('d-m-Y') }}
                        </x-tables::cell>
                        <x-tables::cell>
                            <x-filament::button 
                                icon="heroicon-o-eye" 
                                href="{{ route('ordentrabajo.show', $ot->id) }}">
                                Ver
                            </x-filament::button>
                        </x-tables::cell>
                    </x-tables::row>
                @endforeach
            </x-slot>
        </x-tables::table>
    </x-filament::card>
    
    {{ $ordenes->links() }} <!-- Paginación si es necesario -->
@endsection
