<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\EncomiendaForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\SucursalConfiguration;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Paquete;
use App\Services\ServiceTableSunat;
use App\Traits\CajaTrait;
use App\Traits\InvoiceTrait;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class RegisterLive extends Component
{
    use LogCustom, Toast, InvoiceTrait, WithPagination, WithoutUrlPagination, CajaTrait, UtilsTrait, SearchDocument;

    public int $step = 1;
    public $title = 'REGISTRO DE PAQUETES';
    public $sub_title = 'Registrar paquetes de envio';

    public EncomiendaForm $encomiendaForm;
    public EntryCajaForm $entryForm;

    public $cantidad, $und_medida = 'NIU', $description, $peso, $amount;
    public $paquetes, $sucursal_destino, $sucursal_dest_id, $pin1, $pin2;
    public $estado_pago = 'PAGADO', $tipo_comprobante = 'TICKET', $metodo_pago = 'Efectivo', $tipo_pago = 'Contado';
    public $glosa, $observation;
    public $transportista_id, $vehiculo_id, $modalConfimation = false, $caja, $isReturn = false, $isHome = false, $modalFinal = false;
    public $encomienda;

    public $remitente, $remitente_type_code = 1, $remitente_code, $remitente_name, $remitente_address, $remitente_phone, $remitente_ubigeo;
    public $destinatario, $destinatario_type_code = 1, $destinatario_code, $destinatario_name, $destinatario_address, $destinatario_phone, $destinatario_ubigeo;
    public $cliFacturacion, $cliFacturacion_type_code = 1, $cliFacturacion_code, $cliFacturacion_name, $cliFacturacion_address, $cliFacturacion_phone, $cliFacturacion_ubigeo;
    public $tipoDocTraslado, $docTraslado, $emisorDocTraslado;
    public $docsTraslado;
    public $showDocTraslado = false;
    public function mount()
    {
        $this->docsTraslado = collect([])->keyBy('id');
        $this->caja = $this->cajaIsActive(Auth::user());
        $this->paquetes = collect([])->keyBy('id');

        $sucursalConfig = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id);
        $sucursalDestinoIds = $sucursalConfig->pluck('sucursal_destino_id');

        if (!$this->caja || $sucursalDestinoIds->isEmpty()) {
            return $this->redirectRoute('caja.index');
        }
        $this->sucursal_dest_id = Sucursal::where('isActive', true)
            ->whereIn('id', $sucursalDestinoIds)->first()->id;
    }

    public function render()
    {
        $sucursalConfig = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id);
        $sucursalDestinoIds = $sucursalConfig->pluck('sucursal_destino_id');

        $sucursales = Sucursal::where('isActive', true)
            ->whereIn('id', $sucursalDestinoIds)->get();
        $transportistaConfig = $sucursalConfig->where('sucursal_destino_id', $this->sucursal_dest_id)->first();
        $this->transportista_id = $transportistaConfig->transportista_id;
        $this->vehiculo_id = $transportistaConfig->vehiculo_id;

        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad'],
            ['key' => 'und_medida', 'label' => 'Unidad'],
            ['key' => 'description', 'label' => 'Descripcion'],
            ['key' => 'peso', 'label' => 'Peso'],
            ['key' => 'amount', 'label' => 'P.UNIT'],
            ['key' => 'sub_total', 'label' => 'MONTO'],
        ];

        $pagos = [
            ['id' => 'PAGADO', 'name' => 'PAGADO'],
            ['id' => 'CONTRA ENTREGA', 'name' => 'CONTRA ENTREGA'],
        ];

        $comprobantes = [
            ['id' => 'BOLETA', 'name' => 'BOLETA'],
            ['id' => 'FACTURA', 'name' => 'FACTURA'],
            ['id' => 'TICKET', 'name' => 'TICKET'],
        ];

        $transportistas = Transportista::where('isActive', true)->get();
        $vehiculos = Vehiculo::where('isActive', true)->get();
        $tipoDocuments = [
            ['codigo' => '0', 'sigla' => 'OTRO cod(0)'],
            ['codigo' => '1', 'sigla' => 'DNI cod(1)'],
            ['codigo' => '6', 'sigla' => 'RUC cod(6)'],
        ];
        $service = new ServiceTableSunat();
        $unidadMedidas = $service->getAll('sunat_03');
        $metodoPagos = [
            ['id' => 'Efectivo', 'name' => 'Efectivo'],
            ['id' => 'Yape', 'name' => 'Yape'],
            ['id' => 'Transferencia', 'name' => 'Transferencia'],
            ['id' => 'Deposito', 'name' => 'Deposito'],
        ];
        return view('livewire.package.register-live', compact(
            'metodoPagos',
            'unidadMedidas',
            'headers_paquetes',
            'sucursales',
            'pagos',
            'comprobantes',
            'transportistas',
            'vehiculos',
            'tipoDocuments'
        ));
    }

    public function searchRemitente()
    {
        $rules = [
            'remitente_type_code' => 'required',
            'remitente_code' => 'required|min:8|max:11',
        ];
        $messages = [
            'remitente_type_code.required' => 'El tipo de documento es requerido',
            'remitente_code.required' => 'El número de documento es requerido',
            'remitente_code.min' => 'El número de documento debe tener 8 dígitos',
            'remitente_code.max' => 'El número de documento debe tener 11 dígitos',
        ];
        $this->validate($rules, $messages);
        $remitente = Customer::where('type_code', $this->remitente_type_code)
            ->where('code', $this->remitente_code)
            ->first();
        if ($remitente) {
            $this->remitente = $remitente;
            $this->remitente_name = $remitente->name;
            $this->remitente_address = $remitente->address;
            $this->remitente_phone = $remitente->phone;
            $this->remitente_ubigeo = $remitente->ubigeo;
            return;
        }
        $tipo = $this->remitente_type_code == '6' ? 'ruc' : 'dni';
        $respuesta = $this->searchComplete($tipo, $this->remitente_code);

        if (!$respuesta['encontrado']) {
            $this->remitente_name = '';
            $this->remitente_address = '';
            $this->remitente_phone = '';
            $this->remitente_ubigeo = '';
            $this->error('El remitente no existe!, verifique el número de documento!');
            return;
        }
        if ($tipo == 'ruc') {
            $this->remitente_name = $respuesta['data']->razon_social;
            $this->remitente_address = $respuesta['data']->direccion;
            $this->remitente_ubigeo = $respuesta['data']->codigo_ubigeo;
        } else {
            $this->remitente_name = $respuesta['data']->nombre;
            $this->remitente_phone = '';
            $this->remitente_ubigeo = '';
        }

        $this->remitente = Customer::firstOrCreate(
            [
                'type_code' => $this->remitente_type_code,
                'code' => $this->remitente_code
            ],
            [
                'name' => $this->remitente_name,
                'address' => $this->remitente_address,
                'ubigeo' => $this->remitente_ubigeo
            ]
        );
    }

    public function searchDestinatario()
    {
        $rules = [
            'destinatario_type_code' => 'required',
            'destinatario_code' => 'required|min:8|max:11',
        ];
        $messages = [
            'destinatario_type_code.required' => 'El tipo de documento es requerido',
            'destinatario_code.required' => 'El número de documento es requerido',
            'destinatario_code.min' => 'El número de documento debe tener 8 dígitos',
            'destinatario_code.max' => 'El número de documento debe tener 11 dígitos',
        ];
        //dd($this->destinatario_type_code);
        $this->validate($rules, $messages);
        $destinatario = Customer::where('type_code', $this->destinatario_type_code)
            ->where('code', $this->destinatario_code)
            ->first();
        //dd($destinatario);
        if ($destinatario) {
            $this->destinatario = $destinatario;
            $this->destinatario_name = $destinatario->name;
            $this->destinatario_address = $destinatario->address;
            $this->destinatario_phone = $destinatario->phone;
            $this->destinatario_ubigeo = $destinatario->ubigeo;
            return;
        }
        $tipo = $this->destinatario_type_code == '6' ? 'ruc' : 'dni';
        $respuesta = $this->searchComplete($tipo, $this->destinatario_code);

        if (!$respuesta['encontrado']) {
            $this->destinatario_name = '';
            $this->destinatario_address = '';
            $this->destinatario_phone = '';
            $this->destinatario_ubigeo = '';
            $this->error('El destinatario no existe!, verifique el número de documento!');
            return;
        }
        if ($tipo == 'ruc') {
            $this->destinatario_name = $respuesta['data']->razon_social;
            $this->destinatario_address = $respuesta['data']->direccion;
            $this->destinatario_ubigeo = $respuesta['data']->codigo_ubigeo;
        } else {
            $this->destinatario_name = $respuesta['data']->nombre;
            $this->destinatario_phone = '';
            $this->destinatario_ubigeo = '';
        }

        $this->destinatario = Customer::firstOrCreate(
            [
                'type_code' => $this->destinatario_type_code,
                'code' => $this->destinatario_code
            ],
            [
                'name' => $this->destinatario_name,
                'address' => $this->destinatario_address,
                'ubigeo' => $this->destinatario_ubigeo
            ]
        );
    }

    public function searchFacturacion()
    {

        $rules = [
            'cliFacturacion_type_code' => 'required',
            'cliFacturacion_code' => 'required|min:8|max:11',
        ];
        $messages = [
            'cliFacturacion_type_code.required' => 'El tipo de documento es requerido',
            'cliFacturacion_code.required' => 'El número de documento es requerido',
            'cliFacturacion_code.min' => 'El número de documento debe tener 8 dígitos',
            'cliFacturacion_code.max' => 'El número de documento debe tener 11 dígitos',
        ];
        $this->validate($rules, $messages);
        $cliFacturacion = Customer::where('type_code', $this->cliFacturacion_type_code)
            ->where('code', $this->cliFacturacion_code)
            ->first();
        if ($cliFacturacion) {
            $this->cliFacturacion = $cliFacturacion;
            $this->cliFacturacion_name = $cliFacturacion->name;
            $this->cliFacturacion_address = $cliFacturacion->address;
            $this->cliFacturacion_phone = $cliFacturacion->phone;
            $this->cliFacturacion_ubigeo = $cliFacturacion->ubigeo;
            return;
        }
        $tipo = $this->cliFacturacion_type_code == '6' ? 'ruc' : 'dni';
        $respuesta = $this->searchComplete($tipo, $this->cliFacturacion_code);
        if (!$respuesta['encontrado']) {
            $this->cliFacturacion = null;
            $this->cliFacturacion_name = '';
            $this->cliFacturacion_address = '';
            $this->cliFacturacion_phone = '';
            $this->cliFacturacion_ubigeo = '';
            $this->error('El cliente de Facturacion no existe!, verifique el número de documento!');
            return;
        }
        if ($tipo == 'ruc') {
            $this->cliFacturacion_name = $respuesta['data']->razon_social;
            $this->cliFacturacion_address = $respuesta['data']->direccion;
            $this->cliFacturacion_ubigeo = $respuesta['data']->codigo_ubigeo;
        } else {
            $this->cliFacturacion_name = $respuesta['data']->nombre;
            $this->cliFacturacion_phone = '';
            $this->cliFacturacion_ubigeo = '';
        }

        $this->cliFacturacion = Customer::firstOrCreate(
            [
                'type_code' => $this->cliFacturacion_type_code,
                'code' => $this->cliFacturacion_code
            ],
            [
                'name' => $this->cliFacturacion_name,
                'address' => $this->cliFacturacion_address,
                'ubigeo' => $this->cliFacturacion_ubigeo
            ]
        );
    }

    public function next()
    {
        if ($this->step < 5) {
            switch ($this->step) {
                case 1:
                    $this->processStepOne();
                    break;
                case 2:
                    $this->processStepTwo();
                    break;
                case 3:
                    $this->processStepThree();
                    break;
                case 4:
                    $this->processStepFour();
                    break;
            }
        }
    }
    private function processStepOne()
    {
        if ($this->remitente) {
            $this->remitente->address = $this->remitente_address;
            $this->remitente->phone = $this->remitente_phone;
            $this->remitente->save();
            $this->step++;
            $this->success('Genial', 'remitente ingresado correctamente!');
        } else {
            $this->error('Error!', 'Ingrese un remitente');
        }
    }
    private function processStepTwo()
    {
        if ($this->isHome && !$this->destinatario_address) {
            $this->error('Error', 'Es necesario ingresar la dirección de entrega!');
            return;
        }
        if ($this->destinatario) {
            $this->destinatario->address = $this->destinatario_address;
            $this->destinatario->phone = $this->destinatario_phone;
            $this->destinatario->save();
            $this->step++;
            $this->success('Genial', 'Destinatario ingresado correctamente!');
        } else {
            $this->error('Error!', 'Ingrese un destinatario');
        }
    }
    private function processStepThree()
    {
        if ($this->paquetes->isNotEmpty()) {
            $this->cliFacturacion = $this->remitente;
            $this->cliFacturacion_type_code = $this->cliFacturacion->type_code;
            $this->cliFacturacion_code = $this->cliFacturacion->code;
            $this->cliFacturacion_name = $this->cliFacturacion->name;
            $this->cliFacturacion_address = $this->cliFacturacion->address;
            $this->cliFacturacion_phone = $this->cliFacturacion->phone;
            $this->step++;
            $this->success('Genial', 'Paquetes ingresados correctamente!');
        } else {
            $this->error('Error!', 'Ingrese un paquete para el envio!');
        }
    }
    private function processStepFour()
    {

        $rules = [
            'cliFacturacion' => 'required',
            'estado_pago' => 'required',
            'tipo_comprobante' => 'required',
            'cliFacturacion_type_code' => 'required',
            'cliFacturacion_code' => 'required',
            'cliFacturacion_code' => 'min:8|max:11',
            'cliFacturacion_name' => 'required',

        ];
        $messages = [
            'cliFacturacion.required' => 'Error, es necesario ingresar el cliente de facturación!',
            'estado_pago.required' => 'Error, es necesario ingresar el estado de pago!',
            'tipo_comprobante.required' => 'Error, es necesario ingresar el tipo de comprobante!',
            'cliFacturacion_type_code.required' => 'Error, es necesario ingresar el tipo de documento!',
            'cliFacturacion_code.required' => 'Error, es necesario ingresar el número de documento!',
            'cliFacturacion_code.min' => 'Error, el número de documento debe tener 8 dígitos!',
            'cliFacturacion_code.max' => 'Error, el número de documento debe tener 11 dígitos!',
            'cliFacturacion_name.required' => 'Error, es necesario ingresar el nombre del cliente de facturación!',
        ];
        $this->validate($rules, $messages);
        //dd($this->cliFacturacion->type_code);
        if ($this->tipo_comprobante == 'FACTURA' && $this->cliFacturacion->type_code == '1') {
            $this->error('Error, el cliente de facturación no es valido!, verifique el número de RUC!');
            return;
        }
        if ($this->estado_pago == 'CONTRA ENTREGA') {
            $this->cliFacturacion = $this->destinatario;
            $this->tipo_comprobante = 'TICKET';
            $this->metodo_pago = 'Efectivo';
        }
        if ($this->remitente_type_code == '6' && strlen($this->remitente_code) == 11) {
            $this->emisorDocTraslado = $this->remitente_code;
        }
        $this->step++;
    }
    public function prev()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function addPaquete()
    {
        $rules = [
            'cantidad' => 'required|numeric',
            'und_medida' => 'required',
            'description' => 'required',
            'peso' => 'required|numeric',
            'amount' => 'required|numeric',
        ];
        $messages = [
            'cantidad.required' => 'Error, es necesario ingresar la cantidad!',
            'cantidad.numeric' => 'Error, la cantidad debe ser un número!',
            'und_medida.required' => 'Error, es necesario ingresar la unidad de medida!',
            'description.required' => 'Error, es necesario ingresar la descripción!',
            'peso.required' => 'Error, es necesario ingresar el peso!',
            'peso.numeric' => 'Error, el peso debe ser un número!',
            'amount.required' => 'Error, es necesario ingresar el precio unitario!',
            'amount.numeric' => 'Error, el precio unitario debe ser un número!',
        ];
        $this->validate($rules, $messages);
        $paquete = new Paquete();
        $paquete->id = $this->paquetes->count() + 1;
        $paquete->cantidad = $this->cantidad;
        $paquete->und_medida = $this->und_medida;
        $paquete->description = $this->description;
        $paquete->peso = $this->peso;
        $paquete->amount = $this->amount;
        $paquete->sub_total = $this->amount * $this->cantidad;
        $this->paquetes->push($paquete->toArray());
        $this->success('Genial', 'Paquete ingresado correctamente!');
    }
    public function restPaquete($id)
    {
        $this->success('Genial', 'Paquete eliminado correctamente!');
        $this->paquetes->pull($id - 1);
    }

    public function resetPaquete()
    {
        $this->success('Genial', 'Paquetes eliminados correctamente!');
        $this->paquetes = collect([]);
    }
    public function addDocTraslado()
    {
        $rules = [
            'docTraslado' => 'required',
            'emisorDocTraslado' => 'required',
        ];
        $messages = [
            'docTraslado.required' => 'Error, es necesario ingresar el documento!',
            'emisorDocTraslado.required' => 'Error, es necesario ingresar el RUC del emisor!',
        ];
        $this->validate($rules, $messages);
        $this->docTraslado = strtoupper($this->docTraslado);
        // Reconocer el tipo de documento según el prefijo
        $firstChar = substr($this->docTraslado, 0, 1);

        switch ($firstChar) {
            case 'F':
                $this->tipoDocTraslado = 'Factura'; // Factura
                break;
            case 'B':
                $this->tipoDocTraslado = 'Boleta'; // Boleta
                break;
            case 'T':
                $this->tipoDocTraslado = 'Guía de Remisión'; // Guía de Remisión
                break;
            case 'V':
                $this->tipoDocTraslado = 'Guía de Transportista'; // Guía de Transportista
                break;
            default:
                $this->tipoDocTraslado = 'Otro documento'; // Otro documento
                break;
        }
        $this->docsTraslado->push([
            'id' => $this->docsTraslado->count() + 1,
            'tipoDoc' => $this->tipoDocTraslado,
            'documento' => $this->docTraslado,
            'ruc' => $this->emisorDocTraslado
        ]);
        $this->reset('docTraslado');
    }
    public function resetDocTraslado()
    {
        $this->success('Genial', 'Paquetes eliminados correctamente!');
        $this->docsTraslado = collect([]);
    }
    public function deleteDocTraslado($id)
    {
        $this->success('Genial', 'Paquetes eliminados correctamente!');
        $this->docsTraslado->pull($id - 1);
    }
    public function finish()
    {
        if ($this->isReturn && !$this->destinatario_address) {
            $this->error('Error, es necesario ingresar la dirección de entrega!');
            $this->step = 2;
            $this->isHome = true;
            return;
        }

        if ($this->isHome) {
            $this->pin1 = $this->pin2 = 123;
        }



        if (isset($this->sucursal_dest_id, $this->pin1, $this->pin2) && $this->pin1 == $this->pin2) {
            $this->sucursal_destino = Sucursal::findOrFail($this->sucursal_dest_id);
            $this->modalConfimation = true;
        } else {
            $this->error('Error, el pin ingresado no es correcto!');
        }
    }

    public function confirmEncomienda()
    {

        if ($this->tipo_comprobante === 'FACTURA') {
            $this->cliFacturacion_type_code = '6';
        }
        if ($this->cliFacturacion_type_code == '6' && strlen($this->cliFacturacion_code) == 8) {
            $this->error('El cliente de Facturacion no valido!, verifique el número de RUC!');
            $this->modalConfimation = false;
            $this->cliFacturacion = null;
            return;
        }
        if ($this->cliFacturacion == null || $this->cliFacturacion_name == '') {
            $this->error('El cliente de Facturacion no existe!, verifique el número de documento!');
            $this->modalConfimation = false;
            return;
        }

        //dd(json_encode($this->docsTraslado));
        $this->encomiendaForm->fill([
            'code' => $this->generateCode(),
            'user_id' => Auth::user()->id,
            'transportista_id' => $this->transportista_id,
            'vehiculo_id' => $this->vehiculo_id,
            'customer_id' => $this->remitente->id,
            'sucursal_id' => Auth::user()->sucursal->id,
            'customer_dest_id' => $this->destinatario->id,
            'sucursal_dest_id' => $this->sucursal_dest_id,
            'customer_fact_id' => $this->cliFacturacion->id,
            'cantidad' => $this->paquetes->sum('cantidad'),
            'monto' => $this->paquetes->sum('sub_total'),

            'fecha_creacion' => Carbon::now(), //fecha de creacion

            'estado_pago' => $this->estado_pago,
            'tipo_pago' => $this->estado_pago == 'CONTRA ENTREGA' ? 'Credito' : 'Contado',
            'metodo_pago' => $this->metodo_pago,
            'tipo_comprobante' => $this->estado_pago == 'CONTRA ENTREGA' ? 'TICKET' : $this->tipo_comprobante,

            'estado_credito' => $this->estado_pago == 'CONTRA ENTREGA' ? 'Pendiente' : 'Cancelado',
            'docsTraslado' => json_encode($this->docsTraslado),

            'glosa' => $this->glosa,
            'observation' => $this->observation,
            'estado_encomienda' => 'REGISTRADO',
            'pin' => $this->pin1,
            'isHome' => $this->isHome,
            'isReturn' => $this->isReturn,
        ]);

        $this->encomienda = $this->encomiendaForm->store($this->paquetes);

        if ($this->encomienda) {
            if ($this->encomienda->estado_pago != 'CONTRA ENTREGA') {
                $this->storeEntry($this->encomienda);
            }
            $this->storeInvoce($this->encomienda);
            $this->resetForms();
            $this->success('Genial, ingresado correctamente!');
            $this->modalConfimation = false;
            $this->modalFinal = true;
        } else {
            $this->error('Error, verifique los datos!');
        }
    }

    private function generateCode()
    {
        $cod = Sucursal::where('id', Auth::user()->sucursal->id)->first()->code;
        $correlativo = Encomienda::count() + 1;
        return $cod . '-' . Auth::user()->id . $correlativo;
    }

    private function storeEntry(Encomienda $encomienda)
    {
        $this->entryForm->fill([
            'caja_id' => $this->caja->id,
            'monto_entry' => $encomienda->monto,
            'description' => 'REGISTRO ' . $encomienda->tipo_comprobante,
            'metodo_pago' => $encomienda->metodo_pago,
            'tipo_entry' => $encomienda->code,
        ]);

        if ($this->entryForm->store()) {
            $this->entryForm->reset();
        } else {
            $this->error('Error, no se pudo ingresar monto a caja!');
        }
    }

    private function resetForms()
    {
        $this->encomiendaForm->reset();
    }

    public function redirectionRegister()
    {
        $this->redirectRoute('package.register');
    }

    public function redirectionSend()
    {
        $this->redirectRoute('package.send');
    }
}
