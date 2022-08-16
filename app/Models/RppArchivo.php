<?php

namespace App\Models;

use App\Models\File;
use App\Models\Incidence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RppArchivo extends Model
{
    use HasFactory;

    protected $fillable = ['tomo', 'tomo_bis', 'seccion', 'distrito', 'estado', 'creado_por', 'actualizado_por'];

    public function archivo(){
        return $this->morphTo(File::class, 'fileable');
    }

    public function incidencia(){
        return $this->morphTo(Incidence::class);
    }
}
