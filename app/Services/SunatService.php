<?php
namespace App\Services;

use App\Models\Configuration\Company as ModelsCompany;
use DateTime;
use Greenter\Api;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Driver;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Despatch\Vehicle;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Report\HtmlReport;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SunatService
{
    //See emicion de Facturas/Boletas/Notas
    public function getSee($company)
    {
        $see = new See();
        $see->setCertificate(Storage::get($company->cert_path));
        $see->setService($company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA);
        $see->setClaveSOL($company->ruc, $company->sol_user, $company->sol_pass);
        return $see;
    }
    //Api de Guias de Remicion
    public function getSeeApi($company)
    {
        $api = new Api(
            $company->production ?
            [
                'auth' => 'https://api-seguridad.sunat.gob.pe/v1',
                'cpe'  => 'https://api-cpe.sunat.gob.pe/v1',
            ] : [
                'auth' => 'https://gre-test.nubefact.com/v1',
                'cpe'  => 'https://gre-test.nubefact.com/v1',
            ]
        );
        $api->setBuilderOptions([
            'strict_variables' => true,
            'optimization'     => 0,
            'debug'            => true,
            'cache'            => false,
        ])->setApiCredentials(
            $company->production ? $company->client_id : "test-85e5b0ae-255c-4891-a595-0b98c65c9854",
            $company->production ? $company->client_secret : "test-Hty/M6QshYvPgItX2P0+Kw=="
        )->setClaveSOL(
            $company->ruc,
            $company->production ? $company->sol_user : 'MODDATOS',
            $company->production ? $company->sol_pass : 'MODDATOS'
        )->setCertificate(
            Storage::get($company->cert_path)
        );
        return $api;
    }
    //Facturas/Boletas
    public function getInvoce($data)
    {
        //dd($data);
        $invoice = (new Invoice())
            ->setTipoOperacion($data->tipoOperacion ?? null)
            ->setFormaPago(new FormaPagoContado());

        $invoice = $this->setCommonInvoiceData($invoice, $data);

        if ($data->tipoOperacion == '1001') {
            $invoice->setDetraccion(
                (new Detraction())
                    ->setCodBienDetraccion('021')
                    ->setCodMedioPago('001')
                    ->setCtaBanco('0004-3342343243')
                    ->setPercent($data->setPercent)
                    ->setMount($data->setMount)
            );
        }

        return $invoice;
    }
    private function setCommonInvoiceData($invoice, $data)
    {
        return $invoice
            ->setUblVersion($data['ublVersion'] ?? '2.1')
            ->setTipoDoc($data['tipoDoc'] ?? null)
            ->setSerie($data['serie'] ?? null)
            ->setCorrelativo($data['correlativo'] ?? null)
            ->setFechaEmision(new DateTime($data['fechaEmision']) ?? null)
            ->setTipoMoneda($data['tipoMoneda'] ?? null)
            ->setCompany($this->getCompany($data['company']))
            ->setClient($this->getClient($data['client']))
            ->setMtoOperGravadas($data['mtoOperGravadas'])
            ->setMtoIGV($data['mtoIGV'])
            ->setTotalImpuestos($data['totalImpuestos'])
            ->setValorVenta($data['valorVenta'])
            ->setSubTotal($data['subTotal'])
            ->setRedondeo($data['redondeo'])
            ->setMtoImpVenta($data['mtoImpVenta'])
            ->setDetails($this->getDetails($data['details']))
            ->setLegends($this->getLegends($data));
    }

    //Notas de Credito/Debito
    public function getNote($data)
    {
        $note = (new Note())
            ->setTipDocAfectado($data['tipDocAfectado'] ?? null)
            ->setNumDocfectado($data['numDocfectado'] ?? null)
            ->setCodMotivo($data['codMotivo'] ?? null)
            ->setDesMotivo($data['desMotivo'] ?? null)
            ->setMtoOperExoneradas($data['mtoOperExoneradas'])
            ->setMtoOperInafectas($data['mtoOperInafecto'])
            ->setMtoOperExportacion($data['mtoOperExportacion'])
            ->setMtoOperGratuitas($data['mtoOperGratuitas'])
            ->setMtoIGVGratuitas($data['mtoIGVGratuitas'])
            ->setIcbper($data['icbper']);

        return $this->setCommonInvoiceData($note, $data);
    }
    //Guias de Remicion/Transportista
    public function getDespatch($data)
    {
        return (new Despatch)
            ->setVersion($data['version'] ?? '2022')
            ->setTipoDoc($data['tipoDoc'] ?? '09')
            ->setSerie($data['serie'] ?? null)
            ->setCorrelativo($data['correlativo'] ?? null)
            ->setFechaEmision(new DateTime($data['fechaEmision']) ?? null) // Zona horaria: Lima
            ->setCompany($this->getCompany($data['company']))
            ->setDestinatario($this->getClient($data['destinatario']))
            ->setEnvio($this->getEnvio($data['envio']))
            ->setDetails($this->getDespatchDetails($data['details']))
        ;
    }
    public function getCompany($data)
    {
        $company = (new Company())
            ->setRuc($data->ruc ?? null)
            ->setRazonSocial($data->razonSocial ?? null)
            ->setNombreComercial($data->nombreComercial ?? null)
            ->setAddress($this->getAddress($data->address));
        return $company;
    }
    public function getAddress($data)
    {
        $address = (new Address())
            ->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setUrbanizacion('-')
            ->setDireccion('PJ. LOS PEDREGALES MZA. D LOTE. 4 GRU.SECTOR 3 LOS PEDREGAL   JUNíN -  HUANCAYO  -  EL TAMBO')
            ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.
        return $address;
    }
    public function getClient($data)
    {
        $client = new Client();
        $client->setTipoDoc($data->type_code ?? null);
        $client->setNumDoc($data->code ?? $data->numDoc ?? null);
        $client->setRznSocial($data->name ?? null);
        $client->setAddress($this->getAddress($data->address));
        return $client;
    }

    public function getDetails($datas)
    {
        $green_details = [];
        foreach ($datas as $data) {
            $green_details[] = (new SaleDetail())
                ->setTipAfeIgv($data->tipAfeIgv ?? null) // Gravado Op. Onerosa - Catalog. 07
                ->setCodProducto($data->codProducto ?? null)
                ->setUnidad($data->unidad ?? null) // Unidad - Catalog. 03
                ->setCantidad($data->cantidad ?? null)
                ->setMtoValorUnitario($data->mtoValorUnitario ?? null)
                ->setDescripcion($data->descripcion ?? null)
                ->setMtoBaseIgv($data->mtoBaseIgv ?? null)
                ->setPorcentajeIgv($data->porcentajeIgv ?? null) // 18%
                ->setIgv($data->igv ?? null)
                ->setFactorIcbper($data->factorIcbper ?? null)
                ->setIcbper($data->icbper ?? null)
                ->setTotalImpuestos($data->totalImpuestos ?? null) // Suma de impuestos en el detalle
                ->setMtoValorVenta($data->mtoValorVenta ?? null)
                ->setMtoPrecioUnitario($data->mtoPrecioUnitario ?? null);
        }
        return $green_details;
    }
    public function getLegends($data)
    {
        $gree_legends = [
            ["code" => "1000", "value" => $data->monto_letras],
        ];

        if ($data->tipoOperacion == '1001') {
            $gree_legends[] = ["code" => "2006", "value" => "Operación sujeta a detracción"];
        }

        return $gree_legends;
    }
    //guias
    public function getEnvio($data)
    {

        $shipment = (new Shipment)
            ->setCodTraslado($data['codTraslado'] ?? null)               //catalogo 20 sunat
            ->setModTraslado($data['modTraslado'] ?? null)               //catalogo 18 sunat
            ->setFecTraslado(new DateTime($data['fecTraslado'] ?? null)) // Zona horaria: Lima
            ->setPesoTotal($data['pesoTotal'] ?? null)
            ->setUndPesoTotal($data['undPesoTotal'] ?? null) //catalogo 02 sunat
            ->setLlegada(new Direction($data['llegada']['ubigueo'], $data['llegada']['direccion']))
            ->setPartida(new Direction($data['partida']['ubigueo'], $data['partida']['direccion']));
        if ($data['modTraslado'] == '01') {
            $shipment->setTransportista($this->getTransportista($data['transportista']));
        }
        if ($data['modTraslado'] == '02') {
            $shipment->setVehiculo($this->getVehiculo($data['vehiculos']) ?? null)
                ->setChoferes($this->getChoferes($data['choferes']) ?? null);
        }
        return $shipment;
    }
    public function getTransportista($data)
    {
        return (new Transportist())
            ->setTipoDoc($data['ruc'] ?? null)
            ->setNumDoc($data['numDoc'] ?? null)
            ->setRznSocial($data['rznSocial'] ?? null)
            ->setNroMtc($data['nroMtc'] ?? null);
    }
    public function getVehiculo($vehiculos)
    {
        $vehiculos   = collect($vehiculos);
        $secundarios = [];
        foreach ($vehiculos->slice(1) as $item) {
            $secundarios[] = (new Vehicle())
                ->setPlaca($item['placa'] ?? null);
        }

        return (new Vehicle())
            ->setPlaca($vehiculos->first()['placa'] ?? null)
            ->setSecundarios($secundarios);
    }
    public function getChoferes($choferes)
    {
        $choferes  = collect($choferes);
        $drivers   = [];
        $drivers[] = (new Driver)
            ->setTipo('Principal')
            ->setTipoDoc($choferes->first()['tipoDoc'] ?? null)
            ->setNroDoc($choferes->first()['nroDoc'] ?? null)
            ->setLicencia($choferes->first()['licencia'] ?? null)
            ->setNombres($choferes->first()['nombres'] ?? null)
            ->setApellidos($choferes->first()['apellidos'] ?? null);
        foreach ($choferes->slice(1) as $item) {
            $drivers[] = (new Driver)
                ->setTipo('Secundario')
                ->setTipoDoc($item['tipoDoc'] ?? null)
                ->setNroDoc($item['nroDoc'] ?? null)
                ->setLicencia($item['licencia'] ?? null)
                ->setNombres($item['nombres'] ?? null)
                ->setApellidos($item['apellidos'] ?? null);
        }
        return $drivers;
    }
    public function getDespatchDetails($details)
    {
        $green_details = [];
        foreach ($details as $data) {
            $green_details[] = (new DespatchDetail())
                ->setCantidad($data['cantidad'] ?? null)
                ->setUnidad($data['unidad'] ?? null) // Unidad - Catalog. 03
                ->setDescripcion($data['descripcion'] ?? null)
                ->setCodigo($data['codigo'] ?? null);
        }
        return $green_details;
    }
    //Sunat response
    public function sunatResponse($result)
    {
        $response['success'] = $result->isSuccess();
        if (! $response['success']) {
            $response['error'] = [
                'code'    => $result->getError()->getCode(),
                'message' => $result->getError()->getMessage(),
            ];
            return $response;
        }

        $cdr = $result->getCdrResponse();

        $response['cdrResponse'] = [
            'code'        => (int) $cdr->getCode(),
            'description' => $cdr->getDescription(),
            'notes'       => $cdr->getNotes(),
            'cdrZip'      => base64_encode($result->getCdrZip()),
        ];

        return $response;
    }
    public function getHtmlReport2($invoice)
    {
        $report   = new HtmlReport();
        $resolver = new DefaultTemplateResolver();
        $report->setTemplate($resolver->getTemplate($invoice));
        $ruc     = $invoice->getCompany()->getRuc();
        $company = ModelsCompany::where('ruc', $ruc)
            ->where('user_id', Auth::user()->id)
            ->first();
        $params = [
            'system' => [
                'logo' => Storage::get($company->logo_path), // Logo de Empresa
                'hash' => 'qqnr2dN4p/HmaEA/CJuVGo7dv5g=',    // Valor Resumen
            ],
            'user'   => [
                'header' => 'Telf: <b>(01) 123375</b>', // Texto que se ubica debajo de la dirección de empresa
                'extras' => [
                    // Leyendas adicionales
                    ['name' => 'CONDICION DE PAGO', 'value' => 'Efectivo'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
                'footer' => '<p>Nro Resolucion: <b>3232323</b></p>',
            ],
        ];
        $html = $report->render($invoice, $params);
        return $html;
    }
    public function getHtmlReport($invoice)
    {
        $report = new HtmlReport();
        $resolver = new DefaultTemplateResolver();
        $report->setTemplate($resolver->getTemplate($invoice));
        $ruc = $invoice->getCompany()->getRuc();
        $company = ModelsCompany::where('ruc', $ruc)
            ->where('user_id', Auth::user()->id)
            ->first();
        $params = [
            'system' => [
                'logo' => Storage::get($company->logo_path),
                'hash' => 'qqnr2dN4p/HmaEA/CJuVGo7dv5g=',
            ],
            'user' => [
                'header' => 'Telf: <b>(01) 123375</b>',
                'extras' => [
                    ['name' => 'CONDICION DE PAGO', 'value' => 'Efectivo'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
                'footer' => '<p>Nro Resolucion: <b>3232323</b></p>',
            ],
        ];
        return $report->render($invoice, $params);
    }
    public function generatePdfReport($invoice)
    {
        $htmlReport = new HtmlReport();
        $resolver   = new DefaultTemplateResolver();
        $htmlReport->setTemplate($resolver->getTemplate($invoice));
        $ruc     = $invoice->getCompany()->getRuc();
        $company = ModelsCompany::where('ruc', $ruc)
            ->where('user_id', Auth::user()->id)
            ->first();
        $params = [
            'system' => [
                'logo' => Storage::get($company->logo_path), // Logo de Empresa
                'hash' => 'qqnr2dN4p/HmaEA/CJuVGo7dv5g=',
            ],
            'user'   => [
                'header' => 'Telf: <b>(01) 123375</b>', // Texto que se ubica debajo de la dirección de empresa
                'extras' => [
                    // Leyendas adicionales
                    ['name' => 'CONDICION DE PAGO', 'value' => 'Efectivo'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
                'footer' => '<p>Nro Resolucion: <b>3232323</b></p>',
            ],
        ];
    }
}
