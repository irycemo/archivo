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
            $solicitudesRecibidas = Solicitud::where('estado', 'regresada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRechazadas = Solicitud::where('estado', 'rechazada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesVencidas = Solicitud::where('estado', 'entregada')->where('tiempo', '<', now()->toDateString())->get();

            $solicitadosRpp = RppArchivo::where('estado', 'solicitado')->count();
            $solicitadosCatastro = CatastroArchivo::where('estado', 'solicitado')->count();
            $solicitados = $solicitadosCatastro + $solicitadosRpp;
            $ocupadosRpp = RppArchivo::where('estado', 'ocupado')->count();
            $ocupadosCatastro = CatastroArchivo::where('estado', 'ocupado')->count();
            $ocupados = $ocupadosRpp + $ocupadosCatastro;
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
            $solicitudesVencidas = Solicitud::where('ubicacion', 'RPP')->where('estado', 'entregada')->where('tiempo', '<', now()->toDateString())->get();
            $solicitudes_vencidas_solicitante = Solicitud::where('creado_por', auth()->user()->id)->where('estado', 'entregada')->where('tiempo', '<', now()->toDateString())->get();

            $solicitados = RppArchivo::where('estado', 'solicitado')->count();
            $ocupados = RppArchivo::where('estado', 'ocupado')->count();
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
                                                'archivosDigitalizados',
                                                'solicitudes_vencidas_solicitante'
                                            ));

        }elseif(auth()->user()->localidad == 'Catastro'){

            $solicitudesTotal = Solicitud::where('ubicacion', 'Catastro')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesNuevas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'nueva')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesEntregadas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'entregada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRecibidas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'regresada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesRechazadas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'rechazada')->whereMonth('created_at', Carbon::now()->month)->count();
            $solicitudesVencidas = Solicitud::where('ubicacion', 'Catastro')->where('estado', 'entregada')->where('tiempo', '<', now()->toDateString())->get();
            $solicitudes_vencidas_solicitante = Solicitud::where('creado_por', auth()->user()->id)->where('estado', 'entregada')->where('tiempo', '<', now()->toDateString())->get();

            $solicitados = CatastroArchivo::where('estado', 'solicitado')->count();
            $ocupados = CatastroArchivo::where('estado', 'ocupado')->count();
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
                                                'archivosDigitalizados',
                                                'solicitudes_vencidas_solicitante'
                                            ));

        }

    }
}
