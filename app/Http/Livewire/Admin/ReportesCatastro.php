<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class ReportesCatastro extends Component
{

    public $area;
    public $fecha1;
    public $fecha2;

    public $verArchivos;
    public $verIncidencias;
    public $verDigitalizacion;

    public function updatedArea(){

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

    public function render()
    {

        return view('livewire.admin.reportes-catastro')->extends('layouts.admin');
    }
}
