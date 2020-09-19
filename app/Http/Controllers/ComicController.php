<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Inventario;
use App\Sucursal;

class ComicController extends Controller{

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

    public function comics(){
        return view('comics.comics');
    }
    //obtener comics
    public function obtener_comics(){
        define('VT_URL', 'https://gateway.marvel.com:443/v1/public/comics?ts='.$this->fechatimestamp.'&apikey='.$this->publickey.'&hash='.$this->md5);
        //respuesta de API
        $respuesta = $this->cliente->request('GET', VT_URL, []);
        $resultado = json_decode($respuesta->getBody());
    	$data=array();
    	foreach ($resultado->data->results as $comic){
            if(empty($comic->images)){
                $urlimage = url('/').'/images/defaultcomic.png';
            }else{
                $urlimage = $comic->images[0]->path.'.'.$comic->images[0]->extension;
            }
      		$data[]=array(
	                "0"=> '<button type="button" class="btn btn-block bg-gradient-primary btn-sm" onclick="obtenerdatoscomic('.$comic->id.')"><i class="fas fa-eye"></i> Ver </button>',
	                "1"=> '<b onclick="obtenerdatoscomic('.$comic->id.')">'.$comic->title.'</b>',
	                "2"=>$comic->issueNumber,
	                "3"=>'<img src="'.$urlimage.'" height="50" width="50" onclick="obtenerdatoscomic('.$comic->id.')">'
          	);
    	}
        $results=array(
            "sEcho"=>1, //informacion para date tables
            "iTotalRecords"=>count($data),//Enviamos el total de registros en datatable
            "iTotalDisplayRecords"=>count($data), //Enviamos el total de registros a vizualisar
            "aaData"=>$data);
        echo json_encode($results);//Enviamos a la vista todos los resultados
    }
    //obtener datos del comic
    public function obtener_datos_comic(Request $request){
        $idcomic = $request->id;
        define('VT_URL', 'https://gateway.marvel.com:443/v1/public/comics/'.$idcomic.'?ts='.$this->fechatimestamp.'&apikey='.$this->publickey.'&hash='.$this->md5);
        //respuesta de API
        $respuesta = $this->cliente->request('GET', VT_URL, []);
        $resultado = json_decode($respuesta->getBody());
        $comic = $resultado->data->results[0];
        if(empty($comic->images)){
            $urlimage = url('/').'/images/defaultcomic.png';
        }else{
            $urlimage = $comic->images[0]->path.'.'.$comic->images[0]->extension;
        }
        //disponibilidad en sucursales
        $disponibilidadsucursales = [];
        $Inventario = Inventario::where('idcomic', $idcomic)->get();
        foreach($Inventario as $i){
                $Sucursal = Sucursal::where('id', $i->idsucursal)->first();
                array_push($disponibilidadsucursales, $Sucursal->nombre);
        }
        $datos = array(
            'imagen' => $urlimage,
            'titulo' => $comic->title,
            'volumen' => $comic->issueNumber,
            'fechalanzamiento' => $comic->modified,
            'paginas' => $comic->pageCount,
            'descripcion' => $comic->description,
            'disponibilidadsucursales' => $disponibilidadsucursales,
            'personajes' => $comic->characters->items
        );
        return response()->json($datos);
    }
    //obtener datos personaje
    public function obtener_datos_personaje(Request $request){
        $idpersonaje = $request->id;
        define('VT_URL', 'https://gateway.marvel.com:443/v1/public/characters/'.$idpersonaje.'?ts='.$this->fechatimestamp.'&apikey='.$this->publickey.'&hash='.$this->md5);
        //respuesta de API
        $respuesta = $this->cliente->request('GET', VT_URL, []);
        $resultado = json_decode($respuesta->getBody());
        $imagenpersonaje = $resultado->data->results[0]->thumbnail->path.'.'.$resultado->data->results[0]->thumbnail->extension;
        return response()->json($imagenpersonaje);
    }
}
