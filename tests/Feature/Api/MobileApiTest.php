<?php

namespace Tests\Feature\Api;

use App\Models\Caja\Caja;
use App\Models\Caja\EntryCaja;
use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Facturacion\Invoice;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Paquete;
use App\Models\User;
use App\Services\EntregaDomicilioService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MobileApiTest extends TestCase
{
    use RefreshDatabase;

    private Sucursal $sucursal;

    private Sucursal $otraSucursal;

    private Transportista $chofer;

    private Vehiculo $vehiculo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sucursal = $this->sucursal('LIM', 'Lima');
        $this->otraSucursal = $this->sucursal('AQP', 'Arequipa');

        foreach (['Cliente', 'Repartidor', 'Admin sucursal'] as $role) {
            Role::findOrCreate($role, 'web');
        }

        $this->chofer = $this->transportista();
        $this->vehiculo = Vehiculo::create([
            'name' => 'ABC-123',
            'marca' => 'Toyota',
            'modelo' => 'Hilux',
            'tipo' => 'Camion',
            'isActive' => true,
        ]);
    }

    public function test_cliente_se_registra_con_su_documento_e_inicia_sesion(): void
    {
        Customer::create([
            'type_code' => '1',
            'code' => '45678901',
            'name' => 'Ana Cliente',
            'email' => 'ana@cliente.test',
            'isActive' => true,
        ]);

        $registro = $this->postJson('/api/v1/cliente/registro', [
            'name' => 'Ana Cliente',
            'email' => 'ana@cliente.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'documento' => '45678901',
        ]);

        $registro->assertCreated();
        $registro->assertJsonPath('user.roles.0', 'Cliente');

        $login = $this->postJson('/api/v1/login', [
            'email' => 'ana@cliente.test',
            'password' => 'password',
        ]);

        $login->assertOk();
        $login->assertJsonPath('user.email', 'ana@cliente.test');
    }

    public function test_los_tres_roles_pueden_iniciar_sesion(): void
    {
        $cliente = $this->usuario('cliente@test.test', 'Cliente', null, $this->cliente('1', '11111111')->id);
        $repartidor = $this->usuario('repartidor@test.test', 'Repartidor', $this->sucursal->id, null, $this->chofer->id);
        $admin = $this->usuario('admin@test.test', 'Admin sucursal', $this->sucursal->id);

        foreach ([$cliente, $repartidor, $admin] as $user) {
            $this->postJson('/api/v1/login', [
                'email' => $user->email,
                'password' => 'password',
            ])->assertOk()->assertJsonPath('user.email', $user->email);
        }
    }

    public function test_cliente_solo_ve_y_descarga_sus_comprobantes(): void
    {
        $propio = $this->cliente('1', '22222222', 'propio@test.test');
        $ajeno = $this->cliente('1', '33333333', 'ajeno@test.test');
        $usuario = $this->usuario('propio@test.test', 'Cliente', null, $propio->id);
        $company = $this->company();

        $mio = $this->invoice($company, $propio, 'F001', '1');
        $this->invoice($company, $ajeno, 'F001', '2');

        $token = $usuario->createToken('mobile')->plainTextToken;

        $this->withToken($token)->getJson('/api/v1/cliente/comprobantes')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $mio->id);

        $this->withToken($token)->getJson('/api/v1/cliente/comprobantes/'.$this->invoice($company, $ajeno, 'B001', '1')->id.'/pdf')
            ->assertForbidden();
    }

    public function test_repartidor_entrega_solo_si_esta_asignada_y_tiene_caja(): void
    {
        $repartidor = $this->usuario('driver@test.test', 'Repartidor', $this->sucursal->id, null, $this->chofer->id);
        $token = $repartidor->createToken('mobile')->plainTextToken;

        $remitente = $this->cliente('1', '44444444');
        $destinatario = $this->cliente('1', '55555555');
        $encomienda = $this->encomienda($remitente, $destinatario, $repartidor);
        $paquete = Paquete::create([
            'encomienda_id' => $encomienda->id,
            'cantidad' => 1,
            'und_medida' => 'NIU',
            'description' => 'Caja',
            'peso' => '1',
            'amount' => 10,
            'sub_total' => 10,
        ]);

        $this->withToken($token)->postJson('/api/v1/repartidor/encomiendas/'.$encomienda->id.'/entregar', [
            'documento' => '55555555',
            'pin' => 123,
            'paquetes_confirmados' => [$paquete->id],
        ])->assertStatus(422);

        Caja::create([
            'user_id' => $repartidor->id,
            'monto_apertura' => 0,
            'monto_cierre' => 0,
            'isActive' => true,
        ]);

        $this->withToken($token)->postJson('/api/v1/repartidor/encomiendas/'.$encomienda->id.'/entregar', [
            'documento' => '55555555',
            'pin' => 123,
            'paquetes_confirmados' => [$paquete->id],
        ])->assertOk()->assertJsonPath('data.estado_encomienda', 'ENTREGADO');

        $ajena = $this->encomienda($remitente, $destinatario, null);
        Paquete::create([
            'encomienda_id' => $ajena->id,
            'cantidad' => 1,
            'und_medida' => 'NIU',
            'description' => 'Sobre',
            'peso' => '1',
            'amount' => 10,
            'sub_total' => 10,
        ]);

        $this->withToken($token)->postJson('/api/v1/repartidor/encomiendas/'.$ajena->id.'/entregar', [
            'documento' => '55555555',
            'pin' => 123,
            'paquetes_confirmados' => [$ajena->paquetes()->first()->id],
        ])->assertStatus(422);
    }

    public function test_admin_solo_ve_entregas_de_su_sucursal(): void
    {
        $admin = $this->usuario('sucursal@test.test', 'Admin sucursal', $this->sucursal->id);
        $remitente = $this->cliente('1', '66666666');
        $destinatario = $this->cliente('1', '77777777');

        $propia = $this->encomienda($remitente, $destinatario, null, $this->sucursal->id);
        $this->encomienda($remitente, $destinatario, null, $this->otraSucursal->id);

        $token = $admin->createToken('mobile')->plainTextToken;

        $this->withToken($token)->getJson('/api/v1/admin/entregas')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $propia->id);

        $repartidorAjeno = $this->usuario('otro-driver@test.test', 'Repartidor', $this->otraSucursal->id, null, $this->transportista('88888888')->id);

        $this->withToken($token)->postJson('/api/v1/admin/entregas/'.$propia->id.'/asignar', [
            'repartidor_user_id' => $repartidorAjeno->id,
        ])->assertStatus(422);
    }

    public function test_cobro_a_domicilio_cierra_la_deuda_y_respeta_el_pin_guardado(): void
    {
        $repartidor = $this->usuario('cobro@test.test', 'Repartidor', $this->sucursal->id, null, $this->chofer->id);
        $facturacion = $this->cliente('1', '99999991');
        $destinatario = $this->cliente('1', '99999992');
        $encomienda = $this->encomienda($facturacion, $destinatario, $repartidor);
        $encomienda->update([
            'pin' => 456,
            'estado_pago' => 'CONTRA ENTREGA',
            'tipo_pago' => 'Credito',
            'estado_credito' => 'Pendiente',
            'tipo_comprobante' => 'TICKET',
            'customer_fact_id' => $facturacion->id,
        ]);
        $paquete = Paquete::create([
            'encomienda_id' => $encomienda->id,
            'cantidad' => 1,
            'und_medida' => 'NIU',
            'description' => 'Bolsa',
            'peso' => '1',
            'amount' => 10,
            'sub_total' => 10,
        ]);
        Caja::create([
            'user_id' => $repartidor->id,
            'monto_apertura' => 0,
            'monto_cierre' => 0,
            'isActive' => true,
        ]);

        $this->withToken($repartidor->createToken('mobile')->plainTextToken)
            ->postJson('/api/v1/repartidor/encomiendas/'.$encomienda->id.'/entregar', [
                'documento' => '99999992',
                'pin' => 456,
                'paquetes_confirmados' => [$paquete->id],
                'tipo_comprobante' => 'FACTURA',
                'metodo_pago' => 'Efectivo',
            ])
            ->assertOk()
            ->assertJsonPath('data.estado_pago', 'PAGADO')
            ->assertJsonPath('data.estado_credito', 'Cancelado')
            ->assertJsonPath('data.tipo_comprobante', 'TICKET');

        $this->assertSame(1, \App\Models\Caja\EntryCaja::query()->count());
    }

    public function test_cuentas_del_cliente_son_solo_de_facturacion(): void
    {
        $facturacion = $this->cliente('1', '12121212', 'factura@test.test');
        $otro = $this->cliente('1', '13131313');
        $usuario = $this->usuario('factura@test.test', 'Cliente', null, $facturacion->id);

        $pendiente = $this->encomienda($otro, $otro, null);
        $pendiente->update([
            'customer_fact_id' => $facturacion->id,
            'estado_pago' => 'CONTRA ENTREGA',
            'estado_credito' => 'Pendiente',
            'tipo_pago' => 'Credito',
        ]);

        $pagada = $this->encomienda($otro, $otro, null);
        $pagada->update([
            'customer_fact_id' => $facturacion->id,
            'estado_pago' => 'PAGADO',
            'estado_credito' => 'Cancelado',
        ]);

        $soloRemitente = $this->encomienda($facturacion, $otro, null);
        $soloRemitente->update([
            'customer_fact_id' => $otro->id,
            'estado_pago' => 'PAGADO',
            'estado_credito' => 'Cancelado',
        ]);

        $token = $usuario->createToken('mobile')->plainTextToken;

        $this->withToken($token)->getJson('/api/v1/cliente/cuentas-por-pagar')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $pendiente->id);

        $this->withToken($token)->getJson('/api/v1/cliente/cuentas-pagadas')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $pagada->id);
    }

    public function test_admin_filtra_entregas_por_sucursal_de_origen(): void
    {
        $admin = $this->usuario('origen@test.test', 'Admin sucursal', $this->sucursal->id);
        $remitente = $this->cliente('1', '14141414');
        $destinatario = $this->cliente('1', '15151515');

        $deLima = $this->encomienda($remitente, $destinatario, null, $this->sucursal->id);
        $deArequipa = $this->encomienda($remitente, $destinatario, null, $this->sucursal->id);
        $deArequipa->update(['sucursal_id' => $this->otraSucursal->id]);

        $token = $admin->createToken('mobile')->plainTextToken;

        $this->withToken($token)->getJson('/api/v1/admin/entregas?sucursal_id='.$this->otraSucursal->id)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $deArequipa->id)
            ->assertJsonPath('data.0.cobro', 'Cobro en agencia');

        $this->withToken($token)->getJson('/api/v1/admin/entregas')
            ->assertOk()
            ->assertJsonFragment(['id' => $deLima->id])
            ->assertJsonFragment(['id' => $deArequipa->id]);
    }

    public function test_la_oficina_no_cobra_si_asignaron_un_repartidor_mientras_tanto(): void
    {
        $oficina = $this->usuario('oficina@test.test', 'Admin sucursal', $this->sucursal->id);
        $repartidor = $this->usuario('asignado@test.test', 'Repartidor', $this->sucursal->id, null, $this->chofer->id);
        Caja::create([
            'user_id' => $oficina->id,
            'monto_apertura' => 0,
            'monto_cierre' => 0,
            'isActive' => true,
        ]);

        $remitente = $this->cliente('1', '16161616');
        $destinatario = $this->cliente('1', '17171717');
        $encomienda = $this->encomienda($remitente, $destinatario, null);
        $encomienda->update([
            'estado_pago' => 'CONTRA ENTREGA',
            'estado_credito' => 'Pendiente',
            'tipo_pago' => 'Credito',
        ]);
        $vista = Encomienda::query()->findOrFail($encomienda->id);
        $encomienda->update(['repartidor_user_id' => $repartidor->id]);

        try {
            app(EntregaDomicilioService::class)->cobrar(
                $oficina,
                $vista,
                $remitente,
                'TICKET',
                'Contado',
                'Efectivo',
            );
            $this->fail('La oficina no debe cobrar una encomienda ya asignada.');
        } catch (ValidationException $exception) {
            $this->assertNotEmpty($exception->errors());
        }

        $encomienda->refresh();
        $this->assertSame('RECIBIDO', $encomienda->estado_encomienda);
        $this->assertSame('CONTRA ENTREGA', $encomienda->estado_pago);
        $this->assertSame(0, EntryCaja::query()->count());
    }

    public function test_el_repartidor_no_cobra_si_lo_reasignaron(): void
    {
        $primero = $this->usuario('primero@test.test', 'Repartidor', $this->sucursal->id, null, $this->chofer->id);
        $segundo = $this->usuario('segundo@test.test', 'Repartidor', $this->sucursal->id, null, $this->transportista('42345678')->id);
        foreach ([$primero, $segundo] as $user) {
            Caja::create([
                'user_id' => $user->id,
                'monto_apertura' => 0,
                'monto_cierre' => 0,
                'isActive' => true,
            ]);
        }

        $remitente = $this->cliente('1', '18181818');
        $destinatario = $this->cliente('1', '19191919');
        $encomienda = $this->encomienda($remitente, $destinatario, $primero);
        $encomienda->update([
            'estado_pago' => 'CONTRA ENTREGA',
            'estado_credito' => 'Pendiente',
            'tipo_pago' => 'Credito',
        ]);
        $paquete = Paquete::create([
            'encomienda_id' => $encomienda->id,
            'cantidad' => 1,
            'und_medida' => 'NIU',
            'description' => 'Caja',
            'peso' => '1',
            'amount' => 10,
            'sub_total' => 10,
        ]);
        $vista = Encomienda::query()->findOrFail($encomienda->id);
        $encomienda->update(['repartidor_user_id' => $segundo->id]);

        try {
            app(EntregaDomicilioService::class)->entregar(
                $primero,
                $vista,
                '19191919',
                123,
                [$paquete->id],
            );
            $this->fail('El repartidor anterior no debe cobrar.');
        } catch (ValidationException $exception) {
            $this->assertNotEmpty($exception->errors());
        }

        $encomienda->refresh();
        $this->assertSame('RECIBIDO', $encomienda->estado_encomienda);
        $this->assertSame(0, EntryCaja::query()->count());
    }

    public function test_la_entrega_movil_rechaza_credito_y_metodos_desconocidos(): void
    {
        $repartidor = $this->usuario('estricto@test.test', 'Repartidor', $this->sucursal->id, null, $this->chofer->id);
        $token = $repartidor->createToken('mobile')->plainTextToken;
        $remitente = $this->cliente('1', '20202020');
        $destinatario = $this->cliente('1', '21212121');
        $encomienda = $this->encomienda($remitente, $destinatario, $repartidor);
        $encomienda->update([
            'estado_pago' => 'CONTRA ENTREGA',
            'estado_credito' => 'Pendiente',
            'tipo_pago' => 'Credito',
        ]);
        $paquete = Paquete::create([
            'encomienda_id' => $encomienda->id,
            'cantidad' => 1,
            'und_medida' => 'NIU',
            'description' => 'Caja',
            'peso' => '1',
            'amount' => 10,
            'sub_total' => 10,
        ]);
        Caja::create([
            'user_id' => $repartidor->id,
            'monto_apertura' => 0,
            'monto_cierre' => 0,
            'isActive' => true,
        ]);

        $this->withToken($token)->postJson('/api/v1/repartidor/encomiendas/'.$encomienda->id.'/entregar', [
            'documento' => '21212121',
            'pin' => 123,
            'paquetes_confirmados' => [$paquete->id],
            'tipo_pago' => 'Credito',
            'metodo_pago' => 'Efectivo',
        ])->assertStatus(422);

        $this->withToken($token)->postJson('/api/v1/repartidor/encomiendas/'.$encomienda->id.'/entregar', [
            'documento' => '21212121',
            'pin' => 123,
            'paquetes_confirmados' => [$paquete->id],
            'tipo_pago' => 'Contado',
            'metodo_pago' => 'otro',
        ])->assertStatus(422);

        $encomienda->refresh();
        $this->assertSame('RECIBIDO', $encomienda->estado_encomienda);
        $this->assertSame(0, EntryCaja::query()->count());
    }

    private function sucursal(string $code, string $name): Sucursal
    {
        return Sucursal::create([
            'code' => $code,
            'serieFactura' => 'F001',
            'serieBoleta' => 'B001',
            'serieGuiaRemision' => 'T001',
            'serieNotaCreditoFactura' => 'FC01',
            'serieNotaCreditoBoleta' => 'BC01',
            'serieNotaDebitoFactura' => 'FD01',
            'serieNotaDebitoBoleta' => 'BD01',
            'name' => $name,
            'address' => 'Av. Test 1',
            'isActive' => true,
        ]);
    }

    private function cliente(string $type, string $code, ?string $email = null): Customer
    {
        return Customer::create([
            'type_code' => $type,
            'code' => $code,
            'name' => 'Cliente '.$code,
            'email' => $email,
            'address' => 'Calle 1',
            'isActive' => true,
        ]);
    }

    private function usuario(string $email, string $role, ?int $sucursalId, ?int $customerId = null, ?int $transportistaId = null): User
    {
        $user = User::create([
            'name' => $email,
            'email' => $email,
            'password' => 'password',
            'sucursal_id' => $sucursalId,
            'customer_id' => $customerId,
            'transportista_id' => $transportistaId,
            'isActive' => true,
        ]);
        $user->assignRole($role);

        return $user;
    }

    private function transportista(string $dni = '41234567'): Transportista
    {
        return Transportista::create([
            'type_code' => '1',
            'dni' => $dni,
            'licencia' => 'L'.$dni,
            'name' => 'Chofer '.$dni,
            'tipo' => 'Principal',
            'isActive' => true,
        ]);
    }

    private function encomienda(Customer $remitente, Customer $destinatario, ?User $repartidor, ?int $sucursalDestino = null): Encomienda
    {
        $destino = $sucursalDestino ?? $this->sucursal->id;

        return Encomienda::create([
            'code' => 'ENC-'.uniqid(),
            'user_id' => $repartidor?->id ?? User::factory()->create(['sucursal_id' => $this->sucursal->id, 'isActive' => true])->id,
            'repartidor_user_id' => $repartidor?->id,
            'transportista_id' => $this->chofer->id,
            'vehiculo_id' => $this->vehiculo->id,
            'customer_id' => $remitente->id,
            'sucursal_id' => $this->sucursal->id,
            'customer_dest_id' => $destinatario->id,
            'sucursal_dest_id' => $destino,
            'customer_fact_id' => $remitente->id,
            'cantidad' => 1,
            'monto' => 10,
            'estado_pago' => 'PAGADO',
            'tipo_pago' => 'Contado',
            'tipo_comprobante' => 'TICKET',
            'estado_encomienda' => 'RECIBIDO',
            'pin' => 123,
            'isHome' => true,
            'isReturn' => false,
            'isActive' => true,
        ]);
    }

    private function company(): Company
    {
        $company = new Company;
        $company->forceFill([
            'ruc' => '20123456789',
            'razonSocial' => 'Brayan',
            'nombreComercial' => 'Brayan',
            'address' => 'Av. 1',
            'sol_user' => 'user',
            'sol_pass' => 'pass',
            'cert_path' => 'cert.pem',
        ])->save();

        return $company;
    }

    private function invoice(Company $company, Customer $customer, string $serie, string $correlativo): Invoice
    {
        return Invoice::create([
            'company_id' => $company->id,
            'client_id' => $customer->id,
            'sucursal_id' => $this->sucursal->id,
            'tipoDoc' => '01',
            'tipoOperacion' => '0101',
            'serie' => $serie,
            'correlativo' => $correlativo,
            'fechaEmision' => now()->toDateString(),
            'formaPago_moneda' => 'PEN',
            'formaPago_tipo' => 'Contado',
            'tipoMoneda' => 'PEN',
            'mtoOperGravadas' => 10,
            'mtoIGV' => 1.8,
            'totalImpuestos' => 1.8,
            'valorVenta' => 10,
            'subTotal' => 11.8,
            'mtoImpVenta' => 11.8,
            'monto_letras' => 'ONCE CON 80/100 SOLES',
        ]);
    }
}
