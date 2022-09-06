<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fotografia extends Model
{
    protected $table = 'fotografias_poblacion';

    protected $primaryKey = 'ID';

    public $timestamps = false;


    protected $fillable = [
        'FPO_POB_NRO_DUI',
        'FPO_FOTOGRAFIA',
        'FPO_ESTADO',
        'FPO_FECHA_INGRESO'
    ];


    protected $guarded = [];


    public function poblacion()
    {
        return $this->belongsTo('App\Poblacion', 'FPO_POB_NRO_DUI', 'POB_NRO_DUI');
    }
}
