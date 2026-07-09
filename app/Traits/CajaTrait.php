<?php
namespace App\Traits;

use App\Models\Caja\Caja;
use App\Models\Caja\EntryCaja;
use App\Models\Caja\ExitCaja;
use App\Models\User;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Pdf;
trait CajaTrait
{
    /*
     *   Función para obtener la caja abierta
     */
    function cajaIsActive(User $user)
    {
        return Caja::where('user_id', $user->id)
            ->where('isActive', true)
            ->latest()->first();
    }
    /*
     *   Función para obtener la caja cerrada
     */
    function cajaListPaginate(User $user, $paginate)
    {
        return Caja::where('user_id', $user->id)
            ->with(['entries', 'exits'])
            ->latest()->paginate($paginate);
    }
    /*
     *   Función para agregar entrada
     */
    function cajaEntry(int $caja_id, float $monto, string $description,string $metodo_pago, string $tipo)
    {
        $entry = EntryCaja::create([
            'caja_id' => $caja_id,
            'monto_entry' => $monto,
            'description' => $description,
            'metodo_pago' => $metodo_pago,
            'tipo_entry' => $tipo,
        ]);
        return $entry;
    }

    /*
     *   Función para agregar exit
     */
    function cajaExit(int $caja_id, float $monto, string $description,string $metodo_pago, string $tipo)
    {
        $exit = ExitCaja::create([
            'caja_id' => $caja_id,
            'monto_exit' => $monto,
            'description' => $description,
            'metodo_pago' => $metodo_pago,
            'tipo_exit' => $tipo,
        ]);
        return $exit;
    }
    /*
     *   Función para crear entrada o salida de caja
     */

    /*
     *   Función para imprimir reporte de caja
     */
    public function cajaPrint(Caja $caja)
    {
        $data = [
            'caja' => $caja,
        ];
        $heigh = 250 + $caja->entries->count() * 8;
        $pdf = Pdf::loadView(
            'pdfs.caja.caja',
            $data,
            [],
            [
                'mode' => '',
                'format' => [80, $heigh],
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 1,
                'margin_right' => 10,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $caja->id,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                'watermark' => $caja->id,
                'show_watermark' => true,
                'show_watermark_image' => false,
                'watermark_font' => 'sans-serif',
                'display_mode' => 'fullpage',
                'watermark_text_alpha' => 0.1,
                'watermark_image_path' => '',
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
                'custom_font_dir' => '',
                'custom_font_data' => [],
                'auto_language_detection' => false,
                'temp_dir' => storage_path('app'),
                'pdfa' => false,
                'pdfaauto' => false,
                'use_active_forms' => false,
            ]
        );
        return $pdf->stream($caja->id . '.pdf');
    }
}
