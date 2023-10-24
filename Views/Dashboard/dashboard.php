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
            <h3 class="tile-title">Tipo de pagos por mes</h3>
            <div class="dflex">
              <input class="date-picker pagoMes" name="pagoMes" placeholder="Mes y Año">
              <button type="button" class="btnTipoVentaMes btn btn-info btn-sm" onclick="fntSearchPagos();"><i class="fas fa-search"></i></button>
            </div>
            </div>
            <div id="pagosMesAnio"></div>
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
        <div class="col-md-12">
          <div class="tile">
          <div class="container-title">
            <h3 class="tile-title">Ventas por año</h3>
            <div class="dflex">
              <input class="ventasAnio" name="ventasAnio" placeholder="Año" minlength="4" maxlength="4" onkeypress="return controlTag(event);">
              <button type="button" class="btnVentasAnio btn btn-info btn-sm" onclick="fntSearchVAnio();"><i class="fas fa-search"></i></button>
            </div>
            </div>
            <div id="graficaAnio"></div>
          </div>
      </div>
        </div>
      </div>
      
      
    </main>
<?= footerAdmin($data); ?>

<script>
  Highcharts.chart('pagosMesAnio', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Ventas por tipo pago, <?= $data['pagosMes']['mes'].' '.$data['pagosMes']['anio'] ?>',
        align: 'left'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
          <?php
          foreach($data['pagosMes']['tipospago'] as $pagos){
            echo "{name:'".$pagos['tipopago']."',y:".$pagos['total']."},";
          }
          ?>
          ]
    }]
});

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


Highcharts.chart('graficaAnio', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Ventas del año <?=  $data['ventasAnio']['anio'] ?>'
    },
    subtitle: {
        text: 'Estadisticas de las ventas por mes'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
      formatter: function () {
            return '<b>' + this.point.name + '</b>: ' + formatCurrency(this.y);
        }
    },
    series: [{
        name: 'Population',
        colors: [
            '#9b20d9', '#9215ac', '#861ec9', '#7a17e6', '#7010f9', '#691af3',
            '#6225ed', '#5b30e7', '#533be1', '#4c46db', '#4551d5', '#3e5ccf',
            '#3667c9', '#2f72c3', '#277dbd', '#1f88b7', '#1693b1', '#0a9eaa',
            '#03c69b',  '#00f194'
        ],
        colorByPoint: true,
        groupPadding: 0,
        data: [
          <?php
            foreach ( $data['ventasAnio']['meses'] as $mes) {
              echo "['".$mes['mes']."',".$mes['venta']."],";
            }
          ?>
            
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            formatter: function () {
              return formatCurrency(this.y);
            },
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});

function formatCurrency(value){
  return '$' + value.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}


</script>
   