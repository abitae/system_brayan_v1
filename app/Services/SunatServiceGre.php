<?php
namespace App\Services;

use App\Models\Facturacion\Despatche;
use DateTime;
use Greenter\Api;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\AdditionalDoc;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Driver;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Despatch\Vehicle;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Support\Facades\Storage;

class SunatServiceGre
{
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

    public function getDespatch($despatche)
    {
        $pagaflete = new Client();
        $pagaflete->setTipoDoc("6")
            ->setNumDoc("10436493903")
            ->setRznSocial("Abel Arana");

        $item = new AdditionalDoc();
        $item->setTipo("01")
            ->setTipoDesc("Factura")
            ->setNro("F001-00000007")
            ->setEmisor("1043649390");
        $relDoc[] = $item;

        $destinatario = new Client();
        $destinatario->setTipoDoc('6')
            ->setNumDoc('10436493903')
            ->setRznSocial('Abel Arana');

        return (new Despatch)
            ->setVersion('2022')
            ->setTipoDoc('31')
            ->setSerie('V001')
            ->setCorrelativo('123')
            ->setFechaEmision(new DateTime($despatche->fechaEmision ?? null))
            ->setPagaFlete($pagaflete)
            ->setCompany($this->getGRECompany())
            ->setDestinatario($destinatario)
            ->setEnvio($this->getEnvio($despatche))
            ->setObservacion('glosa')
            ->setAddDocs($relDoc)
            ->setDetails($this->getDespatchDetails($despatche['details']));
    }

    public function getGRECompany(): Company
    {
        return (new Company())
            ->setRuc('10436493903')
            ->setRazonSocial('Abel Arana');
    }

    public function getEnvio($data)
    {
        $indicadores[] = "SUNAT_Envio_IndicadorPagadorFlete_Remitente";
        $transp = new Transportist();
        $transp->setTipoDoc('6')
            ->setNumDoc("20541528092")
            ->setRznSocial("Abel Arana")
            ->setNroMtc("123456");

        $remitente = new Client();
        $remitente->setTipoDoc("6")
            ->setNumDoc("10436493901")
            ->setRznSocial("Abel Arana");

        return (new Shipment)
            ->setCodTraslado('01')
            ->setModTraslado('02')
            ->setFecTraslado(new DateTime($data['fecTraslado'] ?? null))
            ->setPesoTotal($data->pesoTotal ?? null)
            ->setUndPesoTotal($data->undPesoTotal ?? null)
            ->setTransportista($transp)
            ->setVehiculo($this->getVehiculo($data ?? null))
            ->setChoferes($this->getChoferes($data['choferes']) ?? null)
            ->setIndicador($indicadores)
            ->setLlegada(new Direction($data->llegada_ubigueo, $data->llegada_direccion))
            ->setPartida(new Direction($data->partida_ubigueo, $data->partida_direccion))
            ->setRemitente($remitente);
    }

    public function getVehiculo($data)
    {
        $secundarios = [];
        return (new Vehicle())
            ->setPlaca('ABC123' ?? null)
            ->setSecundarios($secundarios);
    }

    public function getChoferes($choferes)
    {
        $choferes = collect($choferes);
        $drivers = [];
        $drivers[] = (new Driver)
            ->setTipo('Principal')
            ->setTipoDoc('1' ?? null)
            ->setNroDoc('43649390' ?? null)
            ->setLicencia('A43649390' ?? null)
            ->setNombres('Abel Arana' ?? null)
            ->setApellidos('Arana Cortez' ?? null);

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
                ->setCantidad($data->cantidad ?? null)
                ->setUnidad($data->unidad ?? null)
                ->setDescripcion($data->descripcion ?? null)
                ->setCodigo($data->codProducto ?? null);
        }
        return $green_details;
    }

    public function sunatResponse($result)
    {
       //d($result);
        $response['success'] = $result->isSuccess();
        if (!$response['success']) {
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

    public function getSee($company)
    {
        $see = new See();
        $see->setCertificate(Storage::get($company->cert_path));
        $see->setService($company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA);
        $see->setClaveSOL($company->ruc, $company->sol_user, $company->sol_pass);
        return $see;
    }
}
