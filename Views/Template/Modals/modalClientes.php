<!-- Modal -->
<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
            <form id="formCliente" name="formCliente" class="form-horizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              
              <div class="row">
                <div class="col">
                    <label for="txtIdentificacion">Identificación <span class="required">*</span></label>
                    <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
                </div>
                <div class="col">
                    <label for="txtNombre">Nombres <span class="required">*</span></label>
                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                </div>
                <div class="col">
                    <label for="txtApellido">Apellidos <span class="required">*</span></label>
                    <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                </div>
              </div>
            <div class="row">
                <div class="col">
                    <label for="txtTelefono">Teléfono <span class="required">*</span></label>
                    <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                </div>
                <div class="col">
                    <label for="txtEmail">Email <span class="required">*</span></label>
                    <input type="text" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                </div>
                <div class="col">
                    <label for="txtPassword">Password</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                </div>
                <hr>
                <p class="text-primary">Datos Fiscales.</p>
              </div>
              <div class="row">
                <div class="col">
                      <label>Identificación o NIT <span class="required">*</span></label>
                      <input class="form-control" type="text" id="txtNit" name="txtNit" required="">
                 </div>
                 <div class="col">
                      <label>Nombre Fiscal <span class="required">*</span></label>
                      <input class="form-control" type="text" id="txtNombreFiscal" name="txtNombreFiscal" required="">
                </div>
                </div>
                <div class="col">
                      <label>Dirección Fiscal <span class="required">*</span></label>
                      <input class="form-control" type="text" id="txtDirFiscal" name="txtDirFiscal" required="">
                    </div>
    
              
                <br>
                <center>
              <div class="form-row">
                
              </div>
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
<div class="modal fade" id="modalViewCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Cliente</h5>
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
                <td>Identificación Tributaria:</td>
                <td id="celIde"></td>
              </tr>
              <tr>
                <td>Nombre Fiscal:</td>
                <td id="celNomFiscal"></td>
              </tr>
              <tr>
                <td>Dirección Fiscal:</td>
                <td id="celDirFiscal"></td>
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


