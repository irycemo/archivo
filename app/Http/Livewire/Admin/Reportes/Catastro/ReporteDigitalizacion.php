<?php

namespace App\Http\Livewire\Admin\Reportes\Catastro;

use App\Http\Traits\ComponentesTrait;
use App\Models\File;
use Livewire\Component;
use App\Models\CatastroArchivo;
use Livewire\WithPagination;

class ReporteDigitalizacion extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $fecha1;
    public $fecha2;
    public $archivosTotal;
    public $archivosDigitalizados;
    public $digitalizaciones;

    public function render()
    {

        $this->archivosTotal = CatastroArchivo::when (isset($this->fecha1) && isset($this->fecha2), function($q){
                                                    return $q->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59']);
                                                })
                                                ->count();

        $this->archivosDigitalizados = File::where('fileable_type', 'App\Models\CatastroArchivo')
                                                ->when (isset($this->fecha1) && isset($this->fecha2), function($q){
                                                    return $q->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59']);
                                                })
                                                ->count();

        if($this->archivosDigitalizados > 0)
            $this->digitalizaciones = ($this->archivosDigitalizados * 100) / $this->archivosTotal;
        else
            $this->digitalizaciones = 0;

        return view('livewire.admin.reportes.catastro.reporte-digitalizacion');
    }
}
