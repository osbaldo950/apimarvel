<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
	protected $table = 'sucursales';//necesario para reconocer la tabla
    protected $fillable = [
        'codigo', 
        'nombre', 
        'dirrecion',
        'estado'
    ];
}
