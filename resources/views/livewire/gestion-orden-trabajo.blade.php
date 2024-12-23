<div>
    <!-- Mostrar mensaje de éxito -->
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <!-- Botón para abrir el modal de selección de orden -->
    <button wire:click="abrirModal" class="btn btn-primary">
        Seleccionar Orden para Cerrar
    </button>

    <!-- Modal para seleccionar la orden de trabajo -->
    @if($modalAbierto)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Seleccionar Orden de Trabajo</h5>
                        <button wire:click="$set('modalAbierto', false)" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Listado de órdenes abiertas -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Orden</th>
                                    <th>Fecha de Creación</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordenesAbiertas as $orden)
                                    <tr>
                                        <td>{{ $orden->id }}</td>
                                        <td>{{ $orden->descripcion }}</td>
                                        <td>{{ $orden->fecha_creacion }}</td>
                                        <td>
                                            <button wire:click="seleccionarOrden({{ $orden->id }})" class="btn btn-success">
                                                Seleccionar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="$set('modalAbierto', false)" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulario para cerrar la orden -->
    @if($ordenSeleccionada)
        <div class="card mt-3">
            <div class="card-header">
                Cerrar Orden de Trabajo
            </div>
            <div class="card-body">
                <form wire:submit.prevent="cerrarOrden">
                    <div class="form-group">
                        <label for="fecha_entrega">Fecha de Entrega</label>
                        <input type="date" wire:model="ordenSeleccionada.fecha_entrega" class="form-control @error('ordenSeleccionada.fecha_entrega') is-invalid @enderror">
                        @error('ordenSeleccionada.fecha_entrega') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="asignado_a">Asignado A</label>
                        <select wire:model="ordenSeleccionada.asignado_a" class="form-control @error('ordenSeleccionada.asignado_a') is-invalid @enderror">
                            <option value="">Seleccione un usuario</option>
                            @foreach(App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('ordenSeleccionada.asignado_a') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" value="cerrada" class="form-control" disabled>
                    </div>

                    <button type="submit" class="btn btn-danger">Cerrar Orden</button>
                </form>
            </div>
        </div>
    @endif
</div>
