<?php

namespace App\Http\Livewire\Admin\Reportes\Catastro;

use Livewire\Component;
use App\Http\Constantes;
use App\Models\Incidence;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncidenciasCatastroExport;
use App\Http\Traits\ComponentesTrait;
use Livewire\WithPagination;

class ReporteIncidencia extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $incidenciaTipo;
    public $fecha1;
    public $fecha2;

    public $pagination = 10;

    public function descargarExcel(){

        $this->fecha1 = $this->fecha1 . ' 00:00:00';
        $this->fecha2 = $this->fecha2 . ' 23:59:59';

        try {

            return Excel::download(new IncidenciasCatastroExport($this->incidenciaTipo, $this->fecha1, $this->fecha2), 'Reporte_de_incidencias_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error('Error al generar archivo de reporte, usuario: ' . auth()->user()->name . ' ' . $th->getMessage());

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function render()
    {

        $tipos = collect(Constantes::INCIDENCIAS)->sort();

        $incidencias = Incidence::with('creadoPor', 'actualizadoPor', 'incidenceable')
                                    ->where('incidenceable_type', 'App\Models\CatastroArchivo')
                                    ->when (isset($this->incidenciaTipo) && $this->incidenciaTipo != "", function($q){
                                        return $q->where('tipo', $this->incidenciaTipo);
                                    })
                                    ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
                                    ->paginate($this->pagination);

        return view('livewire.admin.reportes.catastro.reporte-incidencia', compact('incidencias', 'tipos'));
    }
}
