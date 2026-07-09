<?php

namespace App\Livewire\Caja;

use App\Livewire\Forms\CajaForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Livewire\Forms\ExitCajaForm;
use App\Models\Caja\Caja;
use App\Traits\CajaTrait;
use App\Traits\UtilsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class CajaLive extends Component
{
    use Toast, CajaTrait, UtilsTrait, WithPagination, WithoutUrlPagination;

    public CajaForm $cajaForm;
    public EntryCajaForm $entryForm;
    public ExitCajaForm $exitForm;
    public string $title = 'CAJA';
    public string $sub_title = 'Modulo de caja';

    public bool $showHistory = false;
    public bool $openCaja = false;
    public bool $modalCaja = false;
    public bool $modalEntry = false;
    public bool $modalExit = false;

    public $fechaActual;
    public $caja;
    public int $perPage = 10;

    public function mount(): void
    {
        $this->fechaActual = $this->dateNow('Y-m-d');
        $this->loadCajaActiva();
    }

    public function render()
    {
        if ($this->caja) {
            $this->caja->load(['entries', 'exits']);
        }

        return view('livewire.caja.caja-live', [
            'cajas' => $this->cajaListPaginate(Auth::user(), $this->perPage),
            'headersHistory' => $this->getHeadersHistory(),
            'headersIngreso' => $this->getHeadersIngreso(),
            'headersEgreso' => $this->getHeadersEgreso(),
            'tipos' => $this->getTiposIngreso(),
            'tipos2' => $this->getTiposEgreso(),
            'metodoPagos' => $this->getMetodosPago(),
            'stats' => $this->getCajaStats(),
        ]);
    }

    private function loadCajaActiva(): void
    {
        $this->caja = $this->cajaIsActive(Auth::user());
        $this->openCaja = (bool) $this->caja;

        if ($this->caja) {
            $this->caja->load(['entries', 'exits']);
        }
    }

    private function getMetodosPago(): array
    {
        return [
            ['id' => 'Efectivo', 'name' => 'Efectivo'],
            ['id' => 'Yape', 'name' => 'Yape'],
            ['id' => 'Transferencia', 'name' => 'Transferencia'],
            ['id' => 'Deposito', 'name' => 'Depósito'],
        ];
    }

    private function getCajaStats(): array
    {
        if (! $this->caja) {
            return [];
        }

        $ingresosEfectivo = $this->caja->entries->where('metodo_pago', 'Efectivo')->sum('monto_entry');
        $ingresosOtros = $this->caja->entries->where('metodo_pago', '!=', 'Efectivo')->sum('monto_entry');
        $egresosEfectivo = $this->caja->exits->where('metodo_pago', 'Efectivo')->sum('monto_exit');
        $egresosOtros = $this->caja->exits->where('metodo_pago', '!=', 'Efectivo')->sum('monto_exit');
        $saldoEfectivo = $this->caja->monto_apertura + $ingresosEfectivo - $egresosEfectivo;

        return [
            'apertura' => (float) $this->caja->monto_apertura,
            'ingresos_total' => (float) $this->caja->entries->sum('monto_entry'),
            'egresos_total' => (float) $this->caja->exits->sum('monto_exit'),
            'saldo_efectivo' => (float) $saldoEfectivo,
            'ingresos_efectivo' => (float) $ingresosEfectivo,
            'ingresos_otros' => (float) $ingresosOtros,
            'egresos_efectivo' => (float) $egresosEfectivo,
            'egresos_otros' => (float) $egresosOtros,
            'movimientos' => $this->caja->entries->count() + $this->caja->exits->count(),
        ];
    }

    private function getHeadersIngreso(): array
    {
        return [
            ['key' => 'tipo_entry', 'label' => 'Tipo', 'class' => ''],
            ['key' => 'description', 'label' => 'Descripción', 'class' => ''],
            ['key' => 'metodo_pago', 'label' => 'Método', 'class' => ''],
            ['key' => 'monto_entry', 'label' => 'Monto', 'class' => 'text-right'],
        ];
    }

    private function getHeadersEgreso(): array
    {
        return [
            ['key' => 'tipo_exit', 'label' => 'Tipo', 'class' => ''],
            ['key' => 'description', 'label' => 'Descripción', 'class' => ''],
            ['key' => 'metodo_pago', 'label' => 'Método', 'class' => ''],
            ['key' => 'monto_exit', 'label' => 'Monto', 'class' => 'text-right'],
        ];
    }

    private function getHeadersHistory(): array
    {
        return [
            ['key' => 'estado', 'label' => 'Estado', 'class' => 'w-1'],
            ['key' => 'created_at', 'label' => 'Apertura', 'class' => ''],
            ['key' => 'updated_at', 'label' => 'Cierre', 'class' => ''],
            ['key' => 'monto_apertura', 'label' => 'Apertura S/.', 'class' => 'text-right'],
            ['key' => 'ingresos', 'label' => 'Ingresos', 'class' => ''],
            ['key' => 'egresos', 'label' => 'Egresos', 'class' => ''],
            ['key' => 'monto_cierre', 'label' => 'Cierre S/.', 'class' => 'text-right'],
            ['key' => 'action', 'label' => '', 'class' => 'w-1'],
        ];
    }

    private function getTiposIngreso()
    {
        return [
            ['id' => 'Devolucion', 'name' => 'Devolución'],
            ['id' => 'Efectivo', 'name' => 'Efectivo'],
            ['id' => 'Ticket', 'name' => 'Ticket'],
        ];
    }

    private function getTiposEgreso()
    {
        return [
            ['id' => 'Devolucion', 'name' => 'Pago'],
            ['id' => 'Efectivo', 'name' => 'Efectivo'],
            ['id' => 'Ticket', 'name' => 'Ticket'],
        ];
    }

    public function openModal()
    {
        $this->cajaForm->reset();
        if ($this->openCaja) {
            $this->cajaForm->monto_cierre = $this->calcularMontoEfectivoActual();
        }
        $this->modalCaja = true;
    }

    public function save()
    {
        if ($this->openCaja) {
            $this->updateCaja();
        } else {
            $this->storeCaja();
        }
    }

    private function updateCaja()
    {
        $montoEfectivoActual = $this->calcularMontoEfectivoActual();

        if ($this->cajaForm->monto_cierre == $montoEfectivoActual) {
            if ($this->cajaForm->update($this->caja)) {
                $this->success('Caja cerrada correctamente');
                $this->modalCaja = false;
                $this->openCaja = false;
                $this->caja = null;
                return;
            }
            $this->error('Error, verifique los datos!');
        } else {
            $this->error('Error, el monto de cierre no coincide con el saldo actual!');
        }

        $this->modalCaja = false;
    }

    private function calcularMontoEfectivoActual()
    {
        return $this->caja->monto_apertura +
            $this->caja->entries->whereIn('metodo_pago', ['Efectivo'])->sum('monto_entry') -
            $this->caja->exits->whereIn('metodo_pago', ['Efectivo'])->sum('monto_exit');
    }

    private function storeCaja()
    {
        $this->caja = $this->cajaForm->store();

        if ($this->caja) {
            $this->success('Caja abierta correctamente');
            $this->modalCaja = false;
            $this->openCaja = true;
            $this->loadCajaActiva();
            return;
        }

        $this->error('Error, verifique los datos!');
    }

    public function entryCaja()
    {
        if (!$this->openCaja) {
            $this->error('No hay caja abierta para registrar ingresos!');
            return;
        }

        $this->entryForm->caja_id = $this->caja->id;

        if ($this->entryForm->store()) {
            $this->success('Ingreso registrado correctamente');
            $this->modalEntry = false;
            $this->entryForm->reset();
            $this->loadCajaActiva();
            return;
        }

        $this->error('Error, verifique los datos!');
        $this->modalEntry = false;
    }

    public function exitCaja()
    {
        if (!$this->openCaja) {
            $this->error('No hay caja abierta para registrar egresos!');
            return;
        }

        $this->exitForm->caja_id = $this->caja->id;

        if ($this->exitForm->store()) {
            $this->success('Egreso registrado correctamente');
            $this->modalExit = false;
            $this->exitForm->reset();
            $this->loadCajaActiva();
            return;
        }

        $this->error('Error, verifique los datos!');
        $this->modalExit = false;
    }

    public function printCaja(Caja $caja)
    {
        return $this->cajaPrint($caja);
    }
}
