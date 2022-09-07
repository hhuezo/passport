<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UbicacionGeografica extends Model
{
    protected $table = 'ubicaciones_geograficas';

    protected $primaryKey = 'ID';

    public $timestamps = false;


    protected $fillable = [
        'UGE_DGE_CODIGO',
        'UGE_CODIGO',
        'UGE_DESCRIPCION',
        'UGE_ABREVIACION',
        'UGE_UGE_DGE_CODIGO',
        'UGE_UGE_CODIGO'
    ];


    protected $guarded = [];
}
