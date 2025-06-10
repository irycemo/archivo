<?php

namespace App\Http\Livewire\Admin;

use App\Models\File;
use Livewire\Component;
use App\Http\Constantes;
use App\Models\Incidence;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\ComponentesTrait;
use Illuminate\Support\Facades\Storage;
use App\Models\CatastroArchivo as cArchivo;

class CatastroArchivo extends Component
{
    use WithPagination;
    use WithFileUploads;
    use ComponentesTrait;

    public $estado;
    public $tomo;
    public $localidad;
    public $oficina = 101;
    public $tipo;
    public $registro;
    public $folio = 0;
    public $tarjeta = 0;
    public $archivoPDF;
    public $incidencias;
    public $incidenciaTipo;
    public $incidenciaObservaciones;
    public $modalIncidencias = false;

    protected $queryString = ['search'];

    protected function rules(){
        return [
            'tomo' => 'sometimes',
            'localidad' => 'required|in:1,2,3,4,5,6,7',
            'oficina' => 'required',
            'tipo' => 'required|in:1,2',
            'registro' => 'required|numeric',
            'folio' => 'required|numeric',
            'tarjeta' => 'required|in:0,1',
            'archivoPDF' => 'nullable|mimes:pdf'
         ];
    }

    protected $validationAttributes  = [
        'archivoPDF' => 'archivo',
    ];

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'archivoPDF', 'crear', 'editar', 'modal', 'estado', 'tomo', 'localidad', 'oficina', 'tipo', 'registro', 'folio', 'tarjeta', 'modalIncidencias', 'incidencias','incidenciaTipo', 'incidenciaObservaciones']);
        $this->resetErrorBag();
        $this->resetValidation();

        $this->dispatchBrowserEvent('removeFiles');

    }

    public function abrirModalIncidencia($id){

        $this->resetearTodo();
        $this->modalIncidencias = true;
        $this->selected_id = $id;

        $this->incidencias = Incidence::with('creadoPor')->where('incidenceable_id', $id)->where('incidenceable_type', 'App\Models\CatastroArchivo')->get();

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

        if(cArchivo::where('localidad', $this->localidad)->where('oficina', $this->oficina)->where('tipo', $this->tipo)->where('registro', $this->registro)->first()){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "La cuenta ya se encuentra regsitrada."]);

            return;
        }

        $sgc = Http::acceptJson()->get('http://10.0.253.223:8095/sgcpredio.asmx/sgc_predio?tipo=1&locl='. $this->localidad .'&ofna=101&tpre='. $this->tipo . '&nreg='. $this->registro)->collect();

        $a = json_decode($sgc);

        if($a->message == "Predio no existe, favor de verificar"){

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', $a->message]);

            return;
        }

        try {

            DB::transaction(function () {

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

                if($this->archivoPDF){

                    $nombreArchivo = $this->archivoPDF->store('/', 'pdfs_catastro');

                    File::create([
                        'url' => $nombreArchivo,
                        'fileable_id' => $archivo->id,
                        'fileable_type' => 'App\Models\CatastroArchivo',
                        'creado_por' => auth()->user()->id
                    ]);

                    $this->dispatchBrowserEvent('removeFiles');

                }

                $this->resetearTodo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El archivo se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear archivo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

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

                if($this->archivoPDF){

                    if($archivo->archivo){

                        Storage::disk('pdfs_catastro')->delete($archivo->archivo->url);

                        File::destroy($archivo->archivo->id);

                    }

                    $nombreArchivo = $this->archivoPDF->store('/', 'pdfs_catastro');

                    File::create([
                        'url' => $nombreArchivo,
                        'fileable_id' => $archivo->id,
                        'fileable_type' => 'App\Models\CatastroArchivo',
                        'creado_por' => auth()->user()->id
                    ]);

                    $this->dispatchBrowserEvent('removeFiles');

                }


                $this->resetearTodo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El archivo se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al actualizar archivo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            DB::transaction(function () {

                $archivo = cArchivo::with('archivo')->find($this->selected_id);

                if($archivo->archivo){

                    Storage::disk('pdfs_catastro')->delete($archivo->archivo->url);

                    $archivo->archivo->delete();

                }

                $incidencias = Incidence::where('incidenceable_type', 'App\Models\CatastroArchivo')
                                            ->where('incidenceable_id', $this->selected_id)
                                            ->get();

                if($incidencias->count() > 0){

                    foreach ($incidencias as $incidencia) {
                        $incidencia->delete();
                    }

                }

                $archivo->delete();

                $this->resetearTodo();

                $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El archivo se eliminó con éxito."]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al borrar archivo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function crearIncidencia(){

        $this->validate([
            'incidenciaTipo' => 'required',
            'incidenciaObservaciones' => 'required'
        ],[],
        [
            'incidenciaTipo' => 'tipo',
            'incidenciaObservaciones' => 'observaciones'
        ]);

        try {

            Incidence::create([
                'tipo' => $this->incidenciaTipo,
                'observaciones' => $this->incidenciaObservaciones,
                'incidenceable_id' => $this->selected_id,
                'incidenceable_type' => 'App\Models\CatastroArchivo',
                'creado_por' => auth()->user()->id
            ]);

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La incidencia se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear incidencia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function render()
    {

        $tipos = collect(Constantes::INCIDENCIAS)->sort();

        $archivos = cArchivo::with('archivo', 'creadoPor', 'actualizadoPor')
                                ->where('estado', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tomo', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('localidad', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('oficina', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tipo', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('registro', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('folio', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tarjeta', 'LIKE', '%' . $this->search . '%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);

        return view('livewire.admin.catastro-archivo', compact('archivos', 'tipos'))->extends('layouts.admin');

    }
}
