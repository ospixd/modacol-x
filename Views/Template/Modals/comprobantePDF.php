<?php
$cliente = $data['cliente'];
$orden = $data['orden'];
$detalle = $data['detalle'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        table{
            width: 100%;
        }
        table td, table th{
            font-size: 15px;
        }
        h4{
            margin-bottom: 0px;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-left{
            text-align: left;
        }
        .wd33{
            width: 33.33%;
        }
        .tbl-cliente{
            border: 1px solid #CCC;
            border-radius: 10px;
            padding: 5px;
        }
        .wd10{
            width: 10%;
        }
        .wd40{
            width: 40%;
        }
        .wd55{
            width: 55%;
        }
        .wd15{
            width: 15%;
        }
        .tbl-detalle{
            border-collapse: collapse;
        }
        .tbl-detalle thead th{
            padding: 5px;
            background-color: #009688;
            color: #FFF;
        }
        .tbl-detalle tbody td{
            padding: 5px;
        }
        .tbl-detalle tfoot td{
            padding: 5px;
        }
    </style>
</head>
<body>
    <table class="tbl-header">
        <tbody>
            <tr>
                <td class="wd33">
                    <img src="<?= media(); ?>/tienda/images/icons/M1.png" alt="Logo" width="150px" height="100px"> 
                </td>
                <td class="text-center wd33">
                    <h4><strong><?= NOMBRE_EMPRESA ?></strong></h4>
                    <p><?= DIRECCION ?> <br>
                    Teléfono: <?= TELEMPRESA ?> <br>
                    Email: <?= EMAIL_EMPRESA ?></p>
                    
                </td>
                <td class="text-right wd33">
                    <p>No. Orden <strong><?= $orden['referenciacobro']; ?></strong><br>
                    Fecha: <?= $orden['fecha']; ?><br>
                    Método de pago: <?= $orden['metodopago']; ?><br>
                    Transacción wompi: <?= $orden['idtransaccionpaypal']; ?>
                    </p>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="tbl-cliente">
        <tbody>
            <tr>
                <td class="wd10">NIT:</td>
                <td class="wd40"><?= $cliente['nit']; ?></td>
                <td class="wd10">Teléfono:</td>
                <td class="wd40"><?= $cliente['telefono']; ?></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><?= $cliente['nombres'].' '. $cliente['apellidos']; ?></td>
                <td>Dirección:</td>
                <td><?= $orden['direccion_envio']; ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="tbl-detalle">
        <thead>
            <tr>
            <th class="wd55 text-left">Descripcion</th>
            <th class="wd15 text-right">Precio</th>
            <th class="wd15 text-right">Cantidad</th>
            <th class="wd15 text-right">Importe</th>
            </tr>
            
        </thead>
        <tbody>
            <?php
            $subtotal = 0;
            foreach($detalle as $producto){
                $importe = $producto['precio'] * $producto['cantidad'];
                $subtotal = $subtotal + $importe;
            ?>
            <tr>
                <td class="text-left"><?= $producto['producto']; ?></td>
                <td class="text-right"><?= SMONEY.' '.formatMoney($producto['precio']); ?></td>
                <td class="text-right"><?= $producto['cantidad']; ?></td>
                <td class="text-right"><?= SMONEY.' '.formatMoney($importe); ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right">Subtotal:</td>
                <td class="text-right"><?= SMONEY.' '.formatMoney($subtotal); ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Envío:</td>
                <td class="text-right"><?= SMONEY.' '.formatMoney($orden['costo_envio']); ?></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Total:</td>
                <td class="text-right"><?= SMONEY.' '.formatMoney($orden['monto']); ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="text-center">
            <p>Si tienes dudas sobre tu pedido, <br>pongase en contacto con nombre, telefono y Email</p>
            <h4>¡Gracias por tu compra!</h4>
        </div>
</body>
</html>