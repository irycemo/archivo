<?php

namespace App\Models;

use App\Models\User;
use App\Models\Solicitud;
use App\Models\CatastroArchivo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatastroArchivoSolicitud extends Model
{
    use HasFactory;

    protected $fillable= ['catastro_archivo_id', 'solicitud_id', 'asignado_a', 'surtidor', 'entregado_en', 'regresado_en', 'entregado_por', 'recibido_por'];

    public function archivo(){
        return $this->belongsTo(CatastroArchivo::class, 'catastro_archivo_id');
    }

    public function solicitud(){
        return $this->belongsTo(Solicitud::class);
    }

    public function repartidor(){
        return $this->belongsTo(User::class, 'surtidor');
    }

    public function entregadoPor(){
        return $this->belongsTo(User::class, 'entregado_por');
    }

    public function recibidoPor(){
        return $this->belongsTo(User::class, 'recibido_por');
    }
}
