<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatastroArchivo extends Model implements Auditable
{
    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['estado','tomo','localidad', 'oficina', 'tipo', 'registro', 'folio', 'tarjeta', 'creado_por', 'actualizado_por'];

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
