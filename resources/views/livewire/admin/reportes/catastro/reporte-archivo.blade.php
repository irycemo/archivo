<div>

    <div class="md:flex md:flex-row flex-col md:space-x-4 items-end bg-white rounded-xl mb-5 p-4">

        <div>

            <div>

                <Label>Fecha inicial</Label>

            </div>

            <div>

                <input type="date" class="bg-white rounded text-sm " wire:model="fecha1">

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

                <input type="date" class="bg-white rounded text-sm " wire:model="fecha2">

            </div>

            <div>

                @error('fecha2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

    <div class="md:flex flex-col md:flex-row justify-between md:space-x-3 items-center bg-white rounded-xl mb-5 p-4">

        <div class="flex-auto ">

            <div>

                <Label>Estado</Label>
            </div>

            <div>

                <select class="rounded text-sm w-full" wire:model="archivoEstado">

                    <option value="" selected>Seleccione una opción</option>
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

                <select class="rounded text-sm w-full" wire:model="archivoTarjeta">

                    <option value="" selected>Seleccione una opción</option>
                    <option value="1" selected>Con tarjeta</option>
                    <option value="0" selected>Sin tarjeta</option>

                </select>

            </div>

            <div>

                @error('archivoTarjeta') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

    @if(count($archivos))

        <div class="rounded-lg shadow-xl mb-5 p-4 font-thin md:flex items-center justify-between bg-white">

            <p class="text-xl font-extralight">Se encontraron: {{ number_format($archivos->total()) }} registros con los filtros seleccionados.</p>

            <button wire:loading.attr="disabled" wire:click="descargarExcel" class="text-white flex items-center border rounded-full px-4 py-2 bg-green-500 hover:bg-green-700 mt-2 md:mt-0 w-full md:w-auto justify-center">

                <img wire:loading wire:target="descargarExcel" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

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

                    @foreach($archivos as $archivo)

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

                                @if($archivo->actualizado_por != null)

                                    <span class="font-semibold">Actualizado por: {{$archivo->actualizadoPor->name}}</span> <br>

                                @endif

                                {{ $archivo->updated_at }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

                <tfoot class="border-gray-300 bg-gray-50">

                    <tr>

                        <td colspan="1" class="py-2 px-5">

                            <select class="bg-white rounded-full text-sm" wire:model="pagination">

                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>

                            </select>

                        </td>

                        <td colspan="20" class="py-2 px-5">
                            {{ $archivos->links()}}
                        </td>

                    </tr>

                </tfoot>

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

</div>
