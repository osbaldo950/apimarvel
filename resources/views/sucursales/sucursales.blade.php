@extends('master_template')
@section('title')
  Sucursales
@endsection
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Sucursales</h3>&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn bg-gradient-primary btn-sm" onclick="agregarsucursal()"><i class="fas fa-plus"></i> Agregar Sucursal </button>
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
                <th><div style="width:100px !important;">Operaciones</div></th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>                    
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalagregarsucursal">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Agregar Sucursal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formadd">
              <div class="modal-body">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Nombre</label>
                          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Dirección</label>
                          <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Estado</label>
                          <input type="text" class="form-control" id="estado" name="estado" placeholder="estado" value="ACTIVO" readonly required>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnadd">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalmodificarsucursal">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modificar Sucursal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formupdate">
              <div class="modal-body">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Nombre</label>
                          <input type="hidden" class="form-control" id="idsucursal" name="idsucursal" required>
                          <input type="text" class="form-control" id="nombresucursal" name="nombresucursal" placeholder="Nombre" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Dirección</label>
                          <input type="text" class="form-control" id="direccionsucursal" name="direccionsucursal" placeholder="Dirección" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label >Estado</label>
                          <input type="text" class="form-control" id="estadosucursal" name="estadosucursal" placeholder="estado" value="ACTIVO" readonly required>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnupdate">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalcomicssucursal">
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
                    <form id="formexistenciassucursal">
                      <input type="hidden" name="idsucursalcomics" id="idsucursalcomics" class="form-control">
                      <input type="hidden" name="string_comic" id="string_comic" class="form-control">
                    </form>
                    <div class="table-responsive col-md-12">
                      <table id="tbllistadocomics" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>Con Existencias</th>
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
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btnexistenciascomic">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('additionals_js')
    <script>
        var obtener_sucursales='{!!URL::to('obtener_sucursales')!!}';
        var sucursales_guardar='{!!URL::to('sucursales_guardar')!!}';
        var sucursales_modificar='{!!URL::to('sucursales_modificar')!!}';
        var sucursales_obtener_comics='{!!URL::to('sucursales_obtener_comics')!!}';
        var existencias_sucursal='{!!URL::to('existencias_sucursal')!!}';
    </script>
    <script src="{{asset('js/scripts_app/sucursales.js')}}"></script> 
@endsection