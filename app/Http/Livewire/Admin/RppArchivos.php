<?php

namespace App\Http\Livewire\Admin;

use App\Models\File;
use Livewire\Component;
use App\Http\Constantes;
use App\Models\Incidence;
use App\Models\RppArchivo;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Http\Traits\ComponentesTrait;
use Illuminate\Support\Facades\Storage;

class RppArchivos extends Component
{
    use WithPagination;
    use WithFileUploads;
    use ComponentesTrait;

    public $estado;
    public $tomo;
    public $tomo_bis;
    public $seccion;
    public $distrito;
    public $archivoPDF;
    public $incidencias;
    public $incidenciaTipo;
    public $incidenciaObservaciones;
    public $modalIncidencias = false;

    protected $queryString = ['search'];

    protected function rules(){
        return [
            'tomo' => 'required',
            'archivoPDF' => 'nullable|mimes:pdf',
            'seccion' => 'required',
            'distrito' => 'required|numeric',
         ];
    }

    protected $validationAttributes  = [
        'seccion' => 'sección',
        'archivoPDF' => 'archivo',
    ];

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'archivoPDF', 'crear', 'editar', 'modal', 'estado', 'tomo', 'tomo_bis', 'seccion', 'distrito', 'modalIncidencias', 'incidencias','incidenciaTipo', 'incidenciaObservaciones']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrirModalIncidencia($id){

        $this->resetearTodo();
        $this->modalIncidencias = true;
        $this->selected_id = $id;

        $this->incidencias = Incidence::with('creadoPor')->where('incidenceable_id', $id)->where('incidenceable_type', 'App\Models\RppArchivo')->get();

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

            if($this->archivoPDF){

                $nombreArchivo = $this->archivoPDF->store('/', 'pdfs_rpp');

                File::create([
                    'url' => $nombreArchivo,
                    'fileable_id' => $archivo->id,
                    'fileable_type' => 'App\Models\RppArchivo',
                    'creado_por' => auth()->user()->id
                ]);

                $this->dispatchBrowserEvent('removeFiles');

            }

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

            if($this->archivoPDF){

                if($archivo->archivo){
                    Storage::disk('pdfs_rpp')->delete($archivo->archivo->url);

                    File::destroy($archivo->archivo->id);
                }

                $nombreArchivo = $this->archivoPDF->store('/', 'pdfs_rpp');

                File::create([
                    'url' => $nombreArchivo,
                    'fileable_id' => $archivo->id,
                    'fileable_type' => 'App\Models\RppArchivo',
                    'creado_por' => auth()->user()->id
                ]);

                $this->dispatchBrowserEvent('removeFiles');

            }

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El archivo se actualizó con éxito."]);

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $archivo = RppArchivo::with('archivo')->find($this->selected_id);

            if($archivo->archivo){

                Storage::disk('pdfs_catastro')->delete($archivo->archivo->url);

                $archivo->archivo->delete();

            }

            $archivo->delete();

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El archivo se eliminó con éxito."]);

        } catch (\Throwable $th) {
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
                'incidenceable_type' => 'App\Models\RppArchivo',
                'creado_por' => auth()->user()->id
            ]);

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "La incidencia se creó con éxito."]);

        } catch (\Throwable $th) {
            dd($th);
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function render()
    {

        $secciones = Constantes::SECCIONES;

        $tipos = Constantes::AREAS;

        $archivos = RppArchivo::with('archivo', 'creadoPor', 'actualizadoPor')
                                ->where('estado', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tomo', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('tomo_bis', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('seccion', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('distrito', 'LIKE', '%' . $this->search . '%')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);

        return view('livewire.admin.rpp-archivos', compact('archivos', 'secciones', 'tipos'))->extends('layouts.admin');

    }
}
