<?php
namespace App\Models\Facturacion;

use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
            'company_id',
            'customer_id',
            'sucursal_id',
            'ublVersion',
            'tipoDoc',
            'serie',
            'correlativo',
            'fechaEmision',
            'tipoDocAfectado',
            'numDocfectado',
            'codMotivo',
            'desMotivo',
            'tipoMoneda',
            'mtoOperGravadas',
            'mtoIGV',
            'totalImpuestos',
            'mtoImpVenta',
            'monto_letras',
            'legends',
            'xml_path',
            'xml_hash',
            'cdr_description',
            'cdr_code',
            'cdr_note',
            'cdr_path',
            'errorCode',
            'errorMessage',
            'estado',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function client()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    /**
     * Relación con los detalles de la factura.
     */
    public function details()
    {
        return $this->hasMany(NoteDetail::class);
    }
}
