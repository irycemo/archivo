<div>

    <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Reportes</h1>

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

    </div>

    @if ($verArchivos)

        @livewire('admin.reportes.rpp.reporte-archivo', ['fecha1' => $this->fecha1, 'fecha2' => $this->fecha2])

    @endif

    @if ($verIncidencias)

        @livewire('admin.reportes.rpp.reporte-incidencia', ['fecha1' => $this->fecha1, 'fecha2' => $this->fecha2])

    @endif

    @if ($verDigitalizacion)

        @livewire('admin.reportes.rpp.reporte-digitalizacion', ['fecha1' => $this->fecha1, 'fecha2' => $this->fecha2])

    @endif

</div>
