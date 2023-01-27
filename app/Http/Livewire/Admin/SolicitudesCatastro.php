<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Constantes;
use App\Models\Solicitud;
use Livewire\WithPagination;
use App\Models\CatastroArchivo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\ComponentesTrait;
use App\Models\CatastroArchivoSolicitud;

class SolicitudesCatastro extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $localidad;
    public $tipo;
    public $registro;
    public $tomo;
    public $archivo;
    public $empleado;
    public $empleados = [];
    public $solicitud;
    public $modalVer = false;

    protected $queryString = ['search'];

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'crear', 'editar', 'modal', 'archivo', 'empleado', 'tomo', 'solicitud', 'localidad', 'tipo', 'registro', 'modalVer']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrirModalEditar($id){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        $this->solicitud = Solicitud::with('archivosCatastroSolicitados.archivo','archivosCatastroSolicitados.entregadoPor', 'archivosCatastroSolicitados.recibidoPor')->where('id', $id)->first();

    }

    public function abrirModalVer($id){

        $this->resetearTodo();
        $this->modalVer = true;

        $this->solicitud = Solicitud::with('archivosCatastroSolicitados.archivo', 'archivosCatastroSolicitados.entregadoPor', 'archivosCatastroSolicitados.recibidoPor')->where('id', $id)->first();
    }

    public function borrar(){

        try{

            DB::transaction(function () {

                $solicitud = Solicitud::find($this->selected_id);

                $solicitud->archivosCatastroSolicitados()->get()->each->delete();

                $solicitud->delete();

                $this->resetearTodo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La solicitud se eliminó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al borrar solicitud por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function buscarArchivo(){

        $this->reset(['archivo']);

        $this->validate([
            'localidad' => 'required',
            'tipo' => 'required',
            'registro' => 'required'
        ]);

        try {

            $this->archivo = CatastroArchivo::with('archivo')
                                            ->where('estado', 'disponible')
                                            ->where('localidad', $this->localidad)
                                            ->where('tipo', $this->tipo)
                                            ->where('registro', $this->registro)
                                            ->when(isset($this->tomo), function($q){
                                                return $q->where('tomo', $this->tomo);
                                            })
                                            ->firstOrFail();

            $sgc = Http::acceptJson()->get('http://10.0.253.223:8095/sgcpredio.asmx/sgc_predio?tipo=1&locl='. $this->localidad .'&ofna=101&tpre='. $this->tipo . '&nreg='. $this->registro)->collect();

            $a = json_decode($sgc);

            if($a->status == "1"){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "EL archivo se encuentra digitalizado, consultelo en SGC"]);

                $this->reset('archivo');

                return;

            }

            if($this->archivo->archivo){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "EL archivo se encuentra digitalizado."]);

                $this->reset('archivo');

                return;

            }

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Archivo no disponible."]);

            $this->reset(['tomo', 'localidad', 'registro', 'tipo']);

        }

    }

    public function solicitar(){

        $this->validate(['empleado' => 'required']);

        if($this->solicitud){

            if($this->solicitud->archivosCatastroSolicitados()->where('catastro_archivo_id', $this->archivo->id)->first()){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ya fue sido solicitado."]);

                $this->reset(['empleado', 'archivo', 'tomo', 'localidad', 'tipo', 'registro']);

                return;
            }

            $this->solicitud->archivosCatastroSolicitados()->create([
                'catastro_archivo_id' => $this->archivo->id,
                'asignado_a' => $this->empleados[$this->empleado]['nombre'],
            ]);

            $this->archivo->update(['estado' => 'solicitado']);

            $this->reset(['empleado', 'archivo', 'tomo', 'localidad', 'tipo', 'registro']);

        }else{

            $number = Solicitud::orderBy('numero', 'desc')->value('numero');

            $this->solicitud = Solicitud::create([
                'numero' => $number ? $number + 1 : 1,
                'tiempo' => $this->calcularFechaEntrega(30),
                'estado' => 'nueva',
                'creado_por' => auth()->user()->id,
                'ubicacion' => 'Catastro'
            ]);

            $this->solicitud->archivosCatastroSolicitados()->create([
                'catastro_archivo_id' => $this->archivo->id,
                'asignado_a' => $this->empleados[$this->empleado]['nombre'],
            ]);

            $this->archivo->update(['estado' => 'solicitado']);

            $this->reset(['empleado', 'archivo', 'tomo', 'localidad', 'tipo', 'registro']);

        }

        $this->solicitud->load('archivosCatastroSolicitados.archivo', 'archivosCatastroSolicitados.entregadoPor', 'archivosCatastroSolicitados.recibidoPor');

    }

    public function removerArchivo($id){

        try{

            CatastroArchivoSolicitud::destroy($id);

            $this->solicitud->refresh();

            $this->solicitud->load('archivosCatastroSolicitados.archivo', 'archivosCatastroSolicitados.entregadoPor', 'archivosCatastroSolicitados.recibidoPor');

        } catch (\Throwable $th) {

            Log::error("Error al remover archivo de solicitud id:" . $this->solicitud->id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function calcularFechaEntrega($dias){

        $final = now();

            for ($i=0; $i < $dias; $i++) {

                $final->addDay();

                while($final->isWeekend()){

                    $final->addDay();

                }

            }

        return $final;
    }

    public function aceptarRechazar($id, $tipo){

        $solicitud = Solicitud::with('archivosCatastroSolicitados.archivo')->where('id', $id)->first();

        if($tipo == 'aceptar'){

            try{

                $solicitud->update(['estado' => 'aceptada']);

                foreach($solicitud->archivosCatastroSolicitados as $archivo)
                    $archivo->archivo->update(['estado' => 'ocupado']);

            } catch (\Throwable $th) {

                Log::error("Error al aceptar solicitud id: " . $this->solicitud->id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }


        }else{

            try{

                $solicitud->update(['estado' => 'rechazada']);

                foreach($solicitud->archivosCatastroSolicitados as $archivoSolicitado)
                $archivoSolicitado->archivo->update(['estado' => 'disponible']);

            } catch (\Throwable $th) {

                Log::error("Error al rechazar solicitud id: " . $this->solicitud->id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }

        $this->resetearTodo();

    }

    public function entregarRecibir($id, $tipo){

        $solicitud = Solicitud::with('archivosCatastroSolicitados.archivo')->where('id', $id)->first();

        if($tipo == 'entregar'){

            try{

                $solicitud->update(['estado' => 'entregada']);

                foreach($solicitud->archivosCatastroSolicitados as $archivoSolicitado)
                    $archivoSolicitado->update([
                        'entregado_por' => auth()->user()->id,
                        'entregado_en' => now()
                    ]);

            } catch (\Throwable $th) {

                Log::error("Error al entregar solicitud id: " . $this->solicitud->id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }else{

            try{

                $solicitud->update(['estado' => 'regresada']);

                foreach($solicitud->archivosCatastroSolicitados as $archivoSolicitado){
                    $archivoSolicitado->update([
                        'regresado_en' => now(),
                        'recibido_por' => auth()->user()->id
                    ]);
                    $archivoSolicitado->archivo->update([
                        'estado' => 'disponible'
                    ]);
                }

            } catch (\Throwable $th) {

                Log::error("Error al recibir solicitud id: " . $this->solicitud->id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }

        $this->resetearTodo();

    }

    public function recibirArchivo($id){

        try {

            $archivoSolicitado = CatastroArchivoSolicitud::find($id);

            $archivoSolicitado->update([
                'recibido_por' => auth()->user()->id,
                'regresado_en' => now()
            ]);

            $archivoSolicitado->archivo->update([
                'estado' => 'disponible'
            ]);

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Se actualizó la información con éxito."]);

            $this->resetearTodo();

        } catch (\Throwable $th) {

            Log::error("Error al recibir archivo id: " .$archivoSolicitado->id . " de  solicitud id: " . $this->solicitud->id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
        }

    }

    public function imprimirLista(){
        $this->dispatchBrowserEvent('imprimir_lista', ['solicitud' => $this->solicitud->id]);
    }

    public function mount(){

        if(auth()->user()->hasRole('Solicitador'))
            $this->empleados = Http::acceptJson()->get('http://127.0.0.1:8000/api/empleados_presentes/' . rawurlencode(auth()->user()->area))->collect();

            $this->empleados = [
                0 => [
                    'id' => 1,
                    'nombre' => 'Prueba 1'
                ],
                1 => [
                    'id' => 2,
                    'nombre' => 'Prueba 2'
                ]
            ];

    }

    public function render()
    {
        $secciones = collect(Constantes::SECCIONES)->sort();

        if(auth()->user()->hasRole('Administrador')){

            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor','archivosCatastroSolicitados')
                                    ->withCount('archivosRppSolicitados', 'archivosCatastroSolicitados')
                                    ->where('ubicacion', 'Catastro')
                                    ->where(function($q){
                                        return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('numero', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere(function($q){
                                                        return $q->whereHas('archivosCatastroSolicitados', function($q){
                                                            return $q->whereHas('archivo', function($q){
                                                                $q->where('registro', 'LIKE', '%' . $this->search . '%');
                                                            });
                                                        });
                                                    });
                                    })
                                    ->orderBy($this->sort, $this->direction)
                                    ->paginate($this->pagination);

        }
        elseif(auth()->user()->hasRole('Solicitante')){

            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor','archivosCatastroSolicitados')
                                    ->withCount('archivosRppSolicitados', 'archivosCatastroSolicitados')
                                    ->where('ubicacion', 'Catastro')
                                    ->where('creado_por', auth()->user()->id)
                                    ->where(function($q){
                                        return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('numero', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere(function($q){
                                                        return $q->whereHas('archivosCatastroSolicitados', function($q){
                                                            return $q->whereHas('archivo', function($q){
                                                                $q->where('registro', 'LIKE', '%' . $this->search . '%');
                                                            });
                                                        });
                                                    });
                                    })
                                    ->orderBy($this->sort, $this->direction)
                                    ->paginate($this->pagination);

        }else{
            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor','archivosCatastroSolicitados')
                                    ->withCount('archivosRppSolicitados', 'archivosCatastroSolicitados')
                                    ->where('ubicacion', 'Catastro')
                                    ->where(function($q){
                                        return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('numero', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere(function($q){
                                                        return $q->whereHas('archivosCatastroSolicitados', function($q){
                                                            return $q->whereHas('archivo', function($q){
                                                                $q->where('registro', 'LIKE', '%' . $this->search . '%');
                                                            });
                                                        });
                                                    });
                                    })
                                    ->orderBy($this->sort, $this->direction)
                                    ->paginate($this->pagination);
        }

        return view('livewire.admin.solicitudes-catastro', compact('solicitudes', 'secciones'))->extends('layouts.admin');
    }
}
