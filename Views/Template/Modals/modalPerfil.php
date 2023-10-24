<!-- Modal -->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Datos</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
            <form id="formPerfil" name="formPerfil" class="form-horizontal">
          
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="txtIdentificacion">Identificación <span class="required">*</span></label>
                    <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" value="<?= $_SESSION['userData']['identificacion']; ?>" required="">
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                    <label for="txtNombre">Nombres <span class="required">*</span></label>
                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['nombres']; ?>" required="">
                </div>
                <div class="col">
                    <label for="txtApellido">Apellidos <span class="required">*</span></label>
                    <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" value="<?= $_SESSION['userData']['apellidos']; ?>" required="">
                </div>
              </div>

              <div class="row">
                <div class="col">
                    <label for="txtTelefono">Teléfono <span class="required">*</span></label>
                    <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" value="<?= $_SESSION['userData']['telefono']; ?>" required="" onkeypress="return controlTag(event);">
                </div>
                <div class="col">
                    <label for="txtEmail">Email</label>
                    <input type="text" class="form-control valid validEmail" id="txtEmail" name="txtEmail" value="<?= $_SESSION['userData']['email_user']; ?>" required="" readonly disabled>
                </div>
              </div>

              <div class="row">
                <div class="col">
                    <label for="txtPassword">Password</label>
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                </div>
                <div class="col">
                    <label for="txtPasswordConfirm">Confirmar Password</label>
                    <input type="password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm">
                </div>
              </div>
              <br>
              <center>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-info" type="submit"><i class="bi bi-check-circle-fill me-2"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                
              </div>
              </center>
            </form>
      </div>
      
    </div>
  </div>
</div>



