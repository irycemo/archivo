<?php

namespace App\Observers;

use App\Models\RppArchivoSolicitud;

class RppArchivoSolicitado
{

    public function deleting(RppArchivoSolicitud $archivoSolicitado){

        $archivoSolicitado->load('archivo');

        $archivoSolicitado->archivo->update(['estado' => 'disponible']);

    }

}
