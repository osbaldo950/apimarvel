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
      url:obtener_sucursales,
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
//mostrar el modal para agregar sucursal
function agregarsucursal(){
    $("#modalagregarsucursal").modal('show');
}
//guardar sucursal
//guardar el registro
$("#btnadd").on('click', function (e) {
    e.preventDefault();
    var formData = new FormData($("#formadd")[0]);
    var form = $("#formadd");
    if (form.parsley().isValid()){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:sucursales_guardar,
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success:function(data){
            toastr.success( "Datos guardados correctamente", "Mensaje", {
                "timeOut": "5000",
                "progressBar": true,
                "extendedTImeout": "5000"
            });
            var tabla = $('#tbllistado').DataTable();
            tabla.ajax.reload();
            $("#formadd")[0].reset();
            //Resetear las validaciones del formulario alta
            $("#formadd").parsley().reset();
            $("#modalagregarsucursal").modal('hide');
        },
        error:function(data){
            toastr.error( "Ocurrio un error", "Mensaje", {
                "timeOut": "5000",
                "progressBar": true,
                "extendedTImeout": "5000"
            });
        }
      })
    }else{
      form.parsley().validate();
    }
  });
//mostrar modal para modificar sucursal
function modificarsucursal(idsucursal,nombre,direccion,estado){
    $("#modalmodificarsucursal").modal('show');
    $("#idsucursal").val(idsucursal);
    $("#nombresucursal").val(nombre);
    $("#direccionsucursal").val(direccion);
    $("#estadosucursal").val(estado)
}
//modificar el registro
$("#btnupdate").on('click', function (e) {
    e.preventDefault();
    var formData = new FormData($("#formupdate")[0]);
    var form = $("#formupdate");
    if (form.parsley().isValid()){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:sucursales_modificar,
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success:function(data){
            toastr.success( "Datos guardados correctamente", "Mensaje", {
                "timeOut": "5000",
                "progressBar": true,
                "extendedTImeout": "5000"
            });
            var tabla = $('#tbllistado').DataTable();
            tabla.ajax.reload();
            $("#formupdate")[0].reset();
            //Resetear las validaciones del formulario alta
            $("#formupdate").parsley().reset();
            $("#modalmodificarsucursal").modal('hide');
        },
        error:function(data){
            toastr.error( "Ocurrio un error", "Mensaje", {
                "timeOut": "5000",
                "progressBar": true,
                "extendedTImeout": "5000"
            });
        }
      })
    }else{
      form.parsley().validate();
    }
  });
//asignar existencia
function asignarexistencias(idsucursal){
    $("#modalcomicssucursal").modal('show');
    $("#idsucursalcomics").val(idsucursal);
    tabla=$('#tbllistadocomics').dataTable({ 
        "aProcessing":true,//activamos el prosesamiento del datatables
        "aServerside":true,//paginacion y filtrado realizados por el servidor
        "ajax":
        {
          type: "GET",
          url:sucursales_obtener_comics,
          data:{'idsucursal':idsucursal},
          dataType :"json",
            error:function(e){
            console.log(e.responseText);
            }
        },
        "paging":   false,
        "info":     false,
        "searching": false,
        "bDestroy": true,
        "iDisplayLength": 50,//paginacion cada 4 registros
        "order":[[1,"asc"]]  //Ordena los datos en modo decenddente
    }).dataTable();
    construirarraycomic();
}
//construir array id comic
function construirarraycomic(){
    var array_comic = [];
    var lista = document.getElementsByClassName("comicssucursal");
    for (var i = 0; i < lista.length; i++) {
        if(lista[i].checked){
            array_comic.push(lista[i].value);
        }
    }
    $("#string_comic").val(array_comic);
}
//guardar existencias comic
$("#btnexistenciascomic").on('click', function (e) {
    e.preventDefault();
    var formData = new FormData($("#formexistenciassucursal")[0]);
    var form = $("#formexistenciassucursal");
    if (form.parsley().isValid()){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:existencias_sucursal,
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success:function(data){
            toastr.success( "Datos guardados correctamente", "Mensaje", {
                "timeOut": "5000",
                "progressBar": true,
                "extendedTImeout": "5000"
            });
            $("#formexistenciassucursal")[0].reset();
            //Resetear las validaciones del formulario alta
            $("#formexistenciassucursal").parsley().reset();
            $("#modalcomicssucursal").modal('hide');
        },
        error:function(data){
            toastr.error( "Ocurrio un error", "Mensaje", {
                "timeOut": "5000",
                "progressBar": true,
                "extendedTImeout": "5000"
            });
        }
      })
    }else{
      form.parsley().validate();
    }
  });
init();