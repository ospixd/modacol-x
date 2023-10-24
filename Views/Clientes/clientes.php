<?= headerAdmin($data); ?>
<main class="app-content">
<?php
getModal('modalClientes',$data);
if(empty($_SESSION['permisosMod']['r'])){
?>
<div class="text-center accesorestringido">
<img src="<?= media(); ?>/images/AccesoRestringido.png" alt="">
</div>
<?php
}else{
?>
      <div class="app-title">
        <div>
          <h1><i class="bi bi-person-lines-fill"></i> <?= $data['page_title'] ?>
          <?php if($_SESSION['permisosMod']['w']){ ?>
          <button class="btn btn-primary" type="button" onclick="openModal();"><i class="bi bi-plus-circle-fill"></i>Nuevo</button>
          <?php } ?>
          </h1>
          
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>clientes"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableClientes">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Identificacion</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Teléfono</th>
                      <th>Email</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
}
?>
    </main>
<?= footerAdmin($data); ?>