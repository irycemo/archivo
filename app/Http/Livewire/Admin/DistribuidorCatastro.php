<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;
use App\Models\CatastroArchivoSolicitud;

class DistribuidorCatastro extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $surtidor_id;

    protected function rules(){
        return [
            'surtidor_id' => 'required',
         ];
    }

    protected $validationAttributes  = [
        'surtidor_id' => 'surtidor'
    ];

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'crear', 'editar', 'modal', 'surtidor_id']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrirModal($id){
        $this->resetearTodo();
        $this->modal = true;
        $this->selected_id = $id;
    }

    public function asignar(){

        $this->validate();

        try {

            $archivosSolicitados = CatastroArchivoSolicitud::findorFail($this->selected_id);

            $archivosSolicitados->update([
                'surtidor' => $this->surtidor_id,
                'actualizado_por' => auth()->user()->id
            ]);

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Se hizo la asignación con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al asignar archivo id: " . $archivosSolicitados->id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }


    public function render()
    {

        $surtidores = User::whereHas('roles', function($q){
                                $q->where('name', 'Surtidor')
                                    ->where('localidad', 'Catastro');
                            })->get();

        if(auth()->user()->hasRole('Surtidor')){
            $archivosSolicitados = CatastroArchivoSolicitud::with('archivo', 'solicitud', 'repartidor')
                                    ->whereHas('archivo', function($q) {
                                        $q->where('estado', 'solicitado')
                                                ->orderBy('registro', $this->direction);
                                    })
                                    ->whereHas('solicitud', function($q){
                                        $q->where('estado', 'nueva');
                                    })
                                    ->where('surtidor', auth()->user()->id)
                                    ->when($this->sort != 'registro', function($q){
                                        $q->orderBy($this->sort, $this->direction);
                                    })
                                    ->paginate($this->pagination);

        }else{
            $archivosSolicitados = CatastroArchivoSolicitud::with('archivo', 'solicitud', 'repartidor')
                                    ->whereHas('archivo', function($q) {
                                        $q->where('estado', 'solicitado')
                                                ->orderBy('registro', $this->direction);
                                    })
                                    ->whereHas('solicitud', function($q){
                                        $q->where('estado', 'nueva');
                                    })
                                    ->when($this->sort != 'registro', function($q){
                                        $q->orderBy($this->sort, $this->direction);
                                    })
                                    ->paginate($this->pagination);
        }

        return view('livewire.admin.distribuidor-catastro', compact('archivosSolicitados', 'surtidores'))->extends('layouts.admin');
    }
}
