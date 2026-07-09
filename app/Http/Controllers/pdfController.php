<?php

namespace App\Http\Controllers;

use App\Models\Caja\Caja;
use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Note;
use App\Models\Facturacion\Ticket;
use App\Models\Package\Encomienda;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class pdfController extends Controller
{
    private const SUNAT_CONSULTA_CPE_URL = 'https://e-consulta.sunat.gob.pe/ol-ti-itconsvalicpe/ConsValiCpe.htm';
    public function ticket80mm(Ticket $ticket)
    {
        $ticket->loadMissing('encomienda');

        $data = [
            'ticket' => $ticket,
            'qrCode' => $this->qrCodeBase64($ticket->encomienda->code, 80),
        ];
        $heigh = 250 + $ticket->details->count() * 8;
        $pdf = Pdf::loadView(
            'pdfs.ticket.80mm',
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
                'title' => $ticket->serie,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                'watermark' => $ticket->encomienda->estado_pago,
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
        return $pdf->stream($ticket->serie . '.pdf');
    }
    public function invoice80mm(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'qrCode' => $this->qrCodeBase64(self::SUNAT_CONSULTA_CPE_URL, 100),
            'sunatConsultaUrl' => self::SUNAT_CONSULTA_CPE_URL,
        ];
        $heigh = 220 + $invoice->details->count() * 8;
        $pdf = Pdf::loadView(
            'pdfs.invoice.80mm',
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
                'title' => $invoice->serie . '-' . $invoice->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => $invoice->encomienda->estado_pago,
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
        return $pdf->stream($invoice->serie . '.pdf');
    }
    public function despache80mm(Despatche $despache)
    {
        $data = [
            'despache' => $despache,
        ];
        $heigh = 370 + $despache->details->count() * 8;
        $pdf = Pdf::loadView(
            'pdfs.despache.80mm',
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
                'title' => $despache->serie . '-' . $despache->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => $despache->encomienda->estado_pago,
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
        return $pdf->stream($despache->serie . '.pdf');
    }
    public function stickerA5(Encomienda $encomienda)
    {
        $encomienda->loadMissing(['remitente', 'destinatario', 'sucursal_destinatario', 'sucursal_remitente', 'paquetes']);

        $data = [
            'encomienda' => $encomienda,
            'qrCode' => $this->qrCodeBase64($encomienda->code, 180),
        ];

        $config = [
            'mode' => '',
            'format' => 'A5-L',
            'default_font_size' => '10',
            'default_font' => 'sans-serif',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'orientation' => 'L',
            'title' => $encomienda->code,
            'author' => 'Abel Arana',
            'creator' => 'Abel Arana',
            'subject' => 'Abel Arana',
            'keywords' => 'Abel Arana',
            'watermark' => $encomienda->estado_pago,
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
            'shrink_tables_to_fit' => 1,
        ];

        $pdf = app('laravel-mpdf')->getPdf($config);
        $pdf->getMpdf()->SetAutoPageBreak(false);
        $pdf->getMpdf()->WriteHTML(view('pdfs.sticker.a6', $data)->render());

        return $pdf->stream($encomienda->code . '.pdf');
    }

    public function ticketA4(Ticket $ticket)
    {
        $data = [
            'ticket' => $ticket,
        ];
        $pdf = Pdf::loadView('pdfs.ticket.ticket-a4', $data);
        return $pdf->stream($ticket->serie . '.pdf');
    }

    public function invoiceA4(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'qrCode' => $this->qrCodeBase64(self::SUNAT_CONSULTA_CPE_URL, 120),
            'sunatConsultaUrl' => self::SUNAT_CONSULTA_CPE_URL,
        ];
        $pdf = Pdf::loadView(
            'pdfs.invoice.a4',
            $data,
            [],
            [
                'mode' => '',
                'format' => 'A4',
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 10,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $invoice->serie . '-' . $invoice->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => 'Abel Arana',
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
        return $pdf->stream($invoice->serie . '.pdf');
    }

    public function despacheA4(Despatche $despache)
    {
        $data = [
            'despache' => $despache,
        ];
        $pdf = Pdf::loadView(
            'pdfs.despache.a4',
            $data,
            [],
            [
                'mode' => '',
                'format' => 'A4',
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 10,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $despache->serie . '-' . $despache->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => $despache->encomienda->estado_pago,
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
        return $pdf->stream($despache->serie . '.pdf');
    }
    public function note80mm(Note $note)
    {
        $data = [
            'note' => $note,
        ];
        $heigh = 220 + $note->details->count() * 8;
        $pdf = Pdf::loadView(
            'pdfs.note.80mm',
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
                'title' => $note->serie . '-' . $note->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => $invoice->encomienda->estado_pago,
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
        return $pdf->stream($note->serie . '.pdf');
    }
    public function noteA4(Note $note)
    {
        $data = [
            'note' => $note,
        ];
        $pdf = Pdf::loadView(
            'pdfs.note.a4',
            $data,
            [],
            [
                'mode' => '',
                'format' => 'A4',
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 10,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $note->serie . '-' . $note->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => $despache->encomienda->estado_pago,
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
        return $pdf->stream($note->serie . '.pdf');
    }
    public function declaracion(Encomienda $encomienda)
    {
        $data = [
            'encomienda' => $encomienda,
        ];
        $pdf = Pdf::loadView(
            'pdfs.documentacion.declaracion',
            $data,
            [],
            [
                'mode' => '',
                'format' => 'A4',
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 10,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => 'Declaración de Envío',
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => 'Abel Arana',
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
        return $pdf->stream($encomienda->code . '.pdf');
    }
    public function caja(Caja $caja)
    {
        //($caja);
        $data = [
            'caja' => $caja,
        ];
        $heigh = 160 + $caja->entries->count() * 4 + $caja->exits->count() * 4;
        $pdf = Pdf::loadView(
            'pdfs.caja.80mm',
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
                'title' => 'Abel Arana',
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                'watermark' => 'Abel Arana',
                'show_watermark' => false,
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

    private function qrCodeBase64(string $content, int $size = 100): string
    {
        return base64_encode(
            QrCode::format('svg')
                ->size($size)
                ->margin(1)
                ->errorCorrection('M')
                ->generate($content)
        );
    }
}
