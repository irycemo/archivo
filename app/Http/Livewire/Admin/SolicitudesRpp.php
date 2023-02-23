<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Constantes;
use App\Models\Solicitud;
use App\Models\RppArchivo;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\RppArchivoSolicitud;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\ComponentesTrait;

class SolicitudesRpp extends Component
{
    use ComponentesTrait;
    use WithPagination;

    public $tomo;
    public $bis;
    public $seccion;
    public $distrito;
    public $archivo;
    public $empleado;
    public $empleados;
    public $solicitud;
    public $modalVer = false;

    protected $queryString = ['search'];

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'crear', 'editar', 'modal', 'archivo', 'empleado', 'tomo', 'bis', 'solicitud', 'seccion', 'distrito', 'modalVer']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrirModalEditar($id){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        $this->solicitud = Solicitud::with(['archivosRppSolicitados.archivo', 'archivosRppSolicitados.repartidor', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor'])->where('id', $id)->first();

    }

    public function abrirModalVer($id){

        $this->resetearTodo();
        $this->modalVer = true;

        $this->solicitud = Solicitud::with(['archivosRppSolicitados.archivo', 'archivosRppSolicitados.repartidor', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor'])->where('id', $id)->first();
    }

    public function borrar(){

        try{

            DB::transaction(function () {

                $solicitud = Solicitud::find($this->selected_id);

                $solicitud->archivosRppSolicitados()->get()->each->delete();

                $solicitud->delete();

                $this->resetearTodo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La solicitud se eliminó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear rol por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function buscarArchivo(){

        $this->reset(['archivo']);

        $this->validate([
            'tomo' => 'required',
            'seccion' => 'required',
            'distrito' => 'required'
        ]);

        try {

            $this->archivo = RppArchivo::with('archivo')
                                            ->where('estado', 'disponible')
                                            ->where('tomo', $this->tomo)
                                            ->where('tomo_bis', $this->bis)
                                            ->where('seccion', $this->seccion)
                                            ->where('distrito', $this->distrito)
                                            ->firstOrFail();

            if($this->archivo->archivo){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "EL archivo se encuentra digitalizado."]);

                $this->reset('archivo');

                return;

            }

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Archivo no disponible."]);

            $this->reset(['tomo', 'bis', 'distrito', 'seccion']);

        }

    }

    public function solicitar(){

        $this->validate(['empleado' => 'required']);

        if($this->solicitud){

            if($this->solicitud->archivosRppSolicitados()->where('rpp_archivo_id', $this->archivo->id)->first()){

                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ya ha sido solicitado."]);

                $this->reset(['empleado', 'archivo', 'tomo', 'bis']);

                return;
            }

            $this->solicitud->archivosRppSolicitados()->create([
                'rpp_archivo_id' => $this->archivo->id,
                'asignado_a' => $this->empleados[$this->empleado]['nombre'],
            ]);

            $this->archivo->update(['estado' => 'solicitado']);

            $this->solicitud->update(['actualizado_por' => auth()->user()->id]);

            $this->reset(['empleado', 'archivo', 'tomo', 'bis']);

        }else{

            $number = Solicitud::orderBy('numero', 'desc')->value('numero');

            $this->solicitud = Solicitud::create([
                'numero' => $number ? $number + 1 : 1,
                'tiempo' => $this->calcularFechaEntrega(15),
                'estado' => 'nueva',
                'creado_por' => auth()->user()->id,
                'ubicacion' => 'RPP'
            ]);

            $this->solicitud->archivosRppSolicitados()->create([
                'rpp_archivo_id' => $this->archivo->id,
                'asignado_a' => $this->empleados[$this->empleado]['nombre'],
            ]);

            $this->archivo->update(['estado' => 'solicitado']);

            $this->reset(['empleado', 'archivo', 'tomo', 'bis']);

        }

        $this->solicitud->load('archivosRppSolicitados.archivo', 'archivosRppSolicitados.repartidor', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor');

    }

    public function removerArchivo($id){

        try{

            RppArchivoSolicitud::destroy($id);

            $this->solicitud->update(['actualizado_por' => auth()->user()->id]);

            $this->solicitud->refresh();

            $this->solicitud->load('archivosRppSolicitados.archivo', 'archivosRppSolicitados.repartidor', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor');

        } catch (\Throwable $th) {

            Log::error("Error al remover archivo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
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

        $solicitud = Solicitud::with('archivosRppSolicitados.archivo')->where('id', $id)->first();

        if($tipo == 'aceptar'){

            try{

                $solicitud->update(['estado' => 'aceptada', 'actualizado_por' => auth()->user()->id]);

                foreach($solicitud->archivosRppSolicitados as $archivo)
                    $archivo->archivo->update(['estado' => 'ocupado']);

            } catch (\Throwable $th) {

                Log::error("Error al aceptar solicitud por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }else{

            try{

                $solicitud->update(['estado' => 'rechazada', 'actualizado_por' => auth()->user()->id]);

                foreach($solicitud->archivosRppSolicitados as $archivoSolicitado)
                $archivoSolicitado->archivo->update(['estado' => 'disponible']);

            } catch (\Throwable $th) {

                Log::error("Error al rechazar solicitud id: " . $id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }

        $this->resetearTodo();

    }

    public function entregarRecibir($id, $tipo){

        $solicitud = Solicitud::with('archivosRppSolicitados.archivo')->where('id', $id)->first();

        if($tipo == 'entregar'){

            try{

                $solicitud->update(['estado' => 'entregada']);

                foreach($solicitud->archivosRppSolicitados as $archivoSolicitado)
                    $archivoSolicitado->update([
                        'entregado_por' => auth()->user()->id,
                        'entregado_en' => now()
                    ]);

            } catch (\Throwable $th) {

                Log::error("Error al rechazar solicitud id: " . $id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }else{

            try{

                $solicitud->update(['estado' => 'regresada']);

                foreach($solicitud->archivosRppSolicitados as $archivoSolicitado){
                    $archivoSolicitado->update([
                        'regresado_en' => now(),
                        'recibido_por' => auth()->user()->id
                    ]);

                    $archivoSolicitado->archivo->update([
                        'estado' => 'disponible'
                    ]);
                }

            } catch (\Throwable $th) {

                Log::error("Error al recibir solicitud id: " . $id . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }

        $this->resetearTodo();

    }

    public function mount(){

        if(auth()->user()->hasRole('Solicitador RPP'))
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

            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor')
                                    ->withCount('archivosRppSolicitados', 'archivosCatastroSolicitados')
                                    ->where('ubicacion', 'RPP')
                                    ->where(function($q){
                                        return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('numero', $this->search);
                                    })
                                    ->orderBy($this->sort, $this->direction)
                                    ->paginate($this->pagination);

        }
        elseif(auth()->user()->hasRole('Solicitante RPP')){

            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor')
                                    ->withCount('archivosRppSolicitados', 'archivosCatastroSolicitados')
                                    ->where(function($q){
                                        return $q->where('ubicacion', 'RPP')
                                            ->where('creado_por', auth()->user()->id);
                                    })
                                    ->where(function($q){
                                        return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('numero', $this->search);
                                    })
                                    ->orderBy($this->sort, $this->direction)
                                    ->paginate($this->pagination);

        }else{
            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor')
                                    ->withCount('archivosRppSolicitados', 'archivosCatastroSolicitados')
                                    ->where('ubicacion', 'RPP')
                                    ->where(function($q){
                                        return $q->where('estado', 'LIKE', '%' . $this->search . '%')
                                                    ->orWhere('numero', $this->search);
                                    })
                                    ->orderBy($this->sort, $this->direction)
                                    ->paginate($this->pagination);
        }

        return view('livewire.admin.solicitudes-rpp', compact('solicitudes', 'secciones'))->extends('layouts.admin');
    }
}
