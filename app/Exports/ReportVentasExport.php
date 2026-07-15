<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportVentasExport implements FromView, WithColumnWidths, WithStyles
{
    use Exportable;

    public function __construct(
        public array $rows,
        public string $companyName,
        public Carbon $periodoInicio,
        public Carbon $periodoFin,
    ) {}

    public function view(): View
    {
        return view('report.excel.reporte-ventas', [
            'rows' => $this->rows,
            'companyName' => $this->companyName,
            'periodoInicio' => $this->periodoInicio,
            'periodoFin' => $this->periodoFin,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 14,
            'B' => 16,
            'C' => 14,
            'D' => 12,
            'E' => 12,
            'F' => 12,
            'G' => 5,
            'H' => 14,
            'I' => 14,
            'J' => 36,
            'K' => 28,
            'L' => 12,
            'M' => 16,
            'N' => 16,
            'O' => 16,
            'P' => 16,
            'Q' => 10,
            'R' => 14,
            'S' => 18,
            'T' => 18,
            'U' => 12,
            'V' => 14,
            'W' => 12,
            'X' => 12,
            'Y' => 12,
            'Z' => 14,
            'AA' => 14,
            'AB' => 28,
            'AC' => 16,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle('A1:AC7')->getFont()->setBold(true);
        $sheet->getStyle('A5:AC7')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
        $sheet->getStyle('A5:AC'.$highestRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('M9:U'.$highestRow)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('L9:L'.$highestRow)->getNumberFormat()->setFormatCode('#,##0.000');

        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            3 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
