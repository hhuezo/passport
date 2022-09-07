<?php

namespace App\Http\Controllers;

use App\Fotografia;
use App\Poblacion;
use App\UbicacionGeografica;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PoblacionController extends Controller
{

    public function index()
    {

    }

    public function create()
    {
        //
    }

    function format_date($fecha)
    {
        return substr($fecha,6,4).'-'.substr($fecha,3,2).'-'.substr($fecha,0,2);
    }

    public function store(Request $request)
    {

        $PVAL = 0;
        $PMENSAJE = NULL;
        $PIN = NULL;
        if ($request) {
            $registro = Poblacion::where('POB_NRO_DUI', '=', $request->get('PDUI'))->count();
            if ($registro == 0) {

                //validando formato de correo
                if (filter_var($request->get('PCORREO'), FILTER_VALIDATE_EMAIL)) {

                    //validando formato de dui
                    if (preg_match("/^[0-9]{8}-[0-9]{1}$/", $request->get('PDUI')) == 1) {

                        //creando token de 6 digitos
                        $PIN = rand(100000, 999999);
                        $time = Carbon::now('America/El_Salvador');

                        $fecha_nacimiento = $this->format_date($request->get('PFECHA_NACIMIENTO'));

                        //creando registro en poblacion
                        $poblacion = new Poblacion();
                        $poblacion->POB_NRO_DUI = $request->get('PDUI');
                        $poblacion->POB_NOMBRES = $request->get('PNOMBRES');
                        $poblacion->POB_APELLIDO_PATERNO = $request->get('PAPELLIDO_PATERNO');
                        $poblacion->POB_APELLIDO_MATERNO = $request->get('PAPELLIDO_MATERNO');
                        $poblacion->POB_APELLIDO_CASADA = $request->get('PAPELLIDO_CASADA');
                        $poblacion->POB_DOMICILIO = $request->get('POB_DOMICILIO');
                        $poblacion->POB_UGE_DGE_CODIGO = 'MU';
                        $poblacion->POB_UGE_CODIGO = $request->get('PMUNICIPIO');
                        $poblacion->POB_FECHA_DE_NACIMIENTO =  $fecha_nacimiento;
                        $poblacion->POB_PIN = $PIN;
                        $poblacion->POB_SEXO = $request->get('PGENERO');
                        $poblacion->POB_EMAIL = $request->get('PCORREO');
                        $poblacion->POB_ESTADO = 'REG';
                        $poblacion->POB_TELEFONO_PERSONAL = $request->get('PTELEFONO');
                        $poblacion->POB_USUARIO_INGRESO = $request->get('PUSUARIO');
                        $poblacion->POB_FECHA_INGRESO = $time->toDateTimeString();
                        $poblacion->POB_CATEGORIA = $request->get('PCATEGORIA');
                        $poblacion->save();

                        //creando registro en fotografia
                        $fotografia = new Fotografia();
                        $fotografia->FPO_POB_NRO_DUI = $request->get('PDUI');
                        $fotografia->FPO_FOTOGRAFIA = $request->get('FPO_FOTOGRAFIA');
                        $fotografia->FPO_ESTADO = 'A';
                        $fotografia->FPO_FECHA_INGRESO = $time->toDateTimeString();
                        $fotografia->save();

                        //creando registro en usuario
                        $user = new User();
                        $user->name = $request->get('PNOMBRES') . ' ' . $request->get('PAPELLIDO_PATERNO') . ' ' . $request->get('PAPELLIDO_MATERNO');
                        $user->username = $request->get('PDUI');
                        $user->password = Hash::make($PIN);
                        $user->save();

                        $PMENSAJE = 'PRE-REGISTRO DE USUARIO REALIZADO CORRECTAMENTE';
                    } else {
                        $PVAL = 1;
                        $PMENSAJE =  'EL NÚMERO DE DUI QUE USTED INTENTA INGRESAR NO TIENE FORMATO VÁLIDO, VERIFIQUE.\n';
                    }
                } else {
                    $PVAL = 1;
                    $PMENSAJE =  'EL FORMATO DE LA CUENTA DE CORREO NO ES VÁLIDO, VERIFIQUE.\n';
                }
            } else {
                $PVAL = 1;
                $PMENSAJE = 'ESTIMADO USUARIO, LE INFORMAMOS QUE POSEE UN USUARIO CREADO EN LA PÁGINA WEB, PUEDE INGRESAR CON SU USUARIO Y CONTRASEÑA EN NUESTRA APLICACIÓN MÓVIL.';
            }
        }
        $response = array("val" => $PVAL, "mensaje" =>  $PMENSAJE,"pin"=> $PIN);
        return response()->json(
            $response,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }


    public function show($id)
    {
        //
    }


    public function get_poblacion($id)
    {
        $PVAL = 1;
        $PMENSAJE = NULL;

        $poblacion = Poblacion::findOrFail($id);
        if($poblacion)
        {
            $municipio = UbicacionGeografica::findOrFail($poblacion->POB_UGE_CODIGO);

            $departamento = UbicacionGeografica::where('UGE_CODIGO','=',$municipio->UGE_UGE_CODIGO)->first();

            $poblacion->POB_DEPARTAMENTO = $departamento->ID;

            $fotografia = Fotografia::where('FPO_POB_NRO_DUI','=',$poblacion->POB_NRO_DUI)->first();

            $poblacion->FPO_FOTOGRAFIA = $fotografia->FPO_FOTOGRAFIA;

            $PVAL = 0;
            $PMENSAJE = "OK";
        }


        $response = array("val" => $PVAL, "mensaje" =>   $PMENSAJE,"resultado"=>$poblacion);
        return response()->json(
            $response,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
        return $poblacion;
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
