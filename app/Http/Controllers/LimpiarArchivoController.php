<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatastroArchivo;
use Illuminate\Support\Facades\Http;

class LimpiarArchivoController extends Controller
{

    public function __invoke()
    {

        $predios = CatastroArchivo::whereNotNull('creado_por')->get();

        try {

            foreach($predios as $predio){

                $sgc = Http::acceptJson()->get('http://10.0.253.223:8095/sgcpredio.asmx/sgc_predio?tipo=1&locl='. $predio->localidad .'&ofna=101&tpre='. $predio->tipo . '&nreg='. $predio->registro)->collect();

                $a = json_decode($sgc);

                if($a->message == "Predio no existe, favor de verificar"){

                    $predio->delete();

                    info('El predio ' . $predio->localidad . '-101-' . $predio->tipo . '-' . $predio->registro . ' no existe.');

                }

            }

            return "Limpieza completa";

        } catch (\Throwable $th) {
            info($th);
        }

    }
}
