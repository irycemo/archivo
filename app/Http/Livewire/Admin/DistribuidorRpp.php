<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Solicitud;
use App\Models\RppArchivo;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RppArchivoSolicitud;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\ComponentesTrait;

class DistribuidorRpp extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $surtidor_id;
    public $surtidores;
    public $modalCarga = false;

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

    public function abrirModalSurtidor($id){
        $this->resetearTodo();
        $this->modal = true;
        $this->selected_id = $id;
    }

    public function abrirModalCarga(){

        $this->resetearTodo();
        $this->modalCarga = true;

    }

    public function imprimir(){

        $solicitudes = Solicitud::with('archivosRppSolicitados.archivo', 'repartidor')
                                    ->where('surtidor', $this->surtidor_id)
                                    ->where('estado', 'aceptada')
                                    ->get();

        $surtidor = $solicitudes->first()->repartidor->name;

        $pdf = Pdf::loadView('solicitudes.cargaTrabajo', compact(
            'solicitudes',
            'surtidor'
        ))->output();

        return response()->streamDownload(
            fn () => print($pdf),
            'carga_de_trabajo.pdf'
        );

    }

    public function asignar(){

        $this->validate();

        try {

            $solicitud = Solicitud::with('archivosRppSolicitados')->findorFail($this->selected_id);

            $solicitud->update([
                'surtidor' => $this->surtidor_id
            ]);

            foreach($solicitud->archivosRppSolicitados as $archivo){

                $archivo->update(['surtidor' => $solicitud->surtidor]);

            }

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Se hizo la asignación con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al asignar archivo id: " . $solicitud->numero . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar($id){

        try {

            $solicitud = Solicitud::with('archivosRppSolicitados.archivo', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor')->findorFail($id);

            if($solicitud->estado != 'regresada'){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La solicitud aun no ha sido regresada."]);

                return;

            }

            $array = [];

            foreach($solicitud->archivosRppSolicitados as $archivo){

                $array[] = [
                    'tomo' => $archivo->archivo->tomo,
                    'registro' => $archivo->archivo->registro,
                    'seccion' => $archivo->archivo->seccion,
                    'distrito' => $archivo->archivo->distrito,
                    'formacion' => $archivo->archivo->formacion,
                    'asignado_a' => $archivo->asignado_a,
                    'surtidor' => $solicitud->asignado_a,
                    'entregado_por' => $archivo->entregadoPor->name,
                    'entregado_en' => $archivo->entregado_en->format('d-m-Y H:i:s'),
                    'recibido_por' => $archivo->recibidoPor->name,
                    'recibido_en' => $archivo->regresado_en->format('d-m-Y H:i:s'),
                ];

                $archivo->archivo->delete();

            }

            $solicitud->update(['archivos' => json_encode($array)]);

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Se volvieron a poner a disposición los archivos con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al devolver archivos en distribución por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function mount(){

        $this->surtidores = User::whereHas('roles', function($q){
                                        $q->where('name', 'Surtidor RPP')
                                            ->where('localidad', 'RPP');
                                    })->get();

    }

    public function render()
    {

        if(auth()->user()->hasRole('Distribuidor formación RPP')){

            $solicitudes = Solicitud::with('creadoPor', 'repartidor', 'actualizadoPor', 'archivosRppSolicitados.archivo', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor','archivosRppSolicitados.repartidor')
                                    ->withCount('archivosRppSolicitados')
                                    ->whereIn('estado', ['recibida', 'aceptada', 'regresada'])
                                    ->where('formacion', 1)
                                    ->where('ubicacion', 'RPP')
                                    ->where(function($q){
                                        return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('numero', $this->search);
                                    })
                                    ->orderBy($this->sort, $this->direction)
                                    ->paginate($this->pagination);


        }elseif(auth()->user()->hasRole('Distribuidor RPP')){

            $solicitudes = Solicitud::with('creadoPor', 'repartidor', 'actualizadoPor', 'archivosRppSolicitados.archivo', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor','archivosRppSolicitados.repartidor')
                                        ->withCount('archivosRppSolicitados')
                                        ->whereIn('estado', ['recibida', 'aceptada', 'regresada'])
                                        ->where('formacion', false)
                                        ->where('ubicacion', 'RPP')
                                        ->where(function($q){
                                            return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                        ->orWhere('numero', $this->search);
                                        })
                                        ->orderBy($this->sort, $this->direction)
                                        ->paginate($this->pagination);

        }else{

            $solicitudes = Solicitud::with('creadoPor', 'repartidor', 'actualizadoPor', 'archivosRppSolicitados.archivo', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor','archivosRppSolicitados.repartidor')
                                        ->withCount('archivosRppSolicitados')
                                        ->whereIn('estado', ['recibida', 'aceptada', 'regresada'])
                                        ->where('ubicacion', 'RPP')
                                        ->where(function($q){
                                            return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                        ->orWhere('numero', $this->search);
                                        })
                                        ->orderBy($this->sort, $this->direction)
                                        ->paginate($this->pagination);

        }


        return view('livewire.admin.distribuidor-rpp', compact('solicitudes'))->extends('layouts.admin');
    }
}
