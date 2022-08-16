<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CatastroArchivo as cArchivo;
use App\Http\Traits\ComponentesTrait;

class CatastroArchivo extends Component
{
    use WithPagination;
    use ComponentesTrait;

    public $estado;
    public $tomo;
    public $localidad;
    public $oficina = 101;
    public $tipo;
    public $registro;
    public $folio;
    public $tarjeta;

    protected function rules(){
        return [
            'tomo' => 'sometimes',
            'localidad' => 'required|in:1,2,3,4,5,6,7',
            'oficina' => 'required',
            'tipo' => 'required|in:1,2',
            'registro' => 'required|numeric',
            'folio' => 'required|numeric',
            'tarjeta' => 'required|in:0,1',
         ];
    }

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'crear', 'editar', 'modal', 'estado', 'tomo', 'localidad', 'oficina', 'tipo', 'registro', 'folio', 'tarjeta']);
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
        $this->localidad = $modelo['localidad'];
        $this->oficina = $modelo['oficina'];
        $this->tipo = $modelo['tipo'];
        $this->registro = $modelo['registro'];
        $this->folio = $modelo['folio'];
        $this->tarjeta = $modelo['tarjeta'];

    }

    public function crear(){

        $this->validate();

        try {

            $archivo = cArchivo::create([
                'estado' => 'disponible',
                'tomo' => $this->tomo,
                'localidad' => $this->localidad,
                'oficina' => $this->oficina,
                'tipo' => $this->tipo,
                'registro' => $this->registro,
                'folio' => $this->folio,
                'tarjeta' => $this->tarjeta,
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

            $archivo = cArchivo::find($this->selected_id);

            $archivo->update([
                'estado' => $this->estado,
                'tomo' => $this->tomo,
                'localidad' => $this->localidad,
                'oficina' => $this->oficina,
                'tipo' => $this->tipo,
                'registro' => $this->registro,
                'folio' => $this->folio,
                'tarjeta' => $this->tarjeta,
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

            $archivo = cArchivo::find($this->selected_id);

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

        $archivos = cArchivo::where('estado', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tomo', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('localidad', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('oficina', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tipo', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('registro', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('folio', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tarjeta', 'LIKE', '%' . $this->search . '%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);

        return view('livewire.admin.catastro-archivo', compact('archivos'))->extends('layouts.admin');

    }
}
