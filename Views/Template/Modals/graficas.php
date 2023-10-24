<?php
if($grafica = "tipoPagoMes"){
    $pagosMes = $data;
?>

<script>
    Highcharts.chart('pagosMesAnio', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Ventas por tipo pago, <?= $pagosMes['mes'].' '.$pagosMes['anio'] ?>',
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
          foreach($pagosMes['tipospago'] as $pagos){
            echo "{name:'".$pagos['tipopago']."',y:".$pagos['total']."},";
          }
          ?>
          ]
    }]
});
</script>
<?php 
}  
?>
<?php
if($grafica = "ventasMes") {
    $ventasMes = $data;
?>
<script>
    Highcharts.chart('graficaMes', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Ventas de <?= $ventasMes['mes'].' del '.$ventasMes['anio'] ?>'
    },
    subtitle: {
        text: 'Total Ventas <?= SMONEY.'. '.formatMoney($ventasMes['total']);  ?>'
    },
    xAxis: {
        categories: [
          <?php
        foreach ($ventasMes['ventas'] as $dia) {
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
        foreach ($ventasMes['ventas'] as $dia) {
          echo $dia['total'].",";
        }
      ?>]
    }]
});
</script>
<?php } ?>
<?php
if($grafica = "ventasAnio") {
    $ventasAnio = $data;
?>
<script>
    Highcharts.chart('graficaAnio', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Ventas del año <?=  $ventasAnio['anio'] ?>'
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
            foreach ( $ventasAnio['meses'] as $mes) {
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

<?php
}
?>
