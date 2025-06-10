<?php

namespace App\Models;

use App\Http\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    use ModelosTrait;

    protected $fillable = ['fileable_id', 'fileable_type', 'url', 'creado_por', 'actualizado_por'];

    public function fileable(){
        return $this->morphTo();
    }
}
