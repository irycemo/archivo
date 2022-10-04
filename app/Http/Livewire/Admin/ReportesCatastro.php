<?php

namespace App\Http\Livewire\Admin;

use App\Models\File;
use Livewire\Component;
use App\Http\Constantes;
use App\Models\Incidence;
use Livewire\WithPagination;
use App\Models\CatastroArchivo;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArchivoCatastroExport;
use App\Exports\IncidenciasCatastroExport;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportesCatastro extends Component
{

    use WithPagination;

    public $area;
    public $fecha1;
    public $fecha2;

    public $verArchivos;
    public $verIncidencias;
    public $verDigitalizacion;

    public $archivoEstado;
    public $archivoTarjeta;

    public $incidenciaTipo;

    public $archivosDigitalizados;
    public $archivosTotal;

    public $archivos_filtrados;
    public $incidencias_filtradas;
    public $digitalizaciones_filtradas;

    protected function rules(){
        return [
            'fecha1' => 'required|date',
            'fecha2' => 'required|date|after:date1',
         ];
    }

    public function updatedFecha1(){

        $this->fecha1 = $this->fecha1 . ' 00:00:00';

    }

    public function updatedFecha2(){

        $this->fecha2 = $this->fecha2 . ' 23:59:59';

    }

    public function updatedArea(){

        $this->reset(
            [
                'archivos_filtrados',
                'incidencias_filtradas',
                'digitalizaciones_filtradas',
            ]
        );

        if($this->area == 'archivos'){

            $this->verArchivos = true;
            $this->verIncidencias = false;
            $this->verDigitalizacion = false;

        }elseif($this->area == 'incidencias'){

            $this->verArchivos = false;
            $this->verIncidencias = true;
            $this->verDigitalizacion = false;


        }elseif($this->area == 'digitalizacion'){

            $this->verArchivos = false;
            $this->verIncidencias = false;
            $this->verDigitalizacion = true;
        }
    }

    public function getArchivosFiltradosProperty(): LengthAwarePaginator{

        return CatastroArchivo::with('creadoPor', 'actualizadoPor')
                    ->when (isset($this->archivoEstado) && $this->archivoEstado != "", function($q){
                        return $q->where('estado', $this->archivoEstado);
                    })
                    ->when (isset($this->archivoTarjeta) && $this->archivoTarjeta != "", function($q){
                        return $q->where('tarjeta', $this->archivoTarjeta);
                    })
                    ->whereBetween('created_at', [$this->fecha1, $this->fecha2])
                    ->paginate(50);
    }

    public function filtrarArchivos(){

        $this->validate();

        $this->archivos_filtrados = CatastroArchivo::with('creadoPor', 'actualizadoPor')
                                        ->when (isset($this->archivoEstado) && $this->archivoEstado != "", function($q){
                                            return $q->where('estado', $this->archivoEstado);
                                        })
                                        ->when (isset($this->archivoTarjeta) && $this->archivoTarjeta != "", function($q){
                                            return $q->where('tarjeta', $this->archivoTarjeta);
                                        })
                                        ->whereBetween('created_at', [$this->fecha1, $this->fecha2])
                                        ->take(100)->get();

    }

    public function filtrarIncidencias(){

        $this->validate();

        $this->incidencias_filtradas = Incidence::with('creadoPor', 'actualizadoPor', 'incidenceable')
                                                        ->where('incidenceable_type', 'App\Models\CatastroArchivo')
                                                        ->when (isset($this->incidenciaTipo) && $this->incidenciaTipo != "", function($q){
                                                            return $q->where('tipo', $this->incidenciaTipo);
                                                        })
                                                        ->whereBetween('created_at', [$this->fecha1, $this->fecha2])
                                                        ->get();

    }

    public function filtrarDigitalizaciones(){

        $this->validate();

        $this->archivosTotal = CatastroArchivo::whereBetween('created_at', [$this->fecha1, $this->fecha2])->count();

        $this->archivosDigitalizados = File::where('fileable_type', 'App\Models\CatastroArchivo')->whereBetween('created_at', [$this->fecha1, $this->fecha2])->count();

        $this->digitalizaciones_filtradas = ($this->archivosDigitalizados * 100) / $this->archivosTotal;

    }

    public function descargarExcel($modelo){

        if($modelo == 'archivos')
            return Excel::download(new ArchivoCatastroExport($this->archivos_filtrados), 'Reporte_de_archivos_' . now()->format('d-m-Y') . '.xlsx');

        if($modelo == 'incidencias')
            return Excel::download(new IncidenciasCatastroExport($this->incidencias_filtradas), 'Reporte_de_incidencias_' . now()->format('d-m-Y') . '.xlsx');
    }

    public function render()
    {

        $incidencias = Constantes::INCIDENCIAS;

        return view('livewire.admin.reportes-catastro', compact('incidencias'))->extends('layouts.admin');
    }
}
