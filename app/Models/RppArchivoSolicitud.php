<?php

namespace App\Models;

use App\Models\User;
use App\Models\Solicitud;
use App\Models\RppArchivo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RppArchivoSolicitud extends Model
{
    use HasFactory;

    protected $casts = [
        'entregado_en' => 'datetime:d-m-Y H:i:s',
        'regresado_en' => 'datetime:d-m-Y H:i:s',
        'archivos' => 'array'
    ];

    protected $fillable= ['rpp_archivo_id', 'solicitud_id', 'asignado_a', 'surtidor', 'entregado_en', 'regresado_en', 'entregado_por', 'recibido_por'];

    public function archivo(){
        return $this->belongsTo(RppArchivo::class, 'rpp_archivo_id');
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
