<?php
namespace App\Livewire\Package;

use App\Exports\ManifiestoExport;
use App\Livewire\Forms\CustomerForm;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\SucursalConfiguration;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Manifiesto;
use App\Models\Package\Paquete;
use App\Services\ServiceTableSunat;
use App\Traits\CajaTrait;
use App\Traits\LogCustom;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class SendPackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;
    use CajaTrait, UtilsTrait;
    public $title = 'ENVIAR PAQUETES';
    public $sub_title = 'Modulo de envio de paquetes';
    public $search = '';
    public $perPage = 100;
    public array $selected = [];
    public int $sucursal_dest_id = 0;
    public $date_ini;
    public $date_fin;
    public $modalEnvio = false;
    public $numElementos;
    public Sucursal $sucursal_dest;
    public $transportista_id = 1;
    public $vehiculo_id = 1;
    public $isActive = true;
    public bool $showDrawer = false;
    public Encomienda $encomienda;
    public $editModal = false;
    public $isHome = false;
    public CustomerForm $customerFormDest;
    public $modalFinal;
    public $manifiesto;
    public $date_traslado;
    public $editEncomiendaModal = false;
    public $paquetes;
    public $destinatario_code;
    public $destinatario_type_code;
    public $destinatario_name;
    public $destinatario_address;
    public $destinatario_phone;
    public $destinatario_ubigeo;
    public $destinatario;
    public $und_medida = 'NIU';
    public $description;
    public $peso;
    public $amount;
    public $cantidad;
    public $editingPaqueteId = null;
    public function mount()
    {
        $this->date_traslado = Carbon::now()->endOfDay()->format('Y-m-d H:i');
        $this->date_ini = $this->filterDateStart();
        $this->date_fin = $this->filterDateEnd();

        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');

        if ($p->isEmpty()) {
            return redirect()->route('caja.index');
        }

        $this->sucursal_dest_id = Sucursal::where('isActive', true)
            ->whereIn('id', $p)
            ->first()
            ->id;
        $this->paquetes = collect([])->keyBy('id');
    }

    public function updatedDateIni(): void
    {
        $this->ensureDateRangeOrder($this->date_ini, $this->date_fin);
    }

    public function updatedDateFin(): void
    {
        $this->ensureDateRangeOrder($this->date_ini, $this->date_fin);
    }

    public function render()
    {
        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');

        $sucursals = Sucursal::where('isActive', true)
            ->whereIn('id', $p)
            ->get();

        $config = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->where('sucursal_destino_id', $this->sucursal_dest_id)
            ->first();

        $this->transportista_id = $config->transportista_id;
        $this->vehiculo_id = $config->vehiculo_id;

        // Build base query with date range filter
        $encomiendas = Encomienda::query()
            ->when($this->date_ini && $this->date_fin, function($query) {
                $query->whereBetween('created_at', [
                    $this->parseFilterDateStart($this->date_ini),
                    $this->parseFilterDateEnd($this->date_fin),
                ]);
            })
            ->where([
                'isActive' => $this->isActive,
                'sucursal_id' => Auth::user()->sucursal->id,
                'sucursal_dest_id' => $this->sucursal_dest_id,
            ])
            ->whereIn('estado_encomienda' , ['REGISTRADO','RETORNADO'])
            // Search in related models and package code
            ->when($this->search, function($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('remitente', function($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                    })
                    ->orWhere('code', 'like', $searchTerm)
                    ->orWhereHas('destinatario', function($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                    });
                });
            })
            ->with(['remitente', 'destinatario', 'sucursal_remitente', 'sucursal_destinatario'])
            ->latest()
            ->paginate($this->perPage, ['*'], 'page');

        $transportistas = Transportista::where('isActive', true)->get();
        $vehiculos = Vehiculo::where('isActive', true)->get();
        $service = new ServiceTableSunat();
        $unidadMedidas = $service->getAll('sunat_03');
        $metodoPagos = [
            ['id' => 'Efectivo', 'name' => 'Efectivo'],
            ['id' => 'Yape', 'name' => 'Yape'],
            ['id' => 'Transferencia', 'name' => 'Transferencia'],
            ['id' => 'Deposito', 'name' => 'Deposito'],
        ];
        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad'],
            ['key' => 'und_medida', 'label' => 'Unidad'],
            ['key' => 'description', 'label' => 'Descripcion'],
            ['key' => 'peso', 'label' => 'Peso'],
            ['key' => 'amount', 'label' => 'P.UNIT'],
            ['key' => 'sub_total', 'label' => 'MONTO'],
        ];
        return view('livewire.package.send-package-live', compact(
            'encomiendas',
            'sucursals',
            'transportistas',
            'vehiculos',
            'unidadMedidas',
            'metodoPagos',
            'headers_paquetes'
        ));
    }
    public function openModal()
    {
        if (!empty($this->selected)) {
            $this->numElementos = count($this->selected);
            $this->sucursal_dest = Sucursal::findOrFail($this->sucursal_dest_id);
            $this->modalEnvio = !$this->modalEnvio;
        } else {
            $this->error('Seleccione al menos un paquete!');
        }
    }
    public function sendPaquetes()
    {
        if ($this->vehiculo_id && $this->transportista_id) {
            $vehiculo_id = Encomienda::where('isActive', true)
                ->whereIn('id', $this->selected)->first()->vehiculo_id;
            $transportista_id = Encomienda::where('isActive', true)
                ->whereIn('id', $this->selected)->first()->transportista_id;
            if ($vehiculo_id != $this->vehiculo_id || $transportista_id != $this->transportista_id) {
                $num_encomiendas_enviadas = Encomienda::where('isActive', true)
                    ->whereIn('id', $this->selected)
                    ->update([
                        'estado_encomienda' => 'ENVIADO',
                        'vehiculo_id' => $this->vehiculo_id,
                        'transportista_id' => $this->transportista_id,
                        'isTransbordo' => true,
                        'fecha_envio' => Carbon::now(),
                    ]);
            } else {
                $num_encomiendas_enviadas = Encomienda::where('isActive', true)
                    ->whereIn('id', $this->selected)
                    ->update([
                        'estado_encomienda' => 'ENVIADO',
                        'fecha_envio' => Carbon::now(),
                        'vehiculo_id' => $this->vehiculo_id,
                        'transportista_id' => $this->transportista_id,
                    ]);
            }
            if (count($this->selected) == $num_encomiendas_enviadas) {
                $this->success('Genial, enviado correctamente!');
                $this->modalEnvio = false;
                $ids = $this->selected;
                $this->selected = [];
                $this->manifiesto = Manifiesto::create([
                    'sucursal_id' => Auth::user()->sucursal->id,
                    'sucursal_destino_id' => $this->sucursal_dest_id,
                    'ids' => json_encode($ids),
                ]);
                SucursalConfiguration::where('sucursal_id', Auth::user()->sucursal->id)
                    ->where('sucursal_destino_id', $this->sucursal_dest_id)
                    ->update(['isActive' => false]);

                $p = SucursalConfiguration::where('isActive', true)
                    ->where('sucursal_id', Auth::user()->sucursal->id)
                    ->pluck('sucursal_destino_id');
                if ($p->isEmpty()) {
                    return redirect()->route('package.manifiesto');
                } else {
                    $this->sucursal_dest_id = Sucursal::where('isActive', true)
                        ->whereIn('id', $p)
                        ->first()
                        ->id;
                }
                $this->modalFinal = true;
            } else {
                $this->error('Error, verifique los datos!');
            }
        } else {
            $this->error('Seleccione un vehiculo y transportista!');
        }
    }
    public function enableEncomienda(Encomienda $encomienda)
    {
        try {
            $encomienda->isActive = !$encomienda->isActive;
            $encomienda->save();
            $this->success('Genial, ingresado correctamente!');
        } catch (\Exception $e) {
            $this->error('Error, verifique los datos!');
        }
    }
    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }
    public function editEncomienda(Encomienda $encomienda)
    {
        // Validar que la encomienda sea editable
        if (!$this->isEncomiendaEditable($encomienda)) {
            $this->error($this->getEditableErrorMessage($encomienda));
            return;
        }

        $this->encomienda = $encomienda;
        $this->editEncomiendaModal = true;
        $this->paquetes = $encomienda->paquetes;
        $this->paquetes = $this->paquetes->map(function($paquete) {
            $paquete->amount = number_format($paquete->amount, 2, '.', '');
            return $paquete;
        });
        $this->destinatario_code = $encomienda->destinatario->code;
        $this->destinatario_type_code = $encomienda->destinatario->type_code;
        $this->destinatario_name = $encomienda->destinatario->name;
        $this->destinatario_address = $encomienda->destinatario->address;
        $this->destinatario_phone = $encomienda->destinatario->phone;
        $this->isHome = $encomienda->isHome;
    }
    public function updateEncomienda()
    {
        try {
            // Validar que la encomienda existe y es editable
            if (!$this->encomienda) {
                $this->error('No se encontró la encomienda a editar');
                return;
            }

            // Validar que la encomienda sea editable
            if (!$this->isEncomiendaEditable($this->encomienda)) {
                $this->error($this->getEditableErrorMessage($this->encomienda));
                return;
            }

            // Validar que se proporcionó información del destinatario
            if ($this->customerFormDest->code && $this->customerFormDest->type_code) {
                $destinatario = Customer::where('code', $this->customerFormDest->code)
                    ->where('type_code', $this->customerFormDest->type_code)
                    ->first();

                if (!$destinatario) {
                    $this->error('El destinatario no existe en la base de datos');
                    return;
                }

                // Validar que la encomienda tenga al menos un paquete
                if (!$this->validarPaquetes()) {
                    return;
                }

                // Actualizar datos de la encomienda
                $this->encomienda->customer_dest_id = $destinatario->id;
                $this->encomienda->isHome = $this->isHome;

                // Recalcular el monto total de la encomienda
                $this->encomienda->monto = $this->calcularTotalPaquetes();

                // Guardar cambios
                $this->customerFormDest->update();
                $this->encomienda->save();

                // Log de la acción
                $this->infoLog('Encomienda editada: ' . $this->encomienda->code);

                $this->success('Encomienda actualizada correctamente');
                $this->editEncomiendaModal = false;
            } else {
                $this->error('Debe proporcionar la información del destinatario');
            }
        } catch (\Exception $e) {
            $this->errorLog('Error al actualizar encomienda', $e);
            $this->error('Error al actualizar la encomienda: ' . $e->getMessage());
        }
    }
    public function excelGenerate(Manifiesto $manifiesto)
    {
        $this->toast('success', 'Generando Excel', 'Manifiesto');
        $this->modalFinal = false;
        return Excel::download(new ManifiestoExport(json_decode($manifiesto->ids)), 'manifiesto.xlsx');
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
    public function addPaquete()
    {
        try {
            $rules = [
                'cantidad' => 'required|numeric|min:0.01',
                'und_medida' => 'required',
                'description' => 'required|min:3',
                'peso' => 'required|numeric|min:0.01',
                'amount' => 'required|numeric|min:0.01',
            ];
            $messages = [
                'cantidad.required' => 'Error, es necesario ingresar la cantidad!',
                'cantidad.numeric' => 'Error, la cantidad debe ser un número!',
                'cantidad.min' => 'Error, la cantidad debe ser mayor a 0!',
                'und_medida.required' => 'Error, es necesario ingresar la unidad de medida!',
                'description.required' => 'Error, es necesario ingresar la descripción!',
                'description.min' => 'Error, la descripción debe tener al menos 3 caracteres!',
                'peso.required' => 'Error, es necesario ingresar el peso!',
                'peso.numeric' => 'Error, el peso debe ser un número!',
                'peso.min' => 'Error, el peso debe ser mayor a 0!',
                'amount.required' => 'Error, es necesario ingresar el precio unitario!',
                'amount.numeric' => 'Error, el precio unitario debe ser un número!',
                'amount.min' => 'Error, el precio unitario debe ser mayor a 0!',
            ];
            $this->validate($rules, $messages);

                        if ($this->editingPaqueteId) {
                // Actualizar paquete existente
                $paquete = Paquete::where('id', $this->editingPaqueteId)
                    ->where('encomienda_id', $this->encomienda->id)
                    ->first();

                if (!$paquete) {
                    $this->error('Paquete no encontrado');
                    return;
                }

                $paquete->update([
                    'cantidad' => $this->cantidad,
                    'und_medida' => $this->und_medida,
                    'description' => $this->description,
                    'peso' => $this->peso,
                    'amount' => $this->amount,
                    'sub_total' => $this->amount * $this->cantidad,
                ]);

                $this->success('Paquete actualizado correctamente!');
                $this->infoLog('Paquete actualizado en encomienda: ' . $this->encomienda->code);
            } else {
                // Crear nuevo paquete en la base de datos
                $paquete = Paquete::create([
                    'encomienda_id' => $this->encomienda->id,
                    'cantidad' => $this->cantidad,
                    'und_medida' => $this->und_medida,
                    'description' => $this->description,
                    'peso' => $this->peso,
                    'amount' => $this->amount,
                    'sub_total' => $this->amount * $this->cantidad,
                ]);

                $this->success('Paquete agregado correctamente!');
                $this->infoLog('Paquete agregado a encomienda: ' . $this->encomienda->code);
            }

            // Actualizar la colección de paquetes
            $this->paquetes = $this->encomienda->fresh()->paquetes;
            $this->paquetes = $this->paquetes->map(function($paquete) {
                $paquete->amount = number_format($paquete->amount, 2, '.', '');
                return $paquete;
            });

            // Limpiar campos del formulario
            $this->resetPaqueteForm();

        } catch (\Exception $e) {
            $this->errorLog('Error al agregar paquete', $e);
            $this->error('Error al agregar paquete: ' . $e->getMessage());
        }
    }
    public function restPaquete($id)
    {
        try {
            // Buscar el paquete en la base de datos
            $paquete = Paquete::where('id', $id)
                ->where('encomienda_id', $this->encomienda->id)
                ->first();

            if (!$paquete) {
                $this->error('Paquete no encontrado');
                return;
            }

            // Eliminar el paquete de la base de datos
            $paquete->delete();

            // Actualizar la colección de paquetes
            $this->paquetes = $this->encomienda->fresh()->paquetes;
            $this->paquetes = $this->paquetes->map(function($paquete) {
                $paquete->amount = number_format($paquete->amount, 2, '.', '');
                return $paquete;
            });

            $this->success('Paquete eliminado correctamente!');

            // Log de la acción
            $this->infoLog('Paquete eliminado de encomienda: ' . $this->encomienda->code);

        } catch (\Exception $e) {
            $this->errorLog('Error al eliminar paquete', $e);
            $this->error('Error al eliminar paquete: ' . $e->getMessage());
        }
    }

    public function resetPaquete()
    {
        try {
            // Eliminar todos los paquetes de la encomienda
            Paquete::where('encomienda_id', $this->encomienda->id)->delete();

            // Limpiar la colección de paquetes
            $this->paquetes = collect([]);

            $this->success('Todos los paquetes han sido eliminados correctamente!');

            // Log de la acción
            $this->infoLog('Todos los paquetes eliminados de encomienda: ' . $this->encomienda->code);

        } catch (\Exception $e) {
            $this->errorLog('Error al eliminar todos los paquetes', $e);
            $this->error('Error al eliminar paquetes: ' . $e->getMessage());
        }
    }

    /**
     * Verifica si una encomienda es editable
     */
    private function isEncomiendaEditable(Encomienda $encomienda): bool
    {
        return $encomienda->tipo_comprobante === 'TICKET' &&
               in_array($encomienda->estado_encomienda, ['REGISTRADO', 'RETORNADO']);
    }

    /**
     * Obtiene el mensaje de error para encomiendas no editables
     */
    private function getEditableErrorMessage(Encomienda $encomienda): string
    {
        if ($encomienda->tipo_comprobante !== 'TICKET') {
            return 'Solo se pueden editar encomiendas con tipo de comprobante TICKET';
        }

        if (!in_array($encomienda->estado_encomienda, ['REGISTRADO', 'RETORNADO'])) {
            return 'Solo se pueden editar encomiendas en estado REGISTRADO o RETORNADO';
        }

        return 'La encomienda no es editable';
    }

    /**
     * Limpia los campos del formulario de paquetes
     */
    private function resetPaqueteForm()
    {
        $this->cantidad = null;
        $this->und_medida = 'NIU';
        $this->description = null;
        $this->peso = null;
        $this->amount = null;
        $this->editingPaqueteId = null;
    }

    /**
     * Calcula el total de los paquetes
     */
    private function calcularTotalPaquetes()
    {
        return $this->paquetes->sum('sub_total');
    }

    /**
     * Valida que la encomienda tenga al menos un paquete
     */
    private function validarPaquetes()
    {
        if ($this->paquetes->isEmpty()) {
            $this->error('La encomienda debe tener al menos un paquete');
            return false;
        }
        return true;
    }

        /**
     * Edita un paquete existente
     */
    public function editPaquete($id)
    {
        try {
            $paquete = Paquete::where('id', $id)
                ->where('encomienda_id', $this->encomienda->id)
                ->first();

            if (!$paquete) {
                $this->error('Paquete no encontrado');
                return;
            }

            // Cargar datos del paquete en el formulario
            $this->editingPaqueteId = $paquete->id;
            $this->cantidad = $paquete->cantidad;
            $this->und_medida = $paquete->und_medida;
            $this->description = $paquete->description;
            $this->peso = $paquete->peso;
            $this->amount = $paquete->amount;

            $this->success('Paquete cargado para edición');

        } catch (\Exception $e) {
            $this->errorLog('Error al cargar paquete para edición', $e);
            $this->error('Error al cargar paquete: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un paquete existente
     */
    public function updatePaquete($id)
    {
        try {
            $rules = [
                'cantidad' => 'required|numeric|min:0.01',
                'und_medida' => 'required',
                'description' => 'required|min:3',
                'peso' => 'required|numeric|min:0.01',
                'amount' => 'required|numeric|min:0.01',
            ];
            $messages = [
                'cantidad.required' => 'Error, es necesario ingresar la cantidad!',
                'cantidad.numeric' => 'Error, la cantidad debe ser un número!',
                'cantidad.min' => 'Error, la cantidad debe ser mayor a 0!',
                'und_medida.required' => 'Error, es necesario ingresar la unidad de medida!',
                'description.required' => 'Error, es necesario ingresar la descripción!',
                'description.min' => 'Error, la descripción debe tener al menos 3 caracteres!',
                'peso.required' => 'Error, es necesario ingresar el peso!',
                'peso.numeric' => 'Error, el peso debe ser un número!',
                'peso.min' => 'Error, el peso debe ser mayor a 0!',
                'amount.required' => 'Error, es necesario ingresar el precio unitario!',
                'amount.numeric' => 'Error, el precio unitario debe ser un número!',
                'amount.min' => 'Error, el precio unitario debe ser mayor a 0!',
            ];
            $this->validate($rules, $messages);

            $paquete = Paquete::where('id', $id)
                ->where('encomienda_id', $this->encomienda->id)
                ->first();

            if (!$paquete) {
                $this->error('Paquete no encontrado');
                return;
            }

            // Actualizar el paquete
            $paquete->update([
                'cantidad' => $this->cantidad,
                'und_medida' => $this->und_medida,
                'description' => $this->description,
                'peso' => $this->peso,
                'amount' => $this->amount,
                'sub_total' => $this->amount * $this->cantidad,
            ]);

            // Actualizar la colección de paquetes
            $this->paquetes = $this->encomienda->fresh()->paquetes;
            $this->paquetes = $this->paquetes->map(function($paquete) {
                $paquete->amount = number_format($paquete->amount, 2, '.', '');
                return $paquete;
            });

            // Limpiar campos del formulario
            $this->resetPaqueteForm();

            $this->success('Paquete actualizado correctamente!');

            // Log de la acción
            $this->infoLog('Paquete actualizado en encomienda: ' . $this->encomienda->code);

        } catch (\Exception $e) {
            $this->errorLog('Error al actualizar paquete', $e);
            $this->error('Error al actualizar paquete: ' . $e->getMessage());
        }
    }
}
