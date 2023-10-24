<?= headerAdmin($data); 
?>
    <main class="app-content">
     
      <div class="app-title">
        <div>
          <h1><i class="bi bi-speedometer"></i> <?= $data['page_title'] ?></h1>
          
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard">Dashboard</a></li>
        </ul>
      </div>
      <?php
        if(!empty($_SESSION['permisos'][2]['r'])) {
      ?>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <a style="text-decoration: none;" href="<?= base_url(); ?>usuarios">
          <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
            <div class="info">
              <h4>Usuarios</h4>
              <p><b><?= $data['usuarios'] ?></b></p>
            </div>
          </div>
          </a>
        </div>
        <?php
        }
        ?>
        <?php
        if(!empty($_SESSION['permisos'][3]['r'])){
        ?>
        <div class="col-md-6 col-lg-3">
        <a style="text-decoration: none;" href="<?= base_url(); ?>clientes">
          <div class="widget-small info coloured-icon"><i class="icon bi bi-person-fill fs-1"></i>
            <div class="info">
              <h4>Clientes</h4>
              <p><b><?= $data['clientes'] ?></b></p>
            </div>
          </div>
          </a>
        </div>
        <?php
        }
        ?>
        <?php
        if(!empty($_SESSION['permisos'][4]['r'])){
        ?>
        <div class="col-md-6 col-lg-3">
        <a style="text-decoration: none;" href="<?= base_url(); ?>productos">
          <div class="widget-small warning coloured-icon"><i class="icon bi bi-archive fs-1"></i>
            <div class="info">
              <h4>Productos</h4>
              <p><b><?= $data['productos'] ?></b></p>
            </div>
          </div>
          </a>
        </div>
        <?php
        }
        ?>
        <?php
        if(!empty($_SESSION['permisos'][5]['r'])){
        ?>
        <div class="col-md-6 col-lg-3">
        <a style="text-decoration: none;" href="<?= base_url(); ?>pedidos">
          <div class="widget-small danger coloured-icon"><i class="icon bi bi-cart-fill fs-1"></i>
            <div class="info">
              <h4>Pedidos</h4>
              <p><b><?= $data['pedidos'] ?></b></p>
            </div>
          </div>
          </a>
        </div>
        <?php
        }
        ?>
      </div>
     
      <div class="row">
      <?php
        if(!empty($_SESSION['permisos'][5]['r'])){
      ?>
      <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Últimos Pedidos</h3>
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Referencia</th>
                  <th>Cliente</th>
                  <th>Estado</th>
                  <th>Monto</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if(count($data['lastOrders']) > 0){
                    foreach($data['lastOrders'] as $pedido){
                ?>
                <tr>
                  <td><?= $pedido['referenciacobro'] ?></td>
                  <td><?= $pedido['nombre'] ?></td>
                  <td><?= $pedido['status'] ?></td>
                  <td><?= SMONEY.' '.formatMoney($pedido['monto']); ?></td>
                  <td><a href="<?= base_url() ?>pedidos/orden/<?= $pedido['idpedido'] ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                </tr>
                <?php
                  }
                }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php
        }
        ?>
        <div class="col-md-6">
          <div class="tile">
            <div class="container-title">
            <h3 class="tile-title">últimos productos</h3>
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Referencia</th>
                  <th>Producto</th>
                  <th>Monto</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if(count($data['productosTen']) > 0){
                    foreach($data['productosTen'] as $producto){
                ?>
                <tr>
                  <td><?= $producto['idproducto'] ?></td>
                  <td><?= $producto['nombre'] ?></td>
                  <td><?= SMONEY.' '.formatMoney($producto['precio']); ?></td>
                  <td><a href="<?= base_url() ?>tienda/producto/<?= $producto['idproducto'].'/'.$producto['ruta'] ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                </tr>
                <?php
                  }
                }
                  ?>
              </tbody>
            </table>
            </div>
          </div>
          
        </div>
      </div>

      <div class="row">
      <div class="col-md-12">
          <div class="tile">
          <div class="container-title">
            <h3 class="tile-title">Ventas por mes</h3>
            <div class="dflex">
              <input class="date-picker ventasMes" name="ventasMes" placeholder="Mes y Año">
              <button type="button" class="btnVentasMes btn btn-info btn-sm" onclick="fntSearchVMes();"><i class="fas fa-search"></i></button>
            </div>
          </div>
          <div id="graficaMes"></div>
          </div>
        </div>
        
      </div>
      
      
    </main>
<?= footerAdmin($data); ?>

<script>

Highcharts.chart('graficaMes', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Ventas de <?= $data['ventasMDia']['mes'].' del '.$data['ventasMDia']['anio'] ?>'
    },
    subtitle: {
        text: 'Total Ventas <?= SMONEY.'. '.formatMoney($data['ventasMDia']['total']);  ?>'
    },
    xAxis: {
        categories: [
          <?php
        foreach ($data['ventasMDia']['ventas'] as $dia) {
          echo $dia['dia'].",";
        }
      ?>
        ]
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: '',
        data: [<?php
        foreach ($data['ventasMDia']['ventas'] as $dia) {
          echo $dia['total'].",";
        }
      ?>]
    }]
});



</script>
   