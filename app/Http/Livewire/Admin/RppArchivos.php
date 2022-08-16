<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Constantes;
use App\Models\RppArchivo;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;

class RppArchivos extends Component
{
    use WithPagination;
    use ComponentesTrait;

    public $estado;
    public $tomo;
    public $tomo_bis;
    public $seccion;
    public $distrito;

    protected function rules(){
        return [
            'tomo' => 'required',
            'tomo_bis' => 'sometimes',
            'seccion' => 'required',
            'distrito' => 'required|numeric|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19',
         ];
    }

    protected $validationAttributes  = [
        'seccion' => 'sección',
    ];

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'crear', 'editar', 'modal', 'estado', 'tomo', 'tomo_bis', 'seccion', 'distrito']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrirModalEditar($modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        $this->selected_id = $modelo['id'];
        $this->estado = $modelo['estado'];
        $this->tomo = $modelo['tomo'];
        $this->tomo_bis = $modelo['tomo_bis'];
        $this->seccion = $modelo['seccion'];
        $this->distrito = $modelo['distrito'];
    }

    public function crear(){

        $this->validate();

        try {

            $archivo = RppArchivo::create([
                'estado' => 'disponible',
                'tomo' => $this->tomo,
                'tomo_bis' => $this->tomo_bis,
                'seccion' => $this->seccion,
                'distrito' => $this->distrito,
                'creado_por' => auth()->user()->id
            ]);

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El archivo se creó con éxito."]);

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            $archivo = RppArchivo::find($this->selected_id);

            $archivo->update([
                'estado' => $this->estado,
                'tomo' => $this->tomo,
                'tomo_bis' => $this->tomo_bis,
                'seccion' => $this->seccion,
                'distrito' => $this->distrito,
                'actualizado_por' => auth()->user()->id
            ]);

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El archivo se actualizó con éxito."]);

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $archivo = RppArchivo::find($this->selected_id);

            $archivo->delete();

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El archivo se eliminó con éxito."]);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }
    public function render()
    {

        $secciones = Constantes::SECCIONES;

        $archivos = RppArchivo::where('estado', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tomo', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tomo_bis', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('seccion', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('distrito', 'LIKE', '%' . $this->search . '%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);

        return view('livewire.admin.rpp-archivos', compact('archivos', 'secciones'))->extends('layouts.admin');

    }
}
