<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nombre del Repuesto
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Código
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Cantidad
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Unidad
                </th>
            </tr>
        </thead>
        <tbody class="bg-gray divide-y divide-gray-200">
            @foreach ($repuestos as $repuesto)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-black text-xs">{{ $repuesto->descripcion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-black text-xs">{{ $repuesto->codigo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-black text-xs">{{ $repuesto->pivot->cant }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-black text-xs">{{ $repuesto->pivot->unidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

