<!-- resources/views/filament/equipos/repuestos-modal.blade.php -->
<div>
    <!-- Órdenes Abiertas -->
    <h2 class="text-lg font-bold mb-4">Órdenes Abiertas</h2>
    @if($ordenes->isEmpty())
        <p>No hay órdenes abiertas para este equipo.</p>
    @else
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Solicitante</th>
                    <th class="border border-gray-300 px-4 py-2">Fecha Necesidad</th>
                    <th class="border border-gray-300 px-4 py-2">Prioridad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordenes as $orden)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $orden->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $orden->solicitante }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $orden->fechaNecesidad }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $orden->prioridad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


</div>
