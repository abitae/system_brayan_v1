<?php

namespace App\Livewire\Facturacion;

use App\Models\Configuration\Company;
use App\Models\Facturacion\Invoice;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Paquete;
use App\Services\ServiceTableSunat;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use App\Traits\UtilsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Luecano\NumeroALetras\NumeroALetras;
use Mary\Traits\Toast;

class InvoiceCreateLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination, SearchDocument, UtilsTrait;

    public $title = 'EMITIR RECIBOS';
    public $sub_title = 'Emitir Recibo';
    public $tipoDocumento = '1';
    public $numDocumento = '';
    public $razonSocial = '';
    public $direccion = '';
    public $ubigeo = '';
    public $telefono = '';
    public $paquetes;
    public $cantidad;
    public $und_medida = 'ZZ';
    public $description;
    public $peso;
    public $amount;
    public $sub_total;
    public $igv;
    public $total;
    public $observacion;
    public $moneda = 'PEN';
    public $formaPago = 'Contado';
    public $tipoDoc = '03'; // boleta
    public $tipoOperacion = '0101';
    public $tipoDetraccion = '027';
    public $serie;
    public $client;
    public $id;
    public $docAdjunto;
    public $docAdjunto_type;
    public $modalPrintInvoice = false;
    public $invoice;

    public function mount($id = null)
    {
        $this->paquetes = collect([])->keyBy('id');
        if ($id) {
            $this->id = $id;
            $this->processEncomienda();
        }
    }

    private function processEncomienda()
    {
        $encomienda = Encomienda::find($this->id);
        $this->tipoDoc = '03';
        $this->tipoOperacion = '0101';
        $this->moneda = 'PEN';
        $this->tipoDocumento = $encomienda->remitente->type_code;
        $this->numDocumento = $encomienda->remitente->code;
        $this->razonSocial = $encomienda->remitente->name;
        $this->direccion = $encomienda->remitente->address;
        $this->ubigeo = $encomienda->remitente->ubigeo;
        $this->client = $encomienda->remitente;
        $this->paquetes = $encomienda->paquetes;
        $this->docAdjunto = json_decode($encomienda->docsTraslado)[0]->documento ?? null;
        $this->docAdjunto_type = json_decode($encomienda->docsTraslado)[0]->tipoDoc ?? null;
        $this->calculateTotals();
    }
    public function render()
    {
        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad'],
            ['key' => 'und_medida', 'label' => 'Unidad'],
            ['key' => 'description', 'label' => 'Descripcion'],
            ['key' => 'peso', 'label' => 'Peso'],
            ['key' => 'amount', 'label' => 'P.UNIT'],
            ['key' => 'sub_total', 'label' => 'MONTO'],
        ];
        //Hola mundo
        //Ho
        $service = new ServiceTableSunat();
        $tipoDocs = [
            ['codigo' => '01', 'descripcion' => 'Factura (01)'],
            ['codigo' => '03', 'descripcion' => 'Boleta (03)'],
        ];
        $tipoOperaciones = [
            ['codigo' => '0101', 'descripcion' => 'Venta interna (0101)'],
            ['codigo' => '1001', 'descripcion' => 'Operación sujeta a detracción (1001)'],
        ];
        $tipoDetracciones = $service->getAll('sunat_54');
        $monedas = [
            ['codigo' => 'PEN', 'descripcion' => 'Sol (PEN)'],
            ['codigo' => 'USD', 'descripcion' => 'Dólar (USD)'],
        ];
        if ($this->tipoDoc == '01') {
            $this->tipoDocumento = '6';
        }
        $tipoDocuments = [
            ['codigo' => '0', 'sigla' => 'OTRO DOCUMENTO cod(0)'],
            ['codigo' => '1', 'sigla' => 'DNI cod(1)'],
            ['codigo' => '6', 'sigla' => 'RUC cod(6)'],
        ];

        $ubigeos = $service->getAll('ubigeo');
        $unidadMedidas = $service->getAll('sunat_03');

        return view('livewire.facturacion.invoice-create-live', compact('tipoDocuments', 'ubigeos', 'headers_paquetes', 'tipoDocs', 'tipoOperaciones', 'monedas', 'tipoDetracciones', 'unidadMedidas'));
    }
    public function emitFactura()
    {
        if ($this->tipoDoc == '01' && in_array($this->tipoDocumento, ['0', '1'])) {
            $this->error('Error, El documento no es valido para Facturas!');
            return;
        }
        if ($this->tipoDoc == '03' && $this->tipoOperacion == '1001') {
            $this->error('Error, El tipo de operación no es valido para Boletas!');
            return;
        } elseif ($this->total < 400 && $this->tipoOperacion == '1001') {
            $this->error('Error, El monto total no es valido para Detracciones!');
            return;
        }

        $this->serie = $this->tipoDoc == '01' ? Auth::user()->sucursal->serieFactura : Auth::user()->sucursal->serieBoleta;
        $correlativo = Invoice::where('tipoDoc', $this->tipoDoc)->where('serie', $this->serie)->count() + 1;
        $rules = [
            'client' => 'required',
            'tipoDoc' => 'required',
            'tipoOperacion' => 'required',
            'serie' => 'required',
            'tipoDocumento' => 'required',
            'numDocumento' => 'required',
            'moneda' => 'required',
            'formaPago' => 'required',
            'paquetes' => 'required',
            'sub_total' => 'required',
            'igv' => 'required',
            'total' => 'required',
        ];
        $messages = [
            'client.required' => 'Error, es necesario seleccionar un cliente!',
            'tipoDoc.required' => 'Error, es necesario seleccionar un tipo de documento!',
            'tipoOperacion.required' => 'Error, es necesario seleccionar un tipo de operación!',
            'serie.required' => 'Error, es necesario seleccionar una serie!',
            'tipoDocumento.required' => 'Error, es necesario seleccionar un tipo de documento!',
            'numDocumento.required' => 'Error, es necesario seleccionar un número de documento!',
            'moneda.required' => 'Error, es necesario seleccionar una moneda!',
            'formaPago.required' => 'Error, es necesario seleccionar una forma de pago!',
            'paquetes.required' => 'Error, es necesario seleccionar un paquete!',
            'sub_total.required' => 'Error, es necesario seleccionar un subtotal!',
            'igv.required' => 'Error, es necesario seleccionar un igv!',
            'total.required' => 'Error, es necesario seleccionar un total!',
        ];
        $this->validate($rules, $messages);
        if ($this->docAdjunto) {
            $this->docAdjunto = strtoupper($this->docAdjunto);
            // Reconocer el tipo de documento según el prefijo
            $firstChar = substr($this->docAdjunto, 0, 1);

            switch ($firstChar) {
                case 'F':
                    $this->docAdjunto_type = 'Factura'; // Factura
                    break;
                case 'B':
                    $this->docAdjunto_type = 'Boleta'; // Boleta
                    break;
                case 'T':
                    $this->docAdjunto_type = 'Guía de Remisión'; // Guía de Remisión
                    break;
                case 'V':
                    $this->docAdjunto_type = 'Guía de Transportista'; // Guía de Transportista
                    break;
                default:
                    $this->docAdjunto_type = 'Otro documento'; // Otro documento
                    break;
            }
        }
        $formatter = new NumeroALetras();
        $company = Company::first();
        $factura = new Invoice();
        $factura->fill([
            'encomienda_id' => $this->id ?? null,
            'sucursal_id' => Auth::user()->sucursal->id,
            'tipoDoc' => $this->tipoDoc,
            'tipoOperacion' => $this->tipoOperacion,
            'serie' => $this->serie,
            'correlativo' => $correlativo,
            'fechaEmision' => $this->dateNow('Y-m-d H:i:m'),
            'formaPago_moneda' => $this->moneda,
            'formaPago_tipo' => $this->formaPago,
            'tipoMoneda' => $this->moneda,
            'company_id' => $company->id,
            'client_id' => $this->client->id,
            'mtoOperGravadas' => $this->sub_total,
            'mtoIGV' => $this->igv,
            'totalImpuestos' => $this->igv,
            'valorVenta' => $this->sub_total,
            'subTotal' => $this->total,
            'mtoImpVenta' => $this->total,
            'monto_letras' => $formatter->toInvoice($this->total, 2, 'SOLES'),
            'observacion' => $this->observacion,
            'docAdjunto' => $this->docAdjunto ?? '',
            'docAdjunto_type' => $this->docAdjunto_type ?? '',
        ]);

        $legends = [
            ['code' => '1000', 'value' => $factura->monto_letras],
        ];

        if ($this->total >= 400 && $this->tipoOperacion == '1001') {
            $factura->fill([
                'codBienDetraccion' => $this->tipoDetraccion,
                'codMedioPago' => '001',
                'ctaBanco' => $company->ctaBanco,
                'setPercent' => 4,
                'setMount' => $this->total * 0.04,
            ]);
            $legends[] = [
                'code' => '2006',
                'value' => 'Leyenda "Operación sujeta a detracción"',
            ];
        }

        $factura->legends = json_encode($legends);
        $factura->save();

        foreach ($this->paquetes as $paquete) {
            $mtoValorUnitario = round($paquete['amount'] / 1.18, 2);
            $factura->details()->create([
                'invoice_id' => $factura->id,
                'tipAfeIgv' => '10',
                'codProducto' => $paquete['id'],
                'unidad' => $paquete['und_medida'],
                'descripcion' => $paquete['description'],
                'cantidad' => $paquete['cantidad'],
                'mtoValorUnitario' => $mtoValorUnitario,
                'mtoValorVenta' => $mtoValorUnitario * $paquete['cantidad'],
                'mtoBaseIgv' => $mtoValorUnitario * $paquete['cantidad'],
                'porcentajeIgv' => 18,
                'igv' => ($paquete['amount'] - $mtoValorUnitario) * $paquete['cantidad'],
                'totalImpuestos' => ($paquete['amount'] - $mtoValorUnitario) * $paquete['cantidad'],
                'mtoPrecioUnitario' => $paquete['amount'],
            ]);
        }

        $this->client->update([
            'address' => $this->direccion,
            'ubigeo' => $this->ubigeo,
            'phone' => $this->telefono,
        ]);
        if ($this->id) {
            $encomienda = Encomienda::find($this->id);
            $encomienda->tipo_comprobante = $factura->tipoDoc = '03' ? 'BOLETA' : 'FACTURA';
            $encomienda->save();
        }

        $this->invoice = $factura;
        $this->modalPrintInvoice = true;
        $this->resetForm();
    }
    public function closePrintInvoice()
    {
        $this->modalPrintInvoice = false;
        $this->invoice = null;
        $this->resetForm();
    }
    private function resetForm()
    {
        $this->client = null;
        $this->numDocumento = '';
        $this->razonSocial = '';
        $this->direccion = '';
        $this->ubigeo = '';
        $this->telefono = '';
        $this->paquetes = collect([]);
        $this->calculateTotals();
        $this->resetValidation();
        $this->tipoDetraccion = '027';
        $this->tipoOperacion = '0101';
        $this->tipoDocumento = '1';
        $this->tipoDoc = '03';
        $this->docAdjunto = null;
        $this->docAdjunto_type = null;
        $this->observacion = null;
        $this->success('Factura emitida correctamente');
    }
    public function buscarDocumento()
    {
        $rules = [
            'tipoDocumento' => 'required',
            'numDocumento' => 'required|min:8|max:11',
        ];
        $messages = [
            'tipoDocumento.required' => 'El tipo de documento es requerido',
            'numDocumento.required' => 'El número de documento es requerido',
            'numDocumento.min' => 'El número de documento debe tener 8 dígitos',
            'numDocumento.max' => 'El número de documento debe tener 11 dígitos',
        ];
        $this->validate($rules, $messages);

        $customer = Customer::where('type_code', $this->tipoDocumento)->where('code', $this->numDocumento)->first();
        if ($customer) {
            $this->fillCustomerData($customer);
            return;
        }

        $tipo = $this->tipoDocumento == '6' ? 'ruc' : 'dni';
        $respuesta = $this->searchComplete($tipo, $this->numDocumento);

        if (!$respuesta['encontrado']) {
            $this->resetCustomerData();
            $this->error('El cliente no existe!, verifique el número de documento!');
            return;
        }

        $this->fillCustomerDataFromResponse($respuesta, $tipo);
    }
    private function fillCustomerData($customer)
    {
        $this->razonSocial = $customer->name;
        $this->direccion = $customer->address;
        $this->ubigeo = $customer->ubigeo;
        $this->telefono = $customer->phone;
        $this->client = $customer;
    }
    private function resetCustomerData()
    {
        $this->razonSocial = '';
        $this->direccion = '';
        $this->ubigeo = '';
    }
    private function fillCustomerDataFromResponse($respuesta, $tipo)
    {
        if ($tipo == 'ruc') {
            $this->razonSocial = $respuesta['data']->razon_social;
            $this->direccion = $respuesta['data']->direccion;
            $this->ubigeo = $respuesta['data']->codigo_ubigeo;
        } else {
            $this->razonSocial = $respuesta['data']->nombre;
            $this->direccion = '';
            $this->ubigeo = '';
        }

        $this->client = Customer::firstOrCreate(
            ['type_code' => $this->tipoDocumento, 'code' => $this->numDocumento],
            ['name' => $this->razonSocial, 'address' => $this->direccion, 'ubigeo' => $this->ubigeo, 'phone' => $this->telefono]
        );
    }
    public function addPaquete()
    {
        if ($this->validatePaquete()) {
            $paquete = new Paquete();
            $paquete->id = $this->paquetes->count() + 1;
            $paquete->cantidad = $this->cantidad;
            $paquete->und_medida = $this->und_medida;
            $paquete->description = $this->description;
            $paquete->peso = $this->peso;
            $paquete->amount = $this->amount;
            $paquete->sub_total = $this->amount * $this->cantidad;
            $this->paquetes->push($paquete->toArray());
            $this->calculateTotals();
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    private function validatePaquete()
    {
        $validations = [
            'cantidad' => 'required|numeric',
            'und_medida' => 'required',
            'description' => 'required',
            'peso' => 'required|numeric',
            'amount' => 'required|numeric',
        ];
        $errorMessage = [
            'cantidad.required' => 'Error, es necesario ingresar la cantidad!',
            'cantidad.numeric' => 'Error, la cantidad debe ser un número!',
            'und_medida.required' => 'Error, es necesario ingresar la unidad de medida!',
            'description.required' => 'Error, es necesario ingresar la descripción!',
            'peso.required' => 'Error, es necesario ingresar el peso!',
            'peso.numeric' => 'Error, el peso debe ser un número!',
            'amount.required' => 'Error, es necesario ingresar el precio unitario!',
            'amount.numeric' => 'Error, el precio unitario debe ser un número!',
        ];
        $this->validate($validations, $errorMessage);

        return true;
    }
    public function restPaquete($id)
    {
        $this->paquetes->pull($id - 1);
        $this->calculateTotals();
    }

    public function resetPaquete()
    {
        $this->paquetes = collect([]);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->total = round($this->paquetes->sum('sub_total'), 2);
        $this->sub_total = round($this->total / 1.18, 2);
        $this->igv = round($this->total - $this->sub_total, 2);
    }
}
