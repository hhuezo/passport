<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poblacion extends Model
{
    protected $table = 'poblacion';

    protected $primaryKey = 'ID';

    public $timestamps = false;


    protected $fillable = [
        'POB_NRO_DUI',
        'POB_NOMBRES',
        'POB_APELLIDO_PATERNO',
        'POB_APELLIDO_MATERNO',
        'POB_APELLIDO_CASADA',
        'POB_DOMICILIO',
        'POB_UGE_DGE_CODIGO',
        'POB_UGE_CODIGO',
        'POB_FECHA_DE_NACIMIENTO',
        'POB_DUI_EMISION',
        'POB_DUI_VENCIMIENTO',
        'POB_DGE_NACIMIENTO',
        'POB_UGE_NACIMIENTO',
        'POB_PAI_NACIMIENTO',
        'POB_CONOCIDO_POR',
        'POB_NRO_EXPEDIENTE_ISSS',
        'POB_NRO_EXPEDIENTE_MINSAL',
        'POB_NRO_SEGURO_PRIVADO',
        'POB_TELEFONO_PERSONAL',
        'POB_TELEFONO_LABORAL',
        'POB_EMAIL',
        'POB_SEXO',
        'POB_ESTADO_CIVIL',
        'POB_GRUPO_SANGUINEO',
        'POB_FACTOR_RH',
        'POB_OCU_CODIGO',
        'POB_ALERGIAS',
        'POB_MEDICACION_PERMANENTE',
        'POB_ESTATURA',
        'POB_PESO',
        'POB_PIN',
        'POB_ESTADO',
        'POB_FECHA_INGRESO',
        'POB_USUARIO_INGRESO',
        'POB_OBSERVACIONES',
        'POB_CATEGORIA'
    ];

    protected $guarded = [];

    public function fotografias()
    {
        return $this->hasMany('App\Fotografia', 'FPO_POB_NRO_DUI', 'FPO_POB_NRO_DUI');
    }
}
