<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\RppArchivo;
use App\Models\CatastroArchivo;
use App\Http\Traits\ModelosTrait;
use App\Models\RppArchivoSolicitud;
use Illuminate\Database\Eloquent\Model;
use App\Models\CatastroArchivoSolicitud;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitud extends Model implements Auditable
{
    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = ['tiempo', 'estado', 'entregado_en', 'regresado_en', 'surtidor', 'ubicacion', 'creado_por', 'actualizado_por', 'numero'];

    public function surtidor(){
        return $this->belongsTo(User::class, 'surtidor');
    }

    public function archivosRpp(){
        return $this->belongsToMany(RppArchivo::class);
    }

    public function archivosCatastro(){
        return $this->belongsToMany(CatastroArchivo::class);
    }

    public function archivosRppSolicitados(){
        return $this->hasMany(RppArchivoSolicitud::class);
    }

    public function archivosCatastroSolicitados(){
        return $this->hasMany(CatastroArchivoSolicitud::class);
    }

    public function getTiempoAttribute(){
        return Carbon::createFromFormat('Y-m-d', $this->attributes['tiempo'])->format('d-m-Y');
    }

}
