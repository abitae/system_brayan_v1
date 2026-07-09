<?php

namespace App\Models\Facturacion;

use App\Models\Configuration\Company;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despatche extends Model
{
    use HasFactory;
    protected $fillable = [
        'encomienda_id',
        'tipoDoc',
        'serie',
        'correlativo',
        'fechaEmision',
        'company_id',
        'flete_id',
        'remitente_id',
        'destinatario_id',
        'codTraslado', //
        'modTraslado',
        'docsTraslado', //array de documentos
        'fecTraslado',
        'pesoTotal',
        'undPesoTotal',
        'llegada_ubigueo',
        'llegada_direccion',
        'partida_ubigueo',
        'partida_direccion',
        'chofer_tipoDoc',
        'chofer_nroDoc',
        'chofer_licencia',
        'chofer_nombres',
        'chofer_apellidos',
        'vehiculo_placa',
        'xml_path',
        'xml_hash',
        'cdr_description',
        'cdr_code',
        'cdr_note',
        'cdr_path',
        'mtoIGV',
        'valorVenta',
        'mtoImpVenta',
        'monto_letras',
        'setPercent',
        'setMount',
        'errorCode',
        'errorMessage',
        'ticket',
        'estado',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function flete()
    {
        return $this->belongsTo(Customer::class, 'flete_id', 'id');
    }
    public function remitente()
    {
        return $this->belongsTo(Customer::class, 'remitente_id', 'id');
    }
    public function destinatario()
    {
        return $this->belongsTo(Customer::class, 'destinatario_id', 'id');
    }
    public function details()
    {
        return $this->hasMany(DespatcheDetail::class);
    }
    public function encomienda()
    {
        return $this->belongsTo(Encomienda::class);
    }
}
