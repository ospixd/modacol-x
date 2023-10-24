<?= headerAdmin($data);?>
<div id="contentAjax"></div>
<main class="app-content">
 
 <?php
 getModal('modalCategorias',$data);
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
          <h1><i class="bi bi-tags-fill"></i> <?= $data['page_tag'] ?>
          <?php if($_SESSION['permisosMod']['w']){ ?>
          <button class="btn btn-primary" type="button" onclick="openModal();"><i class="bi bi-plus-circle-fill"></i>Nuevo</button>
          <?php } ?>
          </h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>categorias"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableCategorias">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Descripcion</th>
                      <th>Estatus</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php } ?>
    </main>
<?= footerAdmin($data); ?>