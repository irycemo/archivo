<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\File;
use App\Models\Incidence;
use App\Models\Solicitud;
use App\Models\RppArchivo;
use App\Models\CatastroArchivo;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke(){

        if(auth()->user()->hasRole('Administrador')){

            $solicitudesTotal = Solicitud::whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesNuevas = Solicitud::where('estado', 'nueva')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesEntregadas = Solicitud::where('estado', 'entregada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRecibidas = Solicitud::where('estado', 'recibida')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRechazadas = Solicitud::where('estado', 'rechazada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesVencidas = Solicitud::where('estado', 'entregada')->where('tiempo', '>', now()->subDays(30))->get();

            $solicitados = RppArchivo::where('estado', 'solicitado')->whereMonth('created_at', Carbon::now()->month)->count();
            $ocupados = RppArchivo::where('estado', 'ocupado')->whereMonth('created_at', Carbon::now()->month)->count();
            $incidencias = Incidence::whereMonth('created_at', Carbon::now()->month)->count();
            $archivosDigitalizados = File::whereMonth('created_at', Carbon::now()->month)->count();



            return view('dashboard', compact(
                                                'solicitudesTotal',
                                                'solicitudesNuevas',
                                                'solicitudesEntregadas',
                                                'solicitudesRecibidas',
                                                'solicitudesRechazadas',
                                                'solicitudesVencidas',
                                                'solicitados',
                                                'ocupados',
                                                'incidencias',
                                                'archivosDigitalizados'
                                            ));

        }elseif(auth()->user()->localidad == 'RPP'){

            $solicitudesTotal = Solicitud::where('ubicacion', 'RPP')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesNuevas = Solicitud::where('ubicacion', 'RPP')->where('estado', 'nueva')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesEntregadas = Solicitud::where('ubicacion', 'RPP')->where('estado', 'entregada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRecibidas = Solicitud::where('ubicacion', 'RPP')->where('estado', 'regresada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRechazadas = Solicitud::where('ubicacion', 'RPP')->where('estado', 'rechazada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesVencidas = Solicitud::where('ubicacion', 'RPP')->where('estado', 'entregada')->where('tiempo', '>', now()->subDays(30))->get();

            $solicitados = RppArchivo::where('estado', 'solicitado')->whereMonth('created_at', Carbon::now()->month)->count();
            $ocupados = RppArchivo::where('estado', 'ocupado')->whereMonth('created_at', Carbon::now()->month)->count();
            $incidencias = Incidence::whereHas('creadoPor', function($q){
                                                                            return $q->where('localidad', 'RPP');
                                                                        })
                                    ->whereMonth('created_at', Carbon::now()->month)->count();
            $archivosDigitalizados = File::whereHas('creadoPor', function($q){
                                                                            return $q->where('localidad', 'RPP');
                                                                        })
                                            ->whereMonth('created_at', Carbon::now()->month)->count();

            return view('dashboard', compact(
                                                'solicitudesTotal',
                                                'solicitudesNuevas',
                                                'solicitudesEntregadas',
                                                'solicitudesRecibidas',
                                                'solicitudesRechazadas',
                                                'solicitudesVencidas',
                                                'solicitados',
                                                'ocupados',
                                                'incidencias',
                                                'archivosDigitalizados'
                                            ));

        }elseif(auth()->user()->localidad == 'Catastro'){

            $solicitudesTotal = Solicitud::where('ubicacion', 'Catastro')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesNuevas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'nueva')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesEntregadas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'entregada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRecibidas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'regresada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRechazadas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'rechazada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesVencidas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'entregada')->where('tiempo', '>', now()->subDays(15))->get();

            $solicitados = CatastroArchivo::where('estado', 'solicitado')->whereMonth('created_at', Carbon::now()->month)->count();
            $ocupados = CatastroArchivo::where('estado', 'ocupado')->whereMonth('created_at', Carbon::now()->month)->count();
            $incidencias = Incidence::whereHas('creadoPor', function($q){
                                                                return $q->where('localidad', 'Catastro');
                                                            })
                                    ->whereMonth('created_at', Carbon::now()->month)
                                    ->count();
            $archivosDigitalizados = File::whereHas('creadoPor', function($q){
                                                                            return $q->where('localidad', 'Catastro');
                                                                        })
                                            ->whereMonth('created_at', Carbon::now()->month)->count();

            return view('dashboard', compact(
                                                'solicitudesTotal',
                                                'solicitudesNuevas',
                                                'solicitudesEntregadas',
                                                'solicitudesRecibidas',
                                                'solicitudesRechazadas',
                                                'solicitudesVencidas',
                                                'solicitados',
                                                'ocupados',
                                                'incidencias',
                                                'archivosDigitalizados'
                                            ));

        }

    }
}
