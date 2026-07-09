<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuiaTransportistaExport implements FromView, WithColumnWidths, WithStyles
{
    use Exportable;
    public $despatches;
    public function __construct($despatches)
    {
        $this->despatches = $despatches;
    }
    public function view(): View
    {
        return view('report.excel.reporte-guia-transportista', [
            'despatches' => $this->despatches
        ]);
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}