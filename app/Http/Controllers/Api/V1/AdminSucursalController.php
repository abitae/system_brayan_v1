<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CajaResource;
use App\Http\Resources\EncomiendaResource;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Models\User;
use App\Services\AsignacionRepartidorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdminSucursalController extends Controller
{
    public function __construct(private readonly AsignacionRepartidorService $asignacion) {}

    public function entregas(Request $request): AnonymousResourceCollection
    {
        $estado = $request->query('estado', 'pendiente');
        $sucursalId = $request->user()->sucursal_id;

        $origen = $request->query('sucursal_id');

        $encomiendas = Encomienda::query()
            ->with(['remitente', 'destinatario', 'facturacion', 'repartidor', 'paquetes', 'sucursal_remitente'])
            ->where('sucursal_dest_id', $sucursalId)
            ->where('isHome', true)
            ->when($origen, fn ($query) => $query->where('sucursal_id', $origen))
            ->when($estado === 'entregada', function ($query) {
                $query->where('estado_encomienda', 'ENTREGADO');
            }, function ($query) {
                $query->where('estado_encomienda', 'RECIBIDO')->where('isReturn', false);
            })
            ->latest('id')
            ->paginate(20);

        $origenes = Sucursal::query()
            ->whereIn('id', Encomienda::query()
                ->where('sucursal_dest_id', $sucursalId)
                ->where('isHome', true)
                ->distinct()
                ->pluck('sucursal_id'))
            ->orderBy('name')
            ->get(['id', 'name']);

        return EncomiendaResource::collection($encomiendas)->additional([
            'origenes' => $origenes,
        ]);
    }

    public function repartidores(Request $request): JsonResponse
    {
        $repartidores = User::role('Repartidor')
            ->where('sucursal_id', $request->user()->sucursal_id)
            ->where('isActive', true)
            ->whereNotNull('transportista_id')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'transportista_id']);

        return response()->json(['data' => $repartidores]);
    }

    public function asignar(Request $request, Encomienda $encomienda): EncomiendaResource
    {
        $data = $request->validate([
            'repartidor_user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $repartidor = User::findOrFail($data['repartidor_user_id']);
        $asignada = $this->asignacion->asignar($request->user(), $encomienda, $repartidor);
        $asignada->load(['remitente', 'destinatario', 'facturacion', 'repartidor', 'paquetes']);

        return new EncomiendaResource($asignada);
    }

    public function cajas(Request $request): AnonymousResourceCollection
    {
        $repartidorIds = User::role('Repartidor')
            ->where('sucursal_id', $request->user()->sucursal_id)
            ->pluck('id');

        $cajas = Caja::query()
            ->with(['entries', 'exits', 'user'])
            ->whereIn('user_id', $repartidorIds)
            ->where('isActive', true)
            ->latest('id')
            ->get();

        return CajaResource::collection($cajas);
    }
}
