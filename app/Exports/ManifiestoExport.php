<?php

namespace App\Exports;

use App\Models\Package\Encomienda;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ManifiestoExport implements FromView, WithColumnWidths, WithStyles
{
    use Exportable;
    public $ids;
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function view(): View
    {
        return view('report.excel.manifiesto', [
            'encomienda' => Encomienda::query()->whereIn('id', $this->ids)->first(),
            'encomiendas' => Encomienda::query()->whereIn('id', $this->ids)->where('isHome', false)->get(),
            'encomiendasIsHome' => Encomienda::query()->whereIn('id', $this->ids)->where('isHome', true)->get(),
            'encomiendasIsReturn' => Encomienda::query()->whereIn('id', $this->ids)->where('isReturn', true)->get(),
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
            'C' => 50,
            'D' => 20,
            'E' => 40,
            'F' => 10,
            'G' => 50,
            'H' => 10,
            'I' => 10,
            'J' => 15,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
            1 => ['font' => ['size' => 16]],
            7 => ['font' => ['bold' => true]],
            // Styling a specific cell by coordinate.
            'B2' => ['font' => ['bold' => true]],
            'B3' => ['font' => ['bold' => true]],
            'B4' => ['font' => ['bold' => true]],
            'B5' => ['font' => ['bold' => true]],
            'D2' => ['font' => ['bold' => true]],
            'D3' => ['font' => ['bold' => true]],
            'D4' => ['font' => ['bold' => true]],
            'D5' => ['font' => ['bold' => true]],

        ];
    }
}
