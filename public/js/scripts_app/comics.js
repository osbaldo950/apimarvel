'use strict'
var tabla;
//funcion que se ejecuta al inicio
function init(){
   listar();
}
//listar todos los registros de la tabla
function listar(){
  tabla=$('#tbllistado').dataTable({ 
    "aProcessing":true,//activamos el prosesamiento del datatables
    "aServerside":true,//paginacion y filtrado realizados por el servidor
    "ajax":
    {
      type: "GET",
      url:obtener_comics,
      dataType :"json",
    	error:function(e){
        console.log(e.responseText);
    	}
    },
    "bDestroy": true,
    "iDisplayLength": 5,//paginacion cada 5 registros
    "order":[[1,"asc"]]  //Ordena los datos en modo decenddente
  }).dataTable();
}
//obtener datos del comic
function obtenerdatoscomic(id){
    $('#imagencomic').removeAttr("src");
    $('#imagenpersonaje').removeAttr("src");
    $.get(obtener_datos_comic, {id:id}, function(datos){ 
        var personajes = "";
        $('#imagencomic').attr("src", datos.imagen);
        $("#titulocomic").html(datos.titulo);
        $("#volumencomic").html(datos.volumen);
        $("#fechalanzamientocomic").html(datos.fechalanzamiento);
        $("#paginascomic").html(datos.paginas);
        $("#descripcioncomic").html(datos.descripcion);
        $("#disponibilidadsucursales").html(datos.disponibilidadsucursales);
        for (var i = 0; i < datos.personajes.length; i++) {
            var split_url = datos.personajes[i].resourceURI.split("/");
            personajes = personajes+'<div class="col-md-4" onclick="obtenerdatospersonaje('+split_url[6]+')">'+                                    
                                        '<p><button type="button" class="btn btn-block bg-gradient-primary btn-sm" onclick="obtenerdatospersonaje('+split_url[6]+')"><i class="fas fa-eye"></i> Ver imagen de <b>'+datos.personajes[i].name+'</b> </button></p>'+
                                    '</div>';
         }
        $("#divpersonajes").html(personajes);
        $("#modalinfocomic").modal('show');
    });
}
//obtener datos del personaje
function obtenerdatospersonaje(id){
  $("#btncambiarpersonaje").attr('data-card-widget', 'card-refresh');
    $.get(obtener_datos_personaje, {id:id}, function(datos){ 
        $('#imagenpersonaje').attr("src", datos);
    });
}
init();