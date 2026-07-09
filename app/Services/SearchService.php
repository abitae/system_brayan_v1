<?php

namespace App\Services;

class SearchService {

    public function document($tipo, $num_doc)
    {
        $tipo_busqueda = 'completa';
        $password = "facturalaya_cris_JPckC4FPGYHtMR5"; //AQUÍ TU PASSWORD 
        if ($tipo == 'dni') {
            $ruta = "https://facturalahoy.com/api/persona/" . $num_doc . '/' . $password . '/' . $tipo_busqueda;
        } elseif ($tipo == 'ruc') {
            $ruta = "https://facturalahoy.com/api/empresa/" . $num_doc . '/' . $password . '/' . $tipo_busqueda;
        } else {
            $resp['respuesta'] = 'error';
            $resp['titulo'] = 'Error';
            $resp['mensaje'] = 'Tipo de Documento Desconocido';
            return collect($resp);
        }
    
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $ruta,
            CURLOPT_USERAGENT => 'Consulta Datos',
            CURLOPT_CONNECTTIMEOUT => 0,
            CURLOPT_TIMEOUT => 400,
            CURLOPT_FAILONERROR => true
        ));
    
        $data = curl_exec($curl);
        if (curl_error($curl)) {
            $error_msg = curl_error($curl);
        }
    
        curl_close($curl);
    
        if (isset($error_msg)) {
            $resp['respuesta'] = 'error';
            $resp['titulo'] = 'Error';
            $resp['data'] = $data;
            $resp['encontrado'] = false;
            $resp['mensaje'] = 'Error en Api de Búsqueda';
            $resp['errores_curl'] = $error_msg;
            return $resp;
        }
    
        $data_resp = json_decode($data);
        if (!isset($data_resp->respuesta) || $data_resp->respuesta == 'error') {
            $resp['respuesta'] = 'error';
            $resp['titulo'] = 'Error';
            $resp['encontrado'] = false;
            $resp['data_resp'] = $data;
            return $resp;
        }
    
        $departamento = '';
        $provincia = '';
        $distrito = '';
        $texto_ubigeo = '';
        /*
        if (isset($data_resp->codigo_ubigeo) && !empty($data_resp->codigo_ubigeo)) {
            $ubigeo = SunatCodigoubigeo::findFirst(array("codigo_ubigeo = :codigo_ubigeo:", 'bind' => array('codigo_ubigeo' => $data_resp->codigo_ubigeo)));
            if ($ubigeo) {
                $departamento = $ubigeo->departamento;
                $provincia = $ubigeo->provincia;
                $distrito = $ubigeo->distrito;
                $texto_ubigeo = $departamento . ' - ' . $provincia . ' - ' . $distrito;
            }
        }
    
        if ($tipo == 'dni') {
            if (isset($data_resp->api->result->depaDireccion) && isset($data_resp->api->result->provDireccion) && isset($data_resp->api->result->distDireccion)) {
                $ubigeo = SunatCodigoubigeo::findFirst(array("departamento = :departamento: and provincia = :provincia: and distrito = :distrito:", 'bind' => array('departamento' => $data_resp->api->result->depaDireccion, 'provincia' => $data_resp->api->result->provDireccion, 'distrito' => $data_resp->api->result->distDireccion)));
                if ($ubigeo) {
                    $departamento = $ubigeo->departamento;
                    $provincia = $ubigeo->provincia;
                    $distrito = $ubigeo->distrito;
                    $texto_ubigeo = $departamento . ' - ' . $provincia . ' - ' . $distrito;
                    $resp['texto_ubigeo'] = $texto_ubigeo;
                    $resp['codigo_ubigeo'] = $ubigeo->codigo_ubigeo;
                }
            }
        }
        */
    
        $resp['respuesta'] = 'ok';
        $resp['encontrado'] = true;
        $resp['api'] = true;
        $resp['data'] = json_decode($data);
        $resp['texto_ubigeo'] = $texto_ubigeo;
    
        return $resp;
    }
}
