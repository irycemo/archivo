<?php

namespace App\Http\Controllers\Admin;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class CatastroSolicitudesController extends Controller
{
    public function imprimirLista(Solicitud $solicitud){

        $solicitud->load('creadoPor','archivosCatastroSolicitados.archivo');

        $pdf = Pdf::loadView('solicitudes.lista', compact('solicitud'));

        return $pdf->stream('lista.pdf');

    }
}
