<?php

namespace App\Models\Facturacion;

use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'encomienda_id',
        'sucursal_id',
        'company_id',
        'client_id',
        'tipoDoc',
        'tipoOperacion',
        'serie',
        'correlativo',
        'fechaEmision',
        'formaPago_moneda',
        'formaPago_tipo',
        'tipoMoneda',
        'mtoOperGravadas',
        'mtoIGV',
        'totalImpuestos',
        'valorVenta',
        'subTotal',
        'mtoImpVenta',
        'monto_letras',
        'codBienDetraccion',
        'codMedioPago',
        'ctaBanco',
        'setPercent',
        'setMount',
        'observacion',
        'legends',
        'note_reference',
        'xml_path',
        'xml_hash',
        'cdr_description',
        'cdr_code',
        'cdr_note',
        'cdr_path',
        'errorCode',
        'errorMessage',
        'docAdjunto',
        'docAdjunto_type',
        'estado',
        'baja_ticket',
        'baja_cdr_path',
        'baja_motivo',
    ];

    /**
     * Relación con la compañía.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    /**
     * Relación con la encomienda.
     */
    public function encomienda()
    {
        return $this->belongsTo(Encomienda::class);
    }

    /**
     * Relación con el cliente.
     */
    public function client()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relación con los detalles de la factura.
     */
    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
