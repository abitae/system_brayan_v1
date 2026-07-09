<?php

namespace App\Models\Package;

use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomienda extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'user_id',
        'transportista_id',
        'vehiculo_id',
        'customer_id',
        'sucursal_id',
        'customer_dest_id',
        'sucursal_dest_id',
        'customer_fact_id',
        'cantidad',
        'monto',
        'monto_descuento',
        'motivo_descuento',

        'doc_ticket', //documento de traslado
        'doc_guia',
        'doc_factura',
        //Fechas
        'fecha_creacion',
        'fecha_envio',
        'fecha_recepcion',
        'fecha_entrega',
        'fecha_retorno',

        'estado_pago', //PAGADO , CONTRA ENTREGA
        'tipo_pago', // Contado, Credito
        'metodo_pago', // Efectivo, Yape, Tarjeta, Trasnferencia
        'tipo_comprobante', // TICKET, FACTURA, BOLETA

        'estado_credito', // Pendiente, Cancelado
        'docsTraslado', //json de documentos
        'glosa',
        'observation',
        'estado_encomienda', //REGISTRADO, ENVIADO,RECIBIDO,RETORNADO, ENTREGADO
        'pin',
        'isTransbordo',
        'isHome',
        'isReturn',
        'isActive',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transportista()
    {
        return $this->belongsTo(Transportista::class);
    }
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
    public function remitente()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function sucursal_remitente()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id', 'id');
    }
    public function destinatario()
    {
        return $this->belongsTo(Customer::class, 'customer_dest_id', 'id');
    }
    public function facturacion()
    {
        return $this->belongsTo(Customer::class, 'customer_fact_id', 'id');
    }
    public function sucursal_destinatario()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_dest_id', 'id');
    }
    public function paquetes()
    {
        return $this->hasMany(Paquete::class);
    }
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    public function despatche()
    {
        return $this->hasOne(Despatche::class);
    }
}
