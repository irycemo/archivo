<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use App\Models\File;
use App\Models\Incidence;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RppArchivo extends Model implements Auditable
{
    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = ['tomo', 'tomo_bis', 'seccion', 'distrito', 'estado', 'creado_por', 'actualizado_por', 'formacion', 'observaciones', 'registro'];

    public function archivo(){
        return $this->morphOne(File::class, 'fileable');
    }

    public function incidencia(){
        return $this->morphMany(Incidence::class, 'incidenceable');
    }

    protected $auditEvents = [
        'deleted',
    ];

}
