<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceExport implements FromView, WithColumnWidths, WithStyles
{
    use Exportable;

    public function __construct(
        public Collection $invoices,
        public float $totalBase,
        public float $totalIgv,
        public float $totalVentas,
    ) {}

    public function view(): View
    {
        return view('report.excel.reporte-invoice', [
            'invoices' => $this->invoices,
            'totalBase' => $this->totalBase,
            'totalIgv' => $this->totalIgv,
            'totalVentas' => $this->totalVentas,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 14,
            'C' => 18,
            'D' => 18,
            'E' => 14,
            'F' => 30,
            'G' => 14,
            'H' => 12,
            'I' => 14,
            'J' => 12,
            'K' => 12,
            'L' => 12,
            'M' => 14,
            'N' => 14,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true]],
        ];
    }
}
