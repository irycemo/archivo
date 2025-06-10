<?php

namespace App\Exports;

use App\Models\Incidence;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class IncidenciasCatastroExport implements FromCollection,  WithProperties, WithDrawings, ShouldAutoSize, WithEvents, WithCustomStartCell, WithColumnWidths, WithHeadings, WithMapping
{

    public $incidenciaTipo;
    public $fecha1;
    public $fecha2;

    public function __construct($incidenciaTipo, $fecha1, $fecha2)
    {
        $this->incidenciaTipo = $incidenciaTipo;
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Incidence::with('creadoPor', 'actualizadoPor', 'incidenceable')
                            ->where('incidenceable_type', 'App\Models\CatastroArchivo')
                            ->when (isset($this->incidenciaTipo) && $this->incidenciaTipo != "", function($q){
                                return $q->where('tipo', $this->incidenciaTipo);
                            })
                            ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2])
                            ->get();
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(storage_path('app/public/img/logo2.png'));
        $drawing->setHeight(90);
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function headings(): array
    {
        return [
            'Cuenta',
            'Tipo',
            'Observaciones',
            'Registrado por',
            'Actualizado por',
            'Registrado en',
            'Actualizado en'
        ];
    }

    public function map($incidence): array
    {
        return [
            $incidence->incidenceable->localidad . '-' . $incidence->incidenceable->oficina . '-' . $incidence->incidenceable->tipo . '-' . $incidence->incidenceable->registro,
            $incidence->tipo,
            $incidence->observaciones,
            $incidence->creado_por ? $incidence->creadoPor->name : 'N/A',
            $incidence->actualizado_por ? $incidence->actualizadoPor->name : 'N/A',
            $incidence->created_at,
            $incidence->updated_at,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->name,
            'title'          => 'Reporte de Incidencias (Sistema de Archivo)',
            'company'        => 'Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->setCellValue('A1', "Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo\nReporte de incidencias (Sistema de Archivo)\n" . now()->format('d-m-Y'));
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 13
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
                ]);
                $event->sheet->getRowDimension('1')->setRowHeight(90);
                $event->sheet->getStyle('A2:G2')->applyFromArray([
                        'font' => [
                            'bold' => true
                        ]
                    ]
                );
            },
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function columnWidths(): array
    {
        return [
            'E' => 20,
            'F' => 20,

        ];
    }
}
