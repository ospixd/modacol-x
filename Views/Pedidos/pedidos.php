<?= headerAdmin($data);?>
<div id="contentAjax"></div>
<div id="divModal"></div>
<main class="app-content">
 
 <?php

 //getModal('modalProductos',$data);



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
          <h1><i class="bi bi-box-seam-fill"></i> <?= $data['page_tag'] ?>
          </h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>pedidos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tablePedidos">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Ref. / Transacción</th>
                      <th>Fecha</th>
                      <th>Monto</th>
                      <th>Tipo pago</th>
                      <th>Metodo de pago</th>
                      <th>Estado</th>
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