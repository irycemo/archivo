<?php

namespace App\Http\Livewire\Admin\Reportes\Catastro;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CatastroArchivo;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArchivoCatastroExport;
use Illuminate\Support\Facades\Log;

class ReporteArchivo extends Component
{

    use WithPagination;

    public $archivoEstado;
    public $archivoTarjeta;
    public $fecha1;
    public $fecha2;

    public $pagination = 10;

    public function descargarExcel(){

        $this->fecha1 = $this->fecha1 . ' 00:00:00';
        $this->fecha2 = $this->fecha2 . ' 23:59:59';

        try {

            return Excel::download(new ArchivoCatastroExport($this->archivoEstado, $this->archivoTarjeta, $this->fecha1, $this->fecha2), 'Reporte_de_archivos_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error('Error al generar archivo de reporte, usuario: ' . auth()->user()->name . '\n' . $th);

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function render()
    {

        $archivos = CatastroArchivo::with('creadoPor', 'actualizadoPor')
                                    ->when (isset($this->archivoEstado) && $this->archivoEstado != "", function($q){
                                        return $q->where('estado', $this->archivoEstado);
                                    })
                                    ->when (isset($this->archivoTarjeta) && $this->archivoTarjeta != "", function($q){
                                        return $q->where('tarjeta', $this->archivoTarjeta);
                                    })
                                    ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                                    ->paginate($this->pagination);

        return view('livewire.admin.reportes.catastro.reporte-archivo', compact('archivos'));

    }
}
