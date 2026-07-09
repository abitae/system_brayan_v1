<?php

namespace App\Http\Controllers;

use App\Models\Configuration\Sucursal;
use App\Models\Frontend\Message;
use App\Models\Frontend\Reclamacion;
use App\Models\Package\Encomienda;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::where('isActive', 1)->get();

        return view('web.index', compact('sucursales'));
    }
    public function rastrea()
    {
        return view('web.rastrea');
    }
    public function abount()
    {
        return view('web.nosotros');
    }
    public function contact()
    {
        return view('web.contacto');
    }
    public function terminos()
    {
        return view('web.terminos');
    }

    public function comunicate()
    {
        return view('web.partial.comunicate');
    }

    public function cotiza()
    {
        return view('web.partial.cotiza');
    }

    public function rastreo()
    {
        return view('web.rastrea');
    }

    public function agencias()
    {
        return view('web.partial.terminales');
    }

    public function tarifario()
    {
        return view('web.partial.tarifario');
    }
    public function prohibiciones()
    {
        return view('web.partial.prohibiciones');
    }
    public function terminales()
    {
        return view('web.partial.terminales');
    }
    public function envia()
    {
        return view('web.partial.envia');
    }
    public function trackingSearch(Request $request)
    {
        $request->validate(
            [
                'tracking' => 'required',
                'code' => 'required',
            ]
        );
        $encomienda = Encomienda::where('code', $request->tracking)
            ->whereHas('remitente', function ($query) use ($request) {
                $query->where('code', $request->code);
            })
            ->orWhereHas('destinatario', function ($query) use ($request) {
                $query->where('code', $request->code);
            })
            ->first();

        if ($encomienda) {
            return view('web.rastrea', compact('encomienda'));
        } else {
            return view('web.rastrea');
        }
    }
    public function contactForm(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'select' => 'required',
            'message' => 'required',
            'politicas' => 'required',
        ];
        $messages = [
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'phone.required' => 'El teléfono es requerido',
        ];
        $validated = $request->validate($rules, $messages);
        if ($validated['politicas'] == 'on') {
            Message::create($validated);
            return view('web.contacto')->with('success', 'Mensaje enviado correctamente');
        } else {
            return redirect()->back()->with('error', 'Debes aceptar las políticas de privacidad');
        }
    }
    public function servicios()
    {
        return view('web.services');
    }
    public function reclamaciones()
    {
        return view('web.reclamos');
    }
    public function reclamacionesForm(Request $request)
    {
        $rules = [
            'reclamo_nombre' => 'required',
            'reclamo_documento' => 'required|numeric',
            'reclamo_telefono' => 'required',
            'reclamo_email' => 'required|email',
            'reclamo_direccion' => 'required',
            'reclamo_tipo' => 'required',
            'reclamo_producto' => 'required',
            'reclamo_monto' => 'required|numeric',
            'reclamo_descripcion' => 'required',
            'reclamo_politicas' => 'required',
        ];
        $messages = [
            'reclamo_nombre.required' => 'El nombre es requerido',
            'reclamo_documento.required' => 'El documento es requerido',
            'reclamo_documento.numeric' => 'El documento debe ser un número',
        ];
        $validated = $request->validate($rules, $messages);

        if ($validated['reclamo_politicas'] == 'on') {
            Reclamacion::create($validated);
            return view('web.reclamos')->with('success', 'Reclamación enviada correctamente');
        } else {
            return redirect()->back()->with('error', 'Debes aceptar las políticas de privacidad');
        }
    }
    public function courier()
    {
        return view('web.services.courier');
    }
    public function mudanza()
    {
        return view('web.services.mudanza');
    }
    public function almacen()
    {
        return view('web.services.almacen');
    }
    public function doorToDoor()
    {
        return view('web.services.door-to-door');
    }
    public function recojo()
    {
        return view('web.services.recojo');
    }
    public function cargaConsolidada()
    {
        return view('web.services.carga-consolidada');
    }
    public function trasladoVehiculos()
    {
        return view('web.services.traslado-vehiculos');
    } 
    public function trasladoContenedores()
    {
        return view('web.services.traslado-contenedores');
    }
}
