<?php

namespace App\Http\Livewire\Admin;

use App\Models\Audit;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ComponentesTrait;

class Auditoria extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $evento;
    public $modelo;
    public $selecetedAudit;
    public $modelos = [
        'App\Models\CatastroArchivo',
        'App\Models\RppArchivo',
        'App\Models\Incidence',
        'App\Models\User',
        'App\Models\Solicitud',
    ];

    public function ver($audit){

        $this->selecetedAudit = $audit;

        $this->modal = true;

    }

    public function render()
    {

        $audits = Audit::with('user')
                            ->when(isset($this->evento) && $this->evento != "", function($q){
                                return $q->where('event', $this->evento);

                            })
                            ->when(isset($this->modelo) && $this->modelo != "", function($q){
                                return $q->where('auditable_type', $this->modelo);

                            })
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);


        return view('livewire.admin.auditoria', compact('audits'))->extends('layouts.admin');
    }

}
