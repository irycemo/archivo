<div class="">

    <div class="mb-5">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Solicitudes</h1>

        <div class="flex justify-between">

            <div>

                <input type="text" wire:model.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

                <select class="bg-white rounded-full text-sm" wire:model="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

            @can('Crear solicitud rpp')


                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right mb-5 text-sm py-2 px-4 text-white rounded-full focus:outline-none hidden md:block">
                    <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Agregar nueva solicitud
                </button>

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right mb-5 text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden">+</button>

            @endcan

        </div>

    </div>

    @if($solicitudes->count())

        <div class="relative overflow-x-auto rounded-lg shadow-xl">

            <table class="rounded-lg w-full">

                <thead class="border-b border-gray-300 bg-gray-50">

                    <tr class="text-xs font-medium text-gray-500 uppercase text-left traling-wider">

                        <th wire:click="order('numero')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            #

                            @if($sort == 'numero')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('tiempo')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Fecha de devolución

                            @if($sort == 'tiempo')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Archivos solicitados

                        </th>

                        <th wire:click="order('estado')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Estado

                            @if($sort == 'estado')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('created_at')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Registro

                            @if($sort == 'created_at')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('updated_at')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Actualizado

                            @if($sort == 'updated_at')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">Acciones</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none ">

                    @foreach($solicitudes as $solicitudd)

                        <tr class="text-sm font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Número</span>

                                {{ $solicitudd->numero }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha de devolución</span>

                                {{ Carbon\Carbon::createFromFormat('Y-m-d', $solicitudd->tiempo)->format('d-m-Y') }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Archivos solicitados</span>

                                 {{ $solicitudd->archivos_rpp_solicitados_count }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                                @if($solicitudd->estado == 'nueva')
                                    <span class="px-2 py-1 bg-blue-400 text-white text-xs rounded-full capitalize">{{ $solicitudd->estado }}</span>
                                @elseif($solicitudd->estado == 'aceptada')
                                    <span class="px-2 py-1 bg-green-400 text-white text-xs rounded-full capitalize">{{ $solicitudd->estado }}</span>
                                @elseif($solicitudd->estado == 'rechazada')
                                    <span class="px-2 py-1 bg-red-400 text-white text-xs rounded-full capitalize">{{ $solicitudd->estado }}</span>
                                @elseif($solicitudd->estado == 'entregada')
                                    <span class="px-2 py-1 bg-yellow-400 text-white text-xs rounded-full capitalize">{{ $solicitudd->estado }}</span>
                                @elseif($solicitudd->estado == 'regresada')
                                    <span class="px-2 py-1 bg-gray-400 text-white text-xs rounded-full capitalize">{{ $solicitudd->estado }}</span>
                                @endif

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>

                                @if($solicitudd->creadoPor != null)

                                    <span class="font-semibold">Registrado por: {{$solicitudd->creadoPor->name}}</span> <br>

                                @endif

                                {{ $solicitudd->created_at }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Actualizado</span>

                                @if($solicitudd->actualizadoPor != null)

                                    <span class="font-semibold">Actualizado por: {{$solicitudd->actualizadoPor->name}}</span> <br>

                                @endif

                                {{ $solicitudd->updated_at }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                                <div class="flex justify-center lg:justify-start">

                                    @if ($solicitudd->estado != 'nueva')
                                        @can('Ver solicitud rpp')

                                            <button
                                                wire:click="abrirModalVer({{$solicitudd->id}})"
                                                wire:loading.attr="disabled"
                                                wire:target="abrirModalVer({{$solicitudd->id}})"
                                                class="bg-green-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-2 rounded-full mr-2 hover:bg-green-700 flex focus:outline-none"
                                            >

                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>

                                                <p>Ver</p>

                                            </button>

                                        @endcan

                                    @endif

                                    @can('Editar solicitud rpp')

                                        @if ($solicitudd->estado == 'nueva')

                                            <button
                                                wire:click="abrirModalEditar({{$solicitudd->id}})"
                                                wire:loading.attr="disabled"
                                                wire:target="abrirModalEditar({{$solicitudd->id}})"
                                                class="bg-blue-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-2 rounded-full mr-2 hover:bg-blue-700 flex focus:outline-none"
                                            >

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>

                                                <p>Editar</p>

                                            </button>

                                        @endif

                                    @endcan

                                    @if ($solicitudd->estado == 'nueva' || $solicitudd->estado == 'aceptada')

                                        @can('Borrar solicitud rpp')

                                            <button
                                                wire:click="abrirModalBorrar({{$solicitudd}})"
                                                wire:loading.attr="disabled"
                                                wire:target="abrirModalBorrar({{$solicitudd}})"
                                                class="bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-2 rounded-full hover:bg-red-700 flex focus:outline-none"
                                            >

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>

                                                <p>Eliminar</p>

                                            </button>

                                        @endcan

                                    @endif

                                </div>

                            </td>
                        </tr>

                    @endforeach

                </tbody>

                <tfoot class="border-gray-300 bg-gray-50">

                    <tr>

                        <td colspan="10" class="py-2 px-5">
                            {{ $solicitudes->links()}}
                        </td>

                    </tr>

                </tfoot>

            </table>

            <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-0 left-0" wire:loading wire:target="search">

                <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

            </div>

        </div>

    @else

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-full text-lg">

            No hay resultados.

        </div>

    @endif

    <x-jet-dialog-modal wire:model="modal">

        <x-slot name="title">

            @if($crear)
                Nueva Solicitud
            @elseif($editar)
                Editar Solicitud
            @endif

        </x-slot>

        <x-slot name="content">

            <h4 class="font-bold tracking-wider">Busqueda de tomos</h4>

            <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                <div class="flex-auto ">

                    <div>

                        <Label>Tomo</Label>
                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-sm w-full" wire:model.defer="tomo">

                    </div>

                    <div>

                        @error('tomo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div>

                        <Label>Sección</Label>

                    </div>

                    <div>

                        <select class="bg-white rounded text-sm w-full" wire:model.defer="seccion">

                            <option value="" selected>Seleccione una opción</option>

                            @foreach ($secciones as $seccion)

                                <option value="{{ $seccion }}" selected>{{ $seccion }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        @error('seccion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div>

                        <Label>Distrito</Label>
                    </div>

                    <div>

                        <select class="bg-white rounded text-sm w-full" wire:model.defer="distrito">

                            <option value="" selected>Seleccione una opción</option>
                            <option value="1" selected>1</option>
                            <option value="2" selected>2</option>
                            <option value="3" selected>3</option>
                            <option value="4" selected>4</option>
                            <option value="5" selected>5</option>
                            <option value="6" selected>6</option>
                            <option value="7" selected>7</option>
                            <option value="8" selected>8</option>
                            <option value="9" selected>9</option>
                            <option value="10" selected>10</option>
                            <option value="11" selected>11</option>
                            <option value="12" selected>12</option>
                            <option value="13" selected>13</option>
                            <option value="14" selected>14</option>
                            <option value="15" selected>15</option>
                            <option value="16" selected>16</option>
                            <option value="17" selected>17</option>
                            <option value="18" selected>18</option>
                            <option value="19" selected>19</option>

                        </select>

                    </div>

                    <div>

                        @error('distrito') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <Label>Bis</Label>
                    </div>

                    <div class="flex space-x-2 items-center">

                        <input type="text" class="bg-white rounded text-sm w-full" wire:model.defer="bis">

                        <button
                            type="button"
                            wire:click="buscarArchivo"
                            wire:loading.attr="disabled"
                            wire:target="buscarArchivo"
                            class="bg-blue-400 text-white hover:shadow-lg font-bold px-4 py-2 rounded-full text-sm hover:bg-blue-700 mr-1 focus:outline-none">
                            Buscar
                        </button>

                    </div>

                    <div>

                        @error('bis') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

            </div>

            @if ($archivo)

                <h4 class="font-bold tracking-wider">Resultado de la busqueda</h4>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <div class="flex-auto ">

                        <div>

                            <Label>Tomo</Label>
                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" value="{{ $archivo->tomo }}" readonly>

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Bis</Label>
                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" value="{{ $archivo->tomo_bis }}" readonly>

                        </div>

                    </div>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <div class="flex-auto ">

                        <div>

                            <Label>Asignar a</Label>
                        </div>

                        <div class="flex space-x-2 items-center">

                            <select class="bg-white rounded text-sm w-full" wire:model.defer="empleado">

                                <option value="">Seleccione un archivo</option>

                                @foreach ($empleados as $key => $trabajador)

                                    <option value="{{ $key }}">{{ $trabajador['nombre'] }}</option>

                                @endforeach

                            </select>

                            <button
                                type="button"
                                wire:click="solicitar({{ $empleado }})"
                                wire:loading.attr="disabled"
                                wire:target="solicitar({{ $empleado }})"
                                class="bg-green-400 text-white hover:shadow-lg font-bold px-4 py-2 rounded-full text-sm hover:bg-green-700 mr-1 focus:outline-none">
                                Solicitar
                            </button>

                        </div>

                        <div>

                            @error('empleado') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

            @endif

            @if ($solicitud)

                <h4 class="font-bold tracking-wider">
                    Tomos a solicitar
                </h4>

                <div class="overflow-x-auto">

                    <table class="rounded-lg shadow-xl w-full overflow-hidden table-auto  xl:table-fixed">

                        <thead class="border-b border-gray-300 bg-gray-50">

                            <tr class="text-xs text-gray-500 uppercase text-left traling-wider">
                                <th class="px-2 py-3">Tomo / Archivo</th>
                                <th class="px-2 py-3">Asignado A</th>
                                <th></th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forEach($solicitud->archivosRppSolicitados as $item)

                                    <tr class="text-sm text-gray-500 bg-white">
                                        <td class="px-2 py-3 w-full text-gray-800 text-sm">
                                            {{ $item->archivo->tomo }} {{ $item->archivo->tomo_bis ? ' / ' .$item->archivo->tomo_bis : '' }}
                                        </td><td class="px-2 py-3 w-full text-gray-800 text-sm">
                                            {{ $item->asignado_a }}
                                        </td>
                                        <td>
                                            <button
                                                wire:click="removerArchivo({{ $item->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="removerArchivo({{ $item->id }})"
                                                type="button"
                                                class="bg-red-400 hover:shadow-lg text-white text-xs font-bold px-2 py-1 rounded-full  mb-2 hover:bg-red-700 flaot-left focus:outline-none">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>

                            @endforEach

                        </tbody>

                    </table>

                </div>

            @endif

            <div>

                @error('solicitud') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="float-righ">

                @if($crear && $solicitud)

                    <button
                        wire:click="resetearTodo"
                        wire:loading.attr="disabled"
                        wire:target="resetearTodo"
                        class="bg-blue-400 text-white hover:shadow-lg font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-blue-700 flaot-left mr-1 focus:outline-none">
                        <img wire:loading wire:target="resetearTodo" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        Finalizar solicitud
                    </button>

                @elseif($editar)

                    @if($solicitud->estado == 'nueva')

                        @can('Aceptar solicitud rpp')

                            <button
                                wire:click="aceptarRechazar({{ $solicitud->id }} , 'aceptar')"
                                wire:loading.attr="disabled"
                                wire:target="aceptarRechazar({{ $solicitud->id }} , 'aceptar')"
                                class="bg-green-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-green-700 flaot-left mr-1 focus:outline-none">
                                <img wire:loading wire:target="aceptarRechazar({{ $solicitud->id }} , 'aceptar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                Aceptar
                            </button>

                        @endcan

                        @can('Rechazar solicitud rpp')

                            <button
                                wire:click="aceptarRechazar({{ $solicitud->id }},  'rechazar')"
                                wire:loading.attr="disabled"
                                wire:target="aceptarRechazar({{ $solicitud->id }},  'rechazar')"
                                type="button"
                                class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-red-700 flaot-left focus:outline-none">
                                <img wire:loading wire:target="aceptarRechazar({{ $solicitud->id }},  'rechazar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                Rechazar
                            </button>

                        @endcan

                    @endif

                @endif

                <button
                    wire:click="resetearTodo"
                    wire:loading.attr="disabled"
                    wire:target="resetearTodo"
                    type="button"
                    class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-red-700 flaot-left focus:outline-none">
                    Cerrar
                </button>

            </div>

        </x-slot>

    </x-jet-dialog-modal>

    <x-jet-confirmation-modal wire:model="modalBorrar">

        <x-slot name="title">
            Eliminar Solicitud
        </x-slot>

        <x-slot name="content">
            ¿Está seguro que desea eliminar la solicitud? No será posible recuperar la información.
        </x-slot>

        <x-slot name="footer">

            <x-jet-secondary-button
                wire:click="$toggle('modalBorrar')"
                wire:loading.attr="disabled"
            >
                No
            </x-jet-secondary-button>

            <x-jet-danger-button
                class="ml-2"
                wire:click="borrar()"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-jet-danger-button>

        </x-slot>

    </x-jet-confirmation-modal>

    <x-jet-dialog-modal wire:model="modalVer">

        <x-slot name="title">

            <p>Solicitud: {{ $solicitud ? $solicitud->numero : '' }}</p>

        </x-slot>

        <x-slot name="content">

            @if($solicitud)

                <div class="overflow-x-auto">

                    <table class="rounded-lg shadow-xl w-full overflow-hidden table-auto  xl:table-fixed">

                        <thead class="border-b border-gray-300 bg-gray-50">

                            <tr class="text-xs text-gray-500 uppercase text-left traling-wider">
                                <th class="px-2 py-3">Tomo  Cuenta</th>
                                <th class="px-2 py-3">Asignado A</th>
                                <th class="px-2 py-3">Entregado el</th>
                                <th class="px-2 py-3">Regresado el</th>
                                <th>Surtidor</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($solicitud->archivosRppSolicitados as $archivoSolicitado)

                                <tr class="text-sm text-gray-500 bg-white">

                                    <td class="px-2 py-3 w-full text-gray-800 text-sm">
                                        {{ $archivoSolicitado->archivo->tomo }}  {{ $archivoSolicitado->archivo->tomo_bis ? ' / ' . $archivoSolicitado->archivo->tomo_bis : ''}}
                                    </td>
                                    <td class="px-2 py-3 w-full text-gray-800 text-sm">
                                        {{ $archivoSolicitado->asignado_a }}
                                    </td>
                                    <td class="px-2 py-3 w-full text-gray-800 text-sm">
                                        @if($archivoSolicitado->entregadoPor != null)

                                            <span class="font-semibold">Entregado por: {{$archivoSolicitado->entregadoPor->name}}</span> <br>

                                        @endif
                                        {{ optional($archivoSolicitado->entregado_en)->format('d-m-Y H:i:s') }}
                                    </td>
                                    <td class="px-2 py-3 w-full text-gray-800 text-sm">
                                        @if($archivoSolicitado->recibidoPor != null)

                                            <span class="font-semibold">Recibido por: {{$archivoSolicitado->recibidoPor->name}}</span> <br>

                                        @endif
                                        {{ optional($archivoSolicitado->regresado_en)->format('d-m-Y H:i:s') }}
                                    </td>
                                    <td class="px-2 py-3 w-full text-gray-800 text-sm">
                                        {{ $archivoSolicitado->repartidor ?  $archivoSolicitado->repartidor->name : 'Sin asignar'}}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </x-slot>

        <x-slot name="footer">

            @if($solicitud && $solicitud->estado == 'aceptada')

                @can('Entregar solicitud rpp')

                    <button
                        wire:click="entregarRecibir({{ $solicitud->id }} , 'entregar')"
                        wire:loading.attr="disabled"
                        wire:target="entregarRecibir({{ $solicitud->id }} , 'entregar')"
                        class="bg-green-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-green-700 flaot-left mr-1 focus:outline-none">
                        <img wire:loading wire:target="entregarRecibir({{ $solicitud->id }} , 'entregar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        Entregar
                    </button>

                @endcan

            @endif

            @if($solicitud && $solicitud->estado == 'entregada')

                <button
                    wire:click="entregarRecibir({{ $solicitud->id }},  'recibir')"
                    wire:loading.attr="disabled"
                    wire:target="entregarRecibir({{ $solicitud->id }},  'recibir')"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-blue-700 flaot-left focus:outline-none">
                    <img wire:loading wire:target="entregarRecibir({{ $solicitud->id }},  'recibir')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Recibir
                </button>

            @endif

            <button
                wire:click="resetearTodo"
                wire:loading.attr="disabled"
                wire:target="resetearTodo"
                type="button"
                class="bg-red-400 hover:shadow-lg ml-2 text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-red-700 flaot-left focus:outline-none">
                <img wire:loading wire:target="resetearTodo" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                Cerrar
            </button>

        </x-slot>

    </x-jet-dialog-modal>

</div>

