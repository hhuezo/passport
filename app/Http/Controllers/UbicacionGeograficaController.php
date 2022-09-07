<?php

namespace App\Http\Controllers;

use App\UbicacionGeografica;
use Illuminate\Http\Request;

class UbicacionGeograficaController extends Controller
{


    public function get_departamento(Request $request)
    {
        $departamento = UbicacionGeografica::where('UGE_DGE_CODIGO','=','DP')->get();

        $response = array("val" => "0", "mensaje" =>  "OK","resultado"=>$departamento);

        return response()->json(
            $response,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );

    }
}
