<?php

namespace App\Models;

use App\Models\RppArchivo;
use App\Models\CatastroArchivo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitud extends Model
{
    use HasFactory;

    protected $fillable = ['tiempo', 'solicitante', 'estado', 'entregado_en', 'regresado_en', 'surtidor', 'ubicacion', 'creado_por', 'actualizado_por'];

    public function solicitante(){
        return $this->belongsTo(User::class, 'solicitante');
    }

    public function surtidor(){
        return $this->belongsTo(User::class, 'surtidor');
    }

    public function archivosRpp(){
        return $this->belongsToMany(RppArchivo::class);
    }

    public function archivosCatastro(){
        return $this->belongsToMany(CatastroArchivo::class);
    }
}
