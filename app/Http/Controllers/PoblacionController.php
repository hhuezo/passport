<?php

namespace App\Http\Controllers;

use App\Fotografia;
use App\Poblacion;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PoblacionController extends Controller
{

    public function index()
    {
        $dni = '03544132-0';
        $formato = preg_match("/^[0-9]{8}-[0-9]{1}$/", $dni);

        return $formato;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $PVAL = 0;
        $PMENSAJE = NULL;
        if ($request) {
            $registro = Poblacion::where('POB_NRO_DUI', '=', $request->get('PDUI'))->count();
            if ($registro == 0) {

                if (filter_var($request->get('PCORREO'), FILTER_VALIDATE_EMAIL)) {

                    if (preg_match("/^[0-9]{8}-[0-9]{1}$/", $request->get('PDUI')) == 1) {

                        //creando token de 6 digitos
                        $TOKEN = rand(100000, 999999);
                        $time = Carbon::now('America/El_Salvador');

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
                        $poblacion->POB_FECHA_DE_NACIMIENTO = $request->get('PFECHA_NACIMIENTO');
                        $poblacion->POB_PIN = $TOKEN;
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
                         $user->name = $request->get('PNOMBRES').' '.$request->get('PAPELLIDO_PATERNO').' '.$request->get('PAPELLIDO_MATERNO');
                         $user->username = $request->get('PDUI');
                         $user->password = Hash::make($TOKEN) ;
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
        $response = array("val" => $PVAL, "mensaje" =>  $PMENSAJE);
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


    public function edit($id)
    {
        //
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
