<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Sucursal;
use App\Inventario;

class SucursalController extends Controller{

    public function __construct(){
        $this->fechatimestamp = Carbon::now()->toDateTimeString();
        $this->privatekey = config('app.marvelprivatekey');
        $this->publickey = config('app.marvelpublickey');
        $this->llaves = $this->privatekey.$this->publickey;
        $this->string = $this->fechatimestamp.$this->llaves;
        $this->md5 = md5($this->string);
        //crear cliente Guzzle HTTP
        $this->cliente = new Client();
    }

    public function sucursales(){
        return view('sucursales.sucursales');
    }
    //obtener sucursales
    public function obtener_sucursales(){
        $surcursales = Sucursal::where('estado', 'ACTIVO')->get();
    	$data=array();
    	foreach ($surcursales as $surcursal){
            $boton =    '<div class="btn bg-gradient-primary btn-xs" onclick="asignarexistencias('.$surcursal->id.')">Asignar Existencias</div> '. 
                        '<div class="btn bg-gradient-warning btn-xs waves-effect"  onclick="modificarsucursal('.$surcursal->id.',\''.$surcursal->nombre.'\',\''.$surcursal->direccion.'\',\''.$surcursal->estado.'\')"> Modificar</div> ';
      		$data[]=array(
	                "0"=> $boton,
	                "1"=> $surcursal->codigo,
                    "2"=> $surcursal->nombre,
                    "3"=> $surcursal->direccion,
                    "4"=> $surcursal->estado
          	);
    	}
        $results=array(
            "sEcho"=>1, //informacion para date tables
            "iTotalRecords"=>count($data),//Enviamos el total de registros en datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a vizualisar
            "aaData"=>$data);
        echo json_encode($results);//Enviamos a la vista todos los resultados
    }
    //guardar
    public function sucursales_guardar(Request $request){
        $ultimoid = Sucursal::select("id")->orderBy("id", "DESC")->take(1)->get();
        if(sizeof($ultimoid) == 0 || sizeof($ultimoid) == "" || sizeof($ultimoid) == null){
            $id = 1;
        }else{
            $id = $ultimoid[0]->id+1;   
        }
		$Sucursal = new Sucursal;
		$Sucursal->id=$id;
		$Sucursal->codigo='S-'.$id;
		$Sucursal->nombre=$request->nombre;
		$Sucursal->direccion=$request->direccion;
        $Sucursal->estado=$request->estado;
        $Sucursal->save();
        return response()->json($Sucursal);
    }
    //modificar
    public function sucursales_modificar(Request $request){
		$Sucursal = Sucursal::where('id', $request->idsucursal)->first();
		$Sucursal->nombre=$request->nombresucursal;
		$Sucursal->direccion=$request->direccionsucursal;
        $Sucursal->estado=$request->estadosucursal;
        $Sucursal->save();
        return response()->json($Sucursal);
    }
    //obtener comics
    public function sucursales_obtener_comics(Request $request){
        define('VT_URL', 'https://gateway.marvel.com:443/v1/public/comics?ts='.$this->fechatimestamp.'&apikey='.$this->publickey.'&hash='.$this->md5);
        //respuesta de API
        $respuesta = $this->cliente->request('GET', VT_URL, []);
        $resultado = json_decode($respuesta->getBody());
    	$data=array();
    	foreach ($resultado->data->results as $comic){
            //existencias del comic
            $Inventario = Inventario::where('idsucursal', $request->idsucursal)->where('idcomic', $comic->id)->first();
            if($Inventario == null){
                $checkbox = '<input type="checkbox" class="comicssucursal" onchange="construirarraycomic()" value="'.$comic->id.'">';
            }else{
                $checkbox = '<input type="checkbox" class="comicssucursal" onchange="construirarraycomic()" value="'.$comic->id.'" checked>';
            }
            if(empty($comic->images)){
                $urlimage = url('/').'/images/defaultcomic.png';
            }else{
                $urlimage = $comic->images[0]->path.'.'.$comic->images[0]->extension;
            }
      		$data[]=array(
	                "0"=> $checkbox,
	                "1"=> '<b onclick="obtenerdatoscomic('.$comic->id.')">'.$comic->title.'</b>',
	                "2"=>$comic->issueNumber,
	                "3"=>'<img src="'.$urlimage.'" height="30" width="30" onclick="obtenerdatoscomic('.$comic->id.')">'
          	);
    	}
        $results=array(
            "sEcho"=>1, //informacion para date tables
            "iTotalRecords"=>count($data),//Enviamos el total de registros en datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a vizualisar
            "aaData"=>$data);
        echo json_encode($results);//Enviamos a la vista todos los resultados
    }
    //guardar existencias sucursal
    public function existencias_sucursal(Request $request){
        //elimiar primero
        Inventario::where('idsucursal', $request->idsucursalcomics)->forceDelete();
        foreach (explode(",", $request->string_comic) as $idcomic) {
            $Inventario = new Inventario;
            $Inventario->idcomic = $idcomic;
            $Inventario->idsucursal = $request->idsucursalcomics;
            $Inventario->descripcion = 'descripcion';
            $Inventario->cantidad = 1;
            $Inventario->save();

        }
    }
}
