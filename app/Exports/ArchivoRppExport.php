<?php

namespace App\Exports;

use App\Models\RppArchivo;

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

class ArchivoRppExport implements FromCollection,  WithProperties, WithDrawings, ShouldAutoSize, WithEvents, WithCustomStartCell, WithColumnWidths, WithHeadings, WithMapping
{

    public $archivoEstado;
    public $bis;
    public $seccion;
    public $distrito;
    public $fecha1;
    public $fecha2;

    public function __construct($archivoEstado, $bis, $seccion, $distrito, $fecha1, $fecha2)
    {
        $this->archivoEstado = $archivoEstado;
        $this->bis = $bis;
        $this->seccion = $seccion;
        $this->distrito = $distrito;
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RppArchivo::with('creadoPor', 'actualizadoPor')
                            ->when (isset($this->archivoEstado) && $this->archivoEstado != "", function($q){
                                return $q->where('estado', $this->archivoEstado);
                            })
                            ->when (isset($this->bis) && $this->bis != "", function($q){
                                return $q->where('tomo_bis', $this->bis);
                            })
                            ->when (isset($this->seccion) && $this->seccion != "", function($q){
                                return $q->where('seccion', $this->seccion);
                            })
                            ->when (isset($this->distrito) && $this->distrito != "", function($q){
                                return $q->where('distrito', $this->distrito);
                            })
                            ->whereBetween('created_at', [$this->fecha1 . ' 00:00:00', $this->fecha2 . ' 23:59:59'])
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
            'Estado',
            'Tomo',
            'Bis',
            'Sección',
            'Distrito',
            'Registrado por',
            'Actualizado por',
            'Registrado en',
            'Actualizado en'
        ];
    }

    public function map($archivo): array
    {
        return [
            ucfirst($archivo->estado),
            $archivo->tomo,
            $archivo->tomo_bis ? $archivo->tomo_bis : 'N/A',
            $archivo->seccion,
            $archivo->distrito,
            $archivo->creado_por ? $archivo->creadoPor->name : 'N/A',
            $archivo->actualizado_por ? $archivo->actualizadoPor->name : 'N/A',
            $archivo->created_at,
            $archivo->updated_at,
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->name,
            'title'          => 'Reporte de Archivos (Sistema de Archivo)',
            'company'        => 'Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->setCellValue('A1', "Instituto Registral Y Catastral Del Estado De Michoacán De Ocampo\nReporte de archivos (Sistema de Archivo)\n" . now()->format('d-m-Y'));
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A1:I1')->applyFromArray([
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
                $event->sheet->getStyle('A2:I2')->applyFromArray([
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
