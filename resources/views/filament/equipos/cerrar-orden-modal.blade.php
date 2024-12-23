<div>
    <h3>Órdenes Abiertas para el Equipo: {{ $equipo->codEquipo ?? 'No disponible' }}</h3>

    {{-- Verificar si la variable $ordenesAbiertas está llegando correctamente --}}
    <p>Variable 'ordenesAbiertas' (debug):</p>
    <pre>{{ var_dump($ordenesAbiertas) }}</pre>

    {{-- Verifica si hay órdenes abiertas para el equipo --}}
    @if($ordenesAbiertas && $ordenesAbiertas->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Orden de Trabajo</th>
                    <th>Solicitante</th>
                    <th>Fecha Necesidad</th>
                    <th>Prioridad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordenesAbiertas as $orden)
                    <tr>
                        <td>{{ $orden->id }}</td>
                        <td>{{ $orden->solicitante }}</td>
                        <td>{{ $orden->fechaNecesidad }}</td>
                        <td>{{ ucfirst($orden->prioridad) }}</td>
                        <td>
                            <button wire:click="cerrarOrden({{ $orden->id }})" class="btn btn-danger">Cerrar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay órdenes abiertas para este equipo.</p>
    @endif
</div>
