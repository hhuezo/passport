<?php

namespace App\Http\Controllers;

use App\UbicacionGeografica;
use Illuminate\Http\Request;

class UbicacionGeograficaController extends Controller
{


    public function get_departamento(Request $request)
    {
        $departamentos = UbicacionGeografica::where('UGE_DGE_CODIGO','=','DP')->get();

        $response = array("val" => "0", "mensaje" =>  "OK","resultado"=>$departamentos);

        return response()->json(
            $response,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );

    }

    public function get_municipio($id)
    {
        $departamento = UbicacionGeografica::findOrFail($id);

        $municipios = UbicacionGeografica::where('UGE_DGE_CODIGO','=','MU')->where('UGE_UGE_CODIGO','=',$departamento->UGE_CODIGO)->get();

        $response = array("val" => "0", "mensaje" =>  "OK","resultado"=>$municipios);

        return response()->json(
            $response,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );

    }
}
