<?php

namespace App\Livewire; // Asegúrate de que el namespace sea este

use Livewire\Component;
use App\Models\OrdenTrabajo;
use Illuminate\Support\Facades\Auth;

class GestionOrdenTrabajo extends Component
{
    public $modalAbierto = false;
    public $ordenSeleccionada = null; // Inicializar la variable para evitar errores
    public $ordenesAbiertas = [];

    // Reglas de validación para el formulario
    protected $rules = [
        'ordenSeleccionada.fecha_entrega' => 'required|date',
        'ordenSeleccionada.asignado_a' => 'required|exists:users,id',
        'ordenSeleccionada.estado' => 'required|in:cerrada',
    ];

    // Inicialización de los datos
    public function mount($equipoId)
    {
        // Obtener todas las órdenes abiertas para el equipo seleccionado
        $this->ordenesAbiertas = OrdenTrabajo::where('equipo_id', $equipoId)
            ->where('estado', 'abierta')
            ->get();
    }

    // Abrir el modal
    public function abrirModal()
    {
        $this->modalAbierto = true;
    }

    // Seleccionar una orden y cerrar el modal
    public function seleccionarOrden($ordenId)
    {
        $this->ordenSeleccionada = OrdenTrabajo::find($ordenId);
        $this->modalAbierto = false; // Cerrar el modal al seleccionar
    }

    // Cerrar la orden seleccionada
    public function cerrarOrden()
    {
        // Validar los campos
        $this->validate();

        // Cerrar la orden seleccionada
        $this->ordenSeleccionada->estado = 'cerrada';
        $this->ordenSeleccionada->fecha_entrega = now(); // Fecha de cierre
        $this->ordenSeleccionada->realizado_por = Auth::user()->id; // Guardar el id del usuario que cierra
        $this->ordenSeleccionada->save();

        // Mostrar mensaje de éxito
        session()->flash('message', 'La orden ha sido cerrada exitosamente.');

        // Redirigir a la vista de órdenes
        return redirect()->route('ordenes.index');
    }

    // Método de renderizado para la vista
    public function render()
    {
        return view('livewire.gestion-orden-trabajo');
    }
}
