<?php

namespace App\Observers;

use App\Models\CatastroArchivoSolicitud;

class CatastroArchivoSolicitado
{
    public function deleting(CatastroArchivoSolicitud $archivoSolicitado){

        $archivoSolicitado->load('archivo');

        $archivoSolicitado->archivo->update(['estado' => 'disponible']);

    }

}
