<?php

namespace App\Http\Livewire\Admin\Reportes\Rpp;

use App\Models\File;
use Livewire\Component;
use App\Models\RppArchivo;

class ReporteDigitalizacion extends Component
{
    public $fecha1;
    public $fecha2;
    public $archivosTotal;
    public $archivosDigitalizados;
    public $digitalizaciones;

    public function render()
    {

        $this->archivosTotal = RppArchivo::when (isset($this->fecha1) && isset($this->fecha2), function($q){
                                                    return $q->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59']);
                                                })
                                                ->count();

        $this->archivosDigitalizados = File::where('fileable_type', 'App\Models\RppArchivo')
                                                ->when (isset($this->fecha1) && isset($this->fecha2), function($q){
                                                    return $q->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59']);
                                                })
                                                ->count();

        if($this->archivosDigitalizados > 0)
            $this->digitalizaciones = ($this->archivosDigitalizados * 100) / $this->archivosTotal;
        else
            $this->digitalizaciones = 0;

        return view('livewire.admin.reportes.rpp.reporte-digitalizacion');
    }
}
