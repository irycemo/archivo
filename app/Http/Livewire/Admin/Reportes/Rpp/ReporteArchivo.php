<?php

namespace App\Http\Livewire\Admin\Reportes\Rpp;

use Livewire\Component;
use App\Http\Constantes;
use App\Models\RppArchivo;
use App\Exports\ArchivoRppExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReporteArchivo extends Component
{

    public $archivoEstado;
    public $bis;
    public $seccion;
    public $distrito;
    public $fecha1;
    public $fecha2;

    public $pagination = 10;

    public function descargarExcel(){

        $this->fecha1 = $this->fecha1 . ' 00:00:00';
        $this->fecha2 = $this->fecha2 . ' 23:59:59';

        try {

            return Excel::download(new ArchivoRppExport($this->archivoEstado, $this->bis, $this->seccion, $this->distrito, $this->fecha1, $this->fecha2), 'Reporte_de_archivos_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error('Error al generar archivo de reporte, usuario: ' . auth()->user()->name . '\n' . $th);

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function render()
    {

        $secciones = collect(Constantes::SECCIONES)->sort();

        $archivos = RppArchivo::with('creadoPor', 'actualizadoPor')
                                ->when (isset($this->archivoEstado) && $this->archivoEstado != "", function($q){
                                    return $q->where('estado', $this->archivoEstado);
                                })
                                ->when (isset($this->bis) && $this->bis != "", function($q){
                                    return $q->where('tomo_bis', $this->bis);
                                })
                                ->when (isset($this->seccion) && $this->seccion != "", function($q){
                                    return $q->where('seccion', $this->seccion);
                                })
                                ->when (isset($this->distrito) && $this->distrito != "", function($q){
                                    return $q->where('distrito', $this->distrito);
                                })
                                ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                                ->paginate($this->pagination);

        return view('livewire.admin.reportes.rpp.reporte-archivo', compact('archivos', 'secciones'));
    }
}
