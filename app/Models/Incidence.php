<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Incidence extends Model implements Auditable
{
    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['tipo', 'observaciones', 'incidenceable_id', 'incidenceable_type', 'creado_por', 'actualizado_por'];

    public function incidenceable(){
        return $this->morphTo();
    }
}
