<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportContableExport implements FromView, WithColumnWidths, WithStyles
{
    use Exportable;

    public function __construct(
        public array $rows,
        public float $totalBase,
        public float $totalIgv,
        public float $totalVentas,
    ) {}

    public function view(): View
    {
        return view('report.excel.reporte-contable', [
            'rows' => $this->rows,
            'totalBase' => $this->totalBase,
            'totalIgv' => $this->totalIgv,
            'totalVentas' => $this->totalVentas,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 14,
            'B' => 16,
            'C' => 18,
            'D' => 14,
            'E' => 16,
            'F' => 30,
            'G' => 14,
            'H' => 12,
            'I' => 12,
            'J' => 12,
            'K' => 12,
            'L' => 14,
            'M' => 14,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }
}
