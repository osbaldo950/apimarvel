<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
	protected $table = 'inventario';//necesario para reconocer la tabla
    protected $fillable = [
        'idcomic', 
        'idsucursal', 
        'descripcion',
        'cantidad'
    ];
}
