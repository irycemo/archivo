<div>

    <h1 class="titulo-seccion text-3xl font-thin text-gray-500 mb-3">Reportes</h1>

    <div class="p-4 mb-5 bg-white shadow-xl rounded-lg">

        <div>

            <Label>Área</Label>

        </div>

        <div>

            <select class="bg-white rounded text-sm mb-3" wire:model="area">
                <option selected>Selecciona una área</option>
                <option value="archivos">Archivos</option>
                <option value="incidencias">Incidencias</option>
                <option value="digitalizacion">Digitalización</option>


            </select>

        </div>

        <div class="mb-5 md:flex md:flex-row flex-col md:space-x-4">

            <div>

                <div>

                    <Label>Fecha inicial</Label>

                </div>

                <div>

                    <input type="date" class="bg-white rounded text-sm " wire:model.defer="fecha1">

                </div>

                <div>

                    @error('fecha1') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="mt-2 md:mt-0">

                <div>

                    <Label>Fecha final</Label>

                </div>

                <div>

                    <input type="date" class="bg-white rounded text-sm " wire:model.defer="fecha2">

                </div>

                <div>

                    @error('fecha2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </div>

        @if ($verArchivos)

            <div class="md:flex flex-col md:flex-row justify-between md:space-x-3 items-center">

                <div class="flex-auto ">

                    <div>

                        <Label>Estado</Label>
                    </div>

                    <div>

                        <select class="rounded text-sm w-full" wire:model.defer="archivoEstado">

                            <option value="" selected>Seleccione un estado</option>
                            <option value="disponible" selected>Disponible</option>
                            <option value="ocupado" selected>Ocupado</option>
                            <option value="solicitado" selected>Solicitado</option>

                        </select>

                    </div>

                    <div>

                        @error('archivoEstado') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <Label>Tarjeta</Label>
                    </div>

                    <div>

                        <select class="rounded text-sm w-full" wire:model.defer="archivoTarjeta">

                            <option value="" selected>Seleccione una opción</option>
                            <option value="1" selected>Con tarjeta</option>
                            <option value="0" selected>Sin tarjeta</option>

                        </select>

                    </div>

                    <div>

                        @error('archivoTarjeta') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div>
                    <button
                        class="bg-blue-500 hover:shadow-lg hover:bg-blue-700  text-sm py-2 px-4 text-white rounded-full focus:outline-none mt-3 w-full"
                        wire:click="filtrarArchivos"
                        wire:loading.attr="disabled"
                        wire:target="filtrarArchivos"
                    >
                        Filtrar
                    </button>

                </div>

            </div>

        @endif

        @if ($verIncidencias)

            <div class="md:flex flex-col md:flex-row justify-between md:space-x-3 items-center">

                <div class="flex-auto ">

                    <div>

                        <Label>Tipo</Label>
                    </div>

                    <div>

                        <select class="rounded text-sm w-full" wire:model.defer="incidenciaTipo">

                            <option value="" selected>Seleccione una opción</option>

                            @foreach ($incidencias as $incidencia)

                                <option value="{{$incidencia}}" >{{$incidencia}}</option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        @error('incidenciaTipo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div>
                    <button
                        class="bg-blue-500 hover:shadow-lg hover:bg-blue-700  text-sm py-2 px-4 text-white rounded-full focus:outline-none mt-3 w-full"
                        wire:click="filtrarIncidencias"
                        wire:loading.attr="disabled"
                        wire:target="filtrarIncidencias"
                    >
                        Filtrar
                    </button>

                </div>

            </div>

        @endif

        @if ($verDigitalizacion)

            <div class="md:flex flex-col md:flex-row justify-between md:space-x-3 items-center">

                <div>
                    <button
                        class="bg-blue-500 hover:shadow-lg hover:bg-blue-700  text-sm py-2 px-4 text-white rounded-full focus:outline-none mt-3 w-full"
                        wire:click="filtrarDigitalizaciones"
                        wire:loading.attr="disabled"
                        wire:target="filtrarDigitalizaciones"
                    >
                        Consultar porcentaje de digitalización
                    </button>

                </div>

            </div>

        @endif

    </div>

    @if ($archivos_filtrados)

        @if(count($archivos_filtrados))

            <div class="rounded-lg shadow-xl mb-5 p-4 font-thin md:flex items-center justify-between bg-white">

                <p class="text-xl font-extralight">Se encontraron: {{ count($archivos_filtrados) }} registros con los filtros seleccionados.</p>

                <button wire:click="descargarExcel('archivos')" class="text-white flex items-center border rounded-full px-4 py-2 bg-green-500 hover:bg-green-700 mt-2 md:mt-0 w-full md:w-auto justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>

                    Exportar a Excel

                </button>

            </div>

            <div class="relative overflow-x-auto rounded-lg shadow-xl">

                <table class="rounded-lg w-full">

                    <thead class="border-b border-gray-300 bg-gray-50">

                        <tr class="text-xs font-medium text-gray-500 uppercase text-left traling-wider">

                            <th class=" px-3 hidden lg:table-cell py-2">

                                Estado

                            </th>

                            <th class=" px-3 hidden lg:table-cell py-2">

                                Tomo

                            </th>

                            <th class=" px-3 hidden lg:table-cell py-2">

                                Localidad

                            </th>

                            <th class=" px-3 hidden lg:table-cell py-2">

                                Oficina
                            </th>

                            <th class=" px-3 hidden lg:table-cell py-2">

                                Tipo

                            </th>

                            <th class=" px-3 hidden lg:table-cell py-2">

                                Predio

                            </th>

                            <th class=" px-3 hidden lg:table-cell py-2">

                                Folio

                            </th>

                            <th class=" px-3 hidden lg:table-cell py-2">

                                Tarjeta

                            </th>

                            <th class="px-3 py-3 hidden lg:table-cell">

                                Registro

                            </th>

                            <th class="px-3 py-3 hidden lg:table-cell">

                                Actualizado

                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none">

                        @foreach($archivos_filtrados as $archivo)

                            <tr class="text-sm font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 text-center">

                                <td class="p-2 w-full lg:w-auto text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                                    @if($archivo->estado == 'disponible')
                                        <span class="bg-green-400 px-2 py-1 text-xs rounded-full capitalize text-white">{{ $archivo->estado }}</span>
                                    @elseif($archivo->estado == 'solicitado')
                                        <span class="px-2 py-1 bg-yellow-400 text-white text-xs rounded-full capitalize">{{ $archivo->estado }}</span>
                                    @else
                                        <span class="bg-red-400 px-2 py-1 text-xs rounded-full capitalize text-white">{{ $archivo->estado }}</span>
                                    @endif

                                </td>

                                <td class="p-2 w-full lg:w-auto text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tomo</span>

                                    @if ($archivo->tomo)
                                        {{ $archivo->tomo }}
                                    @else
                                        N/A
                                    @endif

                                </td>

                                <td class="p-2 w-full lg:w-auto text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Localidad</span>

                                    {{ $archivo->localidad }}

                                </td>

                                <td class="p-2 w-full lg:w-auto text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden  absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Oficina</span>

                                    {{ $archivo->oficina }}

                                </td>

                                <td class="p-2 w-full lg:w-auto text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo</span>

                                    {{ $archivo->tipo }}

                                </td>

                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Predio</span>

                                    {{ $archivo->registro }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                                    {{ $archivo->folio }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center  lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tarjeta</span>

                                    @if($archivo->tarjeta)
                                        <span class="bg-green-400 px-2 py-1 text-xs rounded-full capitalize text-white">Si</span>
                                    @else
                                        <span class="bg-red-400 px-2 py-1 text-xs rounded-full capitalize text-white">No</span>
                                    @endif

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>

                                    @if($archivo->creadoPor != null)

                                        <span class="font-semibold">Registrado por: {{$archivo->creadoPor->name}}</span> <br>

                                    @endif

                                    {{ $archivo->created_at }}

                                </td>

                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Actualizado</span>

                                    @if($archivo->updated_by != null)

                                        <span class="font-semibold">Actualizado por: {{$archivo->updatedBy->name}}</span> <br>

                                    @endif

                                    {{ $archivo->updated_at }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-0 left-0" wire:loading wire:target="permisos_filtrados">

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

            </div>

        @else

            <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                No hay resultados.

            </div>

        @endif

    @endif

    @if ($incidencias_filtradas)

        @if(count($incidencias_filtradas))

            <div class="rounded-lg shadow-xl mb-5 p-4 font-thin md:flex items-center justify-between bg-white">

                <p class="text-xl font-extralight">Se encontraron: {{ count($incidencias_filtradas) }} registros con los filtros seleccionados.</p>

                <button wire:click="descargarExcel('incidencias')" class="text-white flex items-center border rounded-full px-4 py-2 bg-green-500 hover:bg-green-700 mt-2 md:mt-0 w-full md:w-auto justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>

                    Exportar a Excel

                </button>

            </div>

            <div class="relative overflow-x-auto rounded-lg shadow-xl">

                <table class="rounded-lg w-full">

                    <thead class="border-b border-gray-300 bg-gray-50">

                        <tr class="text-xs font-medium text-gray-500 uppercase text-left traling-wider">

                            <th class="px-3 py-3 hidden lg:table-cell">

                                Cuenta

                            </th>

                            <th  class="px-3 py-3 hidden lg:table-cell">

                                Tipo

                            </th>

                            <th class="px-3 py-3 hidden lg:table-cell">

                                Observaciones

                            </th>

                            <th class="px-3 py-3 hidden lg:table-cell">

                                Registro

                            </th>

                            <th class="px-3 py-3 hidden lg:table-cell">

                                Actualizado

                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none">

                        @foreach($incidencias_filtradas as $incidencia)

                            <tr class="text-sm font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 text-center">

                                <td class="w-full lg:w-auto p-3 text-gray-800  md:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta</span>

                                    {{ $incidencia->incidenceable->localidad }}-{{ $incidencia->incidenceable->oficina }}-{{ $incidencia->incidenceable->tipo }}-{{ $incidencia->incidenceable->registro }}

                                </td>

                                <td class="w-full lg:w-auto p-3 text-gray-800  md:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo</span>

                                    {{ $incidencia->tipo }}

                                </td>

                                <td class="capitalize w-full lg:w-auto p-3 text-gray-800  md:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Observaciones</span>

                                    {{ $incidencia->observaciones }}

                                </td>

                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>

                                    @if($incidencia->created_by != null)

                                        <span class="font-semibold">Registrado por: {{$incidencia->createdBy->name}}</span> <br>

                                    @endif

                                    {{ $incidencia->created_at }}

                                </td>

                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Actualizado</span>

                                    @if($incidencia->updated_by != null)

                                        <span class="font-semibold">Actualizado por: {{$incidencia->updatedBy->name}}</span> <br>

                                    @endif

                                    {{ $incidencia->updated_at }}

                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-0 left-0" wire:loading wire:target="incapacidades_filtradas">

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

            </div>

        @else

            <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                No hay resultados.

            </div>

        @endif

    @endif

    @if ($digitalizaciones_filtradas)

        <div class="mb-10">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <div class=" border-t-4 border-red-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white">

                    <div class="flex  mb-2 items-center">

                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">

                            <h5 class="text-blueGray-400 uppercase font-semibold   tracking-widest ">Total de archivos</h5>

                        </div>

                        <div class="relative w-auto  flex-initial overflow-hidden">

                            <div class="text-white  text-center inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-500">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>

                            </div>

                        </div>

                    </div>

                    <span class="font-bold text-3xl text-blueGray-600">

                        <span>
                        {{ $archivosTotal }}
                        </span>

                    </span>

                </div>

                <div class=" border-t-4 border-blue-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white">

                    <div class="flex  mb-2 items-center">

                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">

                            <h5 class="text-blueGray-400 uppercase font-semibold   tracking-widest ">Digitalizados</h5>

                        </div>

                        <div class="relative w-auto  flex-initial overflow-hidden">

                            <div class="text-white  text-center inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-500">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                  </svg>


                            </div>

                        </div>

                    </div>

                    <span class="font-bold text-2xl text-blueGray-600">

                        <span class="text-3xl">
                            {{ $archivosDigitalizados }}
                        </span>

                    </span>

                </div>

                <div class=" border-t-4 border-green-400 p-4 shadow-xl text-gray-600 rounded-xl bg-white">

                    <div class="flex  mb-2 items-center">

                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">

                            <h5 class="text-blueGray-400 uppercase font-semibold   tracking-widest ">% De digitalización</h5>

                        </div>

                        <div class="relative w-auto  flex-initial overflow-hidden">

                            <div class="text-white  text-center inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-500">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185zM9.75 9h.008v.008H9.75V9zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 4.5h.008v.008h-.008V13.5zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                  </svg>


                            </div>

                        </div>

                    </div>

                    <span class="font-bold text-3xl text-blueGray-600">

                        <span>
                            {{ $digitalizaciones_filtradas }}%
                        </span>

                    </span>

                </div>

            </div>

        </div>

    @endif

</div>
