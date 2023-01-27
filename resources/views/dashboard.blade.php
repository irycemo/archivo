@extends('layouts.admin')

@section('content')

    <div class=" mb-10">

        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Estadisticas del mes actual de solictudes</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">

            <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-blue-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-bold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $solicitudesTotal }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">Total</h5>

                </div>

                @if (auth()->user()->localidad = 'RPP')

                    <a href="{{ route('rpp_solicitudes')}}" class="mx-auto rounded-full border border-blue-600 py-1 px-4 text-blue-500 hover:bg-blue-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @else

                    <a href="{{ route('catastro_solicitudes') }}" class="mx-auto rounded-full border border-blue-600 py-1 px-4 text-blue-500 hover:bg-blue-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @endif


            </div>

            <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-green-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-bold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $solicitudesNuevas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">Nuevas</h5>

                </div>

                @if (auth()->user()->localidad = 'RPP')

                    <a href="{{ route('rpp_solicitudes') . "?search=nueva" }}" class="mx-auto rounded-full border border-green-600 py-1 px-4 text-green-500 hover:bg-green-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @else

                    <a href="{{ route('catastro_solicitudes') . "?search=nueva" }}" class="mx-auto rounded-full border border-green-600 py-1 px-4 text-green-500 hover:bg-green-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @endif

            </div>

            <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-indigo-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-bold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $solicitudesEntregadas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">Entregadas</h5>

                </div>

                @if (auth()->user()->localidad = 'RPP')

                    <a href="{{ route('rpp_solicitudes') . "?search=entregada" }}" class="mx-auto rounded-full border border-indigo-600 py-1 px-4 text-indigo-500 hover:bg-indigo-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @else

                    <a href="{{ route('catastro_solicitudes') . "?search=entregada" }}" class="mx-auto rounded-full border border-indigo-600 py-1 px-4 text-indigo-500 hover:bg-indigo-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @endif

            </div>

            <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-yellow-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-bold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $solicitudesRecibidas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">Recibidas</h5>

                </div>

                @if (auth()->user()->localidad = 'RPP')

                    <a href="{{ route('rpp_solicitudes') . "?search=regresada" }}" class="mx-auto rounded-full border border-yellow-600 py-1 px-4 text-yellow-500 hover:bg-yellow-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @else

                    <a href="{{ route('catastro_solicitudes') . "?search=regresada" }}" class="mx-auto rounded-full border border-yellow-600 py-1 px-4 text-yellow-500 hover:bg-yellow-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @endif

            </div>

            <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-red-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-bold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $solicitudesRechazadas }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">REchazadas</h5>

                </div>

                @if (auth()->user()->localidad = 'RPP')

                    <a href="{{ route('rpp_solicitudes') . "?search=rechazada" }}" class="mx-auto rounded-full border border-red-600 py-1 px-4 text-red-500 hover:bg-red-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @else

                    <a href="{{ route('catastro_solicitudes') . "?search=rechazada" }}" class="mx-auto rounded-full border border-red-600 py-1 px-4 text-red-500 hover:bg-red-600 hover:text-white transition-all ease-in-out"> Ver solicitudes</a>

                @endif

            </div>

        </div>

    </div>

    <div class=" mb-10">

        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Estadisticas del mes actual de archivos</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-yellow-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-bold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $solicitados }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">Solicitados</h5>

                </div>

                @if (auth()->user()->localidad = 'RPP')

                    <a href="{{ route('distribuidor_rpp') }}" class="mx-auto rounded-full border border-yellow-600 py-1 px-4 text-yellow-500 hover:bg-yellow-600 hover:text-white transition-all ease-in-out"> Ver archivos</a>

                @else

                    <a href="{{ route('distribuidor_catastro')  }}" class="mx-auto rounded-full border border-yellow-600 py-1 px-4 text-yellow-500 hover:bg-yellow-600 hover:text-white transition-all ease-in-out"> Ver archivos</a>

                @endif


            </div>

            <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-red-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="  mb-2 items-center">

                    <span class="font-bold text-2xl text-blueGray-600 mb-2">

                        <p>{{ $ocupados }}</p>

                    </span>

                    <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">Ocupados</h5>

                </div>

                @if (auth()->user()->localidad = 'RPP')

                    <a href="{{ route('rpp_archivos') . "?search=ocupado"  }}" class="mx-auto rounded-full border border-red-600 py-1 px-4 text-red-500 hover:bg-red-600 hover:text-white transition-all ease-in-out"> Ver archivos</a>

                @else

                    <a href="{{ route('catastro_archivos') . "?search=ocupado"  }}" class="mx-auto rounded-full border border-red-600 py-1 px-4 text-red-500 hover:bg-red-600 hover:text-white transition-all ease-in-out"> Ver archivos</a>

                @endif

            </div>

            <div class="flex md:block justify-evenly items-center space-x-2 border-t-4 border-orange-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="h-full m-auto flex items-center justify-center">

                    <div>

                        <span class="font-bold text-2xl text-blueGray-600 mb-2">

                            <p>{{ $incidencias }}</p>

                        </span>

                        <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">Incidencias</h5>

                    </div>

                </div>

            </div>

            <div class=" justify-evenly items-center space-x-2 border-t-4 border-green-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white text-center">

                <div class="h-full m-auto flex items-center justify-center">

                    <div>

                        <span class="font-bold text-2xl text-blueGray-600 mb-2">

                            <p>{{ $archivosDigitalizados }}</p>

                        </span>

                        <h5 class="text-blueGray-400 uppercase font-semibold text-center  tracking-widest md:tracking-normal">Digitalizaciones</h5>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
