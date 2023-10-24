<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
            <form id="formUsuario" name="formUsuario" class="form-horizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>
              
              <div class="row">
                <div class="col">
                    <label for="txtIdentificacion">Identificación</label>
                    <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
                </div>
              </div>

              <div class="row">
                <div class="col">
                    <label for="txtNombre">Nombres</label>
                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                </div>
                <div class="col">
                    <label for="txtApellido">Apellidos</label>
                    <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                </div>
              </div>

              <div class="row">
                <div class="col">
                    <label for="txtTelefono">Teléfono</label>
                    <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                </div>
                <div class="col">
                    <label for="txtEmail">Email</label>
                    <input type="text" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                </div>
              </div>
              <div class="row">
                <div class="col">
                    <label for="listRolid">Tipo Usuario</label>
                    <select data-live-search="true" name="listRolid" id="listRolid" class="form-control" required=""></select>
                </div>
                <div class="col">
                    <label for="listStatus">Status</label>
                    <select name="listStatus" id="listStatus" class="form-control selectpicker" required="">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
              </div>

              <div class="row">
                <div class="col">
                    <label for="txtPassword">Password</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                </div>
              </div>
              <br>
              <center>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                
              </div>
              </center>
            </form>
      </div>
      
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Usuario</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
           <table class="table table-bordered">
            <tbody>
              <tr>
                <td>Identificación:</td>
                <td id="celIdentificacion"></td>
              </tr>
              <tr>
                <td>Nombres:</td>
                <td id="celNombre">Sebastian</td>
              </tr>
              <tr>
                <td>Apellidos:</td>
                <td id="celApellido">Ospina</td>
              </tr>
              <tr>
                <td>Telefono:</td>
                <td id="celTelefono">3005946581</td>
              </tr>
              <tr>
                <td>Email:</td>
                <td id="celEmail">ospixd@gmail.com</td>
              </tr>
              <tr>
                <td>Tipo de Usuario:</td>
                <td id="celTipoUsuario">Administrador</td>
              </tr>
              <tr>
                <td>Estado:</td>
                <td id="celEstado">Activo</td>
              </tr>
              <tr>
                <td>Fecha Registro:</td>
                <td id="celFechaRegistro">09/08/1998</td>
              </tr>
            </tbody>
           </table> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


