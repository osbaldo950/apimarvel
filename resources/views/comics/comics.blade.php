@extends('master_template')
@section('title')
  Comics
@endsection
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Comics</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="table-responsive card-body">
          <table id="tbllistado" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Operaciones</th>
                <th>Nombre</th>
                <th>Volumen</th>
                <th>Imagen</th>
              </tr>
            </thead>
            <tbody>                    
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal fade" id="modalinfocomic">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Datos Comic</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Imagen Comic</h3>
                                <div class="card-tools">
                                    <button id="btncambiarpersonaje" type="button" class="btn btn-tool"  data-source="widgets.html" data-source-selector="#card-refresh-content">
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                              <img id="imagencomic" width="100%" height="100%">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Datos Comic</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">                                    
                                        <strong><i class="fas fa-th-list mr-1"></i> Titulo</strong>
                                        <p class="text-muted" id="titulocomic"></p>
                                    </div>
                                    <div class="col-md-6">  
                                        <strong><i class="fas fa-th-list mr-1"></i> Volumen</strong>
                                        <p class="text-muted" id="volumencomic"></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">   
                                        <strong><i class="fas fa-th-list mr-1"></i> Fecha Lanzamiento</strong>
                                        <p class="text-muted" id="fechalanzamientocomic"></p>
                                    </div>
                                    <div class="col-md-6"> 
                                        <strong><i class="fas fa-th-list mr-1"></i> Páginas</strong>
                                        <p class="text-muted" id="paginascomic"></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6"> 
                                        <strong><i class="fas fa-th-list mr-1"></i> Descripción</strong>
                                        <p class="text-muted" id="descripcioncomic"></p>
                                    </div>
                                    <div class="col-md-6"> 
                                        <strong><i class="fas fa-th-list mr-1"></i> Disponibilidad Sucursales</strong>
                                        <p class="text-muted" id="disponibilidadsucursales"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Personajes (da click sobr el personaje para visualizar su imagen)</h3>
                            </div>
                            <div class="card-body">
                                <div class="row" id="divpersonajes">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Imagen Personaje</h3>
                                <div class="card-tools">
                                    <button id="btncambiarpersonaje" type="button" class="btn btn-tool"  data-source="widgets.html" data-source-selector="#card-refresh-content">
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                              <img id="imagenpersonaje" width="100%" height="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('additionals_js')
    <script>
        var obtener_comics='{!!URL::to('obtener_comics')!!}';
        var obtener_datos_comic='{!!URL::to('obtener_datos_comic')!!}';
        var obtener_datos_personaje='{!!URL::to('obtener_datos_personaje')!!}';
    </script>
    <script src="{{asset('js/scripts_app/comics.js')}}"></script> 
@endsection