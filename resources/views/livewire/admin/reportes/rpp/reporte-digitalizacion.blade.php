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

    <div class="md:flex md:flex-row flex-col md:space-x-4 items-end  rounded-xl mb-5 p-4">

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
                        {{ $digitalizaciones }}%
                    </span>

                </span>

            </div>

        </div>

    </div>

</div>
