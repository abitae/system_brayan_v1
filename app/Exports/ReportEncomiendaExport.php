<?php

namespace App\Exports;

use App\Models\Package\Encomienda;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;

class ReportEncomiendaExport implements FromView, WithColumnWidths, WithStyles
{
    use Exportable;
    public $ids;
    public function __construct($ids)
    {
        $this->ids = $ids;
    }
    public function view(): View
    {
        return view('report.excel.reporte-encomienda', [
            'encomiendas' => Encomienda::with(['remitente', 'destinatario', 'paquetes'])
                ->whereIn('id', $this->ids)
                ->get(),
        ]);
    }
    public function title(): string
    {
        return 'Abel Arana';
    }
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 30,
            'D' => 20,
            'E' => 20,
            'F' => 10,
            'G' => 30,
            'H' => 10,
            'I' => 10,
            'J' => 15,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true,'size' => 16]],
        ];
    }
}
