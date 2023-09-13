<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Http\Constantes;
use App\Models\Solicitud;
use App\Models\RppArchivo;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\RppArchivoSolicitud;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\ComponentesTrait;

class SolicitudesRpp extends Component
{
    use ComponentesTrait;
    use WithPagination;

    public $tomo;
    public $registro;
    public $formacion = false;
    public $observaciones;
    public $seccion;
    public $distrito;
    public $archivos = [];
    public $archivo;
    public $empleado;
    public $empleados;
    public $solicitud;
    public $modalVer = false;
    public $distritos;

    protected $queryString = ['search'];

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'registro', 'formacion', 'crear', 'editar', 'modal', 'archivo', 'tomo', 'empleado', 'solicitud', 'seccion', 'distrito', 'modalVer']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrirModalCrear(){

        $solicitudes_vencidas = Solicitud::where('creado_por', auth()->user()->id)->where('estado', 'entregada')->where('tiempo', '<', now()->toDateString())->get();

        if($solicitudes_vencidas->count() > 0){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Tiene solicitudes con timempo vencido, es necesario regresarlas para poder seguir haciendo solicitudes."]);

            return;
        }

        $this->resetearTodo();
        $this->modal = true;
        $this->crear =true;


    }

    public function agregar(){

        $this->validate([
            'tomo' => 'required',
            'registro' => 'required',
            'seccion' => 'required',
            'distrito' => 'required',
            'formacion' => 'required',
            'empleado' => 'required'
        ]);

        $archivo = RppArchivo::where('tomo', $this->tomo)
                                ->where('registro', $this->registro)
                                ->where('seccion', $this->seccion)
                                ->where('distrito', $this->distrito)
                                ->where('formacion', $this->formacion)
                                ->first();

        if($archivo){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Archivo no disponible."]);

            return;

        }

        if($this->solicitud)
            $this->agregarSolicitud();
        else
            $this->crearSolicitu();

        $this->reset('tomo', 'registro', 'seccion', 'distrito');

    }

    public function crearSolicitu(){

        DB::transaction(function () {

            $archivo = RppArchivo::create([
                'estado' => 'ocupado',
                'tomo' => $this->tomo,
                'registro' => $this->registro,
                'seccion' => $this->seccion,
                'distrito' => $this->distrito,
                'formacion' => $this->formacion,
            ]);

            $this->solicitud = Solicitud::create([
                'numero' => Solicitud::max('numero') + 1,
                'tiempo' => $this->calcularFechaEntrega(30),
                'estado' => 'nueva',
                'creado_por' => auth()->user()->id,
                'ubicacion' => 'RPP',
                'asignado_a' => $this->empleado,
                'formacion' => $this->formacion,
            ]);

            $this->solicitud->archivosRppSolicitados()->create([
                'rpp_archivo_id' => $archivo->id,
                'asignado_a' => $this->empleado
            ]);

        });

        $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Se creo una nueva solicitud."]);

    }

    public function agregarSolicitud(){

        DB::transaction(function () {

            $archivo = RppArchivo::create([
                'estado' => 'ocupado',
                'tomo' => $this->tomo,
                'registro' => $this->registro,
                'seccion' => $this->seccion,
                'distrito' => $this->distrito,
                'formacion' => $this->solicitud->formacion,
            ]);

            $this->solicitud->archivosRppSolicitados()->create([
                'rpp_archivo_id' => $archivo->id,
                'asignado_a' => $this->empleado
            ]);

        });

        $this->solicitud->load('archivosRppSolicitados.archivo', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor','archivosRppSolicitados.repartidor');

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

    public function abrirModalEditar($id){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        $this->solicitud = Solicitud::with([
                                            'archivosRppSolicitados.archivo',
                                            'archivosRppSolicitados.repartidor',
                                            'archivosRppSolicitados.entregadoPor',
                                            'archivosRppSolicitados.recibidoPor'
                                        ])
                                        ->where('id', $id)
                                        ->first();

        $this->empleado = $this->solicitud->asignado_a;

        $this->formacion = $this->solicitud->formacion;

    }

    public function borrar(){

        try{

            DB::transaction(function () {

                $solicitud = Solicitud::with('archivosRppSolicitados.archivo')->find($this->selected_id);

                foreach ($solicitud->archivosRppSolicitados as $archivoSolicitado) {

                    $archivo = $archivoSolicitado->archivo;

                    $archivoSolicitado->delete();

                    $archivo->delete();

                }

                $solicitud->delete();

                $this->resetearTodo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La solicitud se eliminó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al eliminar solicitud por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function removerArchivo($id){

        $this->validate(['observaciones' => 'required']);

        try{

            DB::transaction(function () use ($id){

                $archivoSolicitado = RppArchivoSolicitud::find($id);

                $archivo = $archivoSolicitado->archivo;

                $archivoSolicitado->delete();

                $archivo->delete();

                if($this->solicitud->observaciones)
                    $observaciones = $this->solicitud->observaciones . ' | ' . $this->observaciones;
                else
                    $observaciones = $this->observaciones;

                $this->solicitud->update([
                    'observaciones' => $observaciones,
                    'actualizado_por' => auth()->user()->id
                ]);

                $this->solicitud->refresh();

                $this->solicitud->load('archivosRppSolicitados.archivo', 'archivosRppSolicitados.repartidor', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor');

                $this->reset('observaciones');

            });

        } catch (\Throwable $th) {

            Log::error("Error al remover archivo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function abrirModalVer($id){

        $this->resetearTodo();
        $this->modalVer = true;

        $this->solicitud = Solicitud::with(['archivosRppSolicitados.archivo', 'archivosRppSolicitados.repartidor', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor'])->where('id', $id)->first();

        if($this->solicitud->archivos)
            $this->archivos = json_decode($this->solicitud->archivos);

    }

    public function aceptarRechazar($tipo){

        if($tipo == 'aceptar'){

            try{

                $this->solicitud->update(['estado' => 'aceptada', 'actualizado_por' => auth()->user()->id]);

            } catch (\Throwable $th) {

                Log::error("Error al aceptar solicitud por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }else{

            $this->validate(['observaciones' => 'required']);

            try{

                DB::transaction(function (){

                    $this->solicitud->update(['estado' => 'rechazada', 'actualizado_por' => auth()->user()->id]);

                    foreach ($this->solicitud->archivosRppSolicitados as $archivoSolicitado) {

                        $archivo = $archivoSolicitado->archivo;

                        $archivoSolicitado->delete();

                        $archivo->delete();

                    }

                });

            } catch (\Throwable $th) {

                Log::error("Error al rechazar solicitud id: " . $this->solicitud->folio . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }

        $this->resetearTodo();

    }

    public function recibirRegresar($tipo){

        if($tipo == 'recibir'){

            try{

                DB::transaction(function (){

                    $this->solicitud->update(['estado' => 'entregada']);

                    foreach($this->solicitud->archivosRppSolicitados as $archivoSolicitado)
                        $archivoSolicitado->update([
                            'entregado_por' => auth()->user()->id,
                            'entregado_en' => now()
                        ]);

                    $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Los archivos se recibieron con éxito."]);

                });

            } catch (\Throwable $th) {

                Log::error("Error al entregar solicitud id: " . $this->solicitud->folio . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
                $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
                $this->resetearTodo();

            }

        }else{


            $this->dispatchBrowserEvent('ingresaClave');

        }

    }

    public function revisarClave($clave){

        $surtidores = User::whereHas('roles', function($q){
                            $q->where('name', 'Surtidor RPP');
                        })
                        ->where('status', 'activo')
                        ->get();

        if($surtidores->count() == 0){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', 'No hay repartidores con la contraseña ingresada.']);

            return;

        }

        $user = null;

        foreach($surtidores as $surtidor){

            if(Hash::check($clave, $surtidor->password)){

                $user = $surtidor;

            }

        }

        if(!$user){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', 'No hay repartidores con la contraseña ingresada.']);

            return;

        }

        try{

            DB::transaction(function () use($user){

                $this->solicitud->update(['estado' => 'regresada']);

                foreach($this->solicitud->archivosRppSolicitados as $archivoSolicitado){

                    $archivoSolicitado->update([
                        'regresado_en' => now(),
                        'recibido_por' => $user->id
                    ]);

                }

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "Los archivos se regresaron con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al regresar solicitud id: " . $this->solicitud->folio . " por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function mount(){

        if(auth()->user()->hasRole('Solicitador RPP'))
            $this->empleados = Http::acceptJson()->get('http://127.0.0.1:8000/api/empleados_presentes/' . rawurlencode(auth()->user()->area))->collect();

        $this->empleados = [
            0 => [
                'id' => 1,
                'nombre' => 'Enrique de Jesus Robledo Camacho'
            ],
            1 => [
                'id' => 2,
                'nombre' => 'Jesus Manriquez Vargas'
            ]
        ];

        $this->distritos = Constantes::DISTRITOS;

    }

    public function render()
    {

        $secciones = collect(Constantes::SECCIONES)->sort();

        if(auth()->user()->hasRole('Administrador')){

            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor', 'archivosRppSolicitados.archivo', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor','archivosRppSolicitados.repartidor')
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

            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor', 'archivosRppSolicitados.archivo', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor','archivosRppSolicitados.repartidor')
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
            $solicitudes = Solicitud::with('creadoPor', 'actualizadoPor', 'archivosRppSolicitados.archivo', 'archivosRppSolicitados.entregadoPor', 'archivosRppSolicitados.recibidoPor','archivosRppSolicitados.repartidor')
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
