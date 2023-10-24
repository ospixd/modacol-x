<?= headerAdmin($data);?>

<div id="divModal">
    
</div>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-receipt"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>pedidos">Pedidos</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <?php
            if(empty($data['objTransaccion'])){
            ?>
            <p>Datos no encontrados</p>
            <?php
            }else{
                //Datos transacción paypal
                // $trs = $data['objTransaccion']->purchase_units[0];
                // $cl = $data['objTransaccion']->payer;
                // $idTransaccion = $trs->payments->captures[0]->id;
                // $fecha = $trs->payments->captures[0]->create_time;
                // $estado = $trs->payments->captures[0]->status;
                // $monto = $trs->payments->captures[0]->amount->value;
                // $moneda = $trs->payments->captures[0]->amount->currency_code;

                //Datos transaccion Wompi

                $reembolso = false;

                $idTransaccion = $data['objTransaccion']->data[0]->id;
                $fecha = $data['objTransaccion']->data[0]->created_at;
                $monto = $data['objTransaccion']->data[0]->amount_in_cents;
                $metodoPago = $data['objTransaccion']->data[0]->payment_method_type;
                ($monto = substr($monto, 0, -2));
                $moneda = $data['objTransaccion']->data[0]->currency;
                $estado = $data['objTransaccion']->data[0]->status;
                if($estado == "APPROVED"){
                  $estado = "Aprobado";
                }else if($estado == "PENDING"){
                  $estado = "Pendiente";
                }else if($estado == "DECLINED"){
                  $estado = "Rechazado";
                }else if($estado == "ERROR"){
                  $estado = "Error";
                }else if($estado == "VOIDED"){
                  $estado = "Reembolzado";
                  $reembolso = true;
                  $montoreembolso = $monto;
                  $comisionreembolso = $monto*COMISIONWOMPI+MASWOMPI;
                  $ivareembolso = "-".$comisionreembolso*IVAWOMPI;
                }

                

                //Datos del cliente paypal
                // $nombreCliente = $cl->name->given_name.' '.$cl->name->surname;
                // $emailCliente = $cl->email_address;
                // $telCliente = isset($cl->phone) ? $cl->phone->phone_number->national_number : "";
                // $codCiudad = $cl->address->country_code;
                // $direccion1 = $trs->shipping->address->address_line_1;
                // $direccion2 = $trs->shipping->address->admin_area_2;
                // $direccion3 = $trs->shipping->address->admin_area_1;
                // $codPostal = $trs->shipping->address->postal_code;

                //Datos del cliente wompi
                $nombreCliente = $data['objTransaccion']->data[0]->customer_data->full_name;
                $emailCliente = $data['objTransaccion']->data[0]->customer_email;
                $telCliente = $data['objTransaccion']->data[0]->customer_data->phone_number;
                $direccion = $data['direccion'];

                //Correo Comercio paypal
                //$emailComercio = $trs->payee->email_address;

                //Detalle paypal
                // $descripcion = $trs->description;
                // $montoDetalle = $trs->amount->value;

                //Detalle wompi
                $descripcion = "Compra a Modacol-X por".$monto;

                //Detalles montos paypal
                // $totalCompra = $trs->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
                // $comision = $trs->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
                // $importeNeto = $trs->payments->captures[0]->seller_receivable_breakdown->net_amount->value;

                //Detalles montos wompi
                $totalCompra = $monto;
                $comision = $totalCompra*COMISIONWOMPI+MASWOMPI;
                $importeNeto = "-".$comision*IVAWOMPI;
                

                //Reembolso paypal
                // $reembolso = false;
                // if(isset($trs->payments->refunds)){
                //     $reembolso = true;
                //     $importeBruto = $trs->payments->refunds[0]->seller_payable_breakdown->gross_amount->value;
                //     $comisionPaypal = $trs->payments->refunds[0]->seller_payable_breakdown->paypal_fee->value;
                //     $importeNeto = $trs->payments->refunds[0]->seller_payable_breakdown->net_amount->value;
                //     $fechaReembolso = $trs->payments->refunds[0]->update_time;
                // }

                
                
                

            ?>
            <section id="sPedido" class="invoice">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header"><img src="<?= media();?>/images/wompi-logo1.png" width="120" height="120"></img></h2>
                </div>
                <?php
                    //if(!$reembolso){
                        //if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES and $metodoPago == "CARD"){
                ?>
                <!-- <div class="col-6 custom-text-right"> -->
                  <!-- <button class="btn btn-outline-primary" onClick="fntTransaccion(' $idTransaccion ?>');"><i class="fa fa-reply-all" aria-hidden="true"></i>Generar Reembolso</button> -->
                <!-- </div> -->
                <?php
                    //}
                //}
                    ?>
              </div>
              <div class="row invoice-info">
                <div class="col-4">
                  <address><strong>Transacción: <?= $idTransaccion; ?></strong><br><br>
                  <strong>Fecha: <?= $fecha; ?></strong><br>
                  <strong>Estado: <?= $estado; ?></strong><br>
                  <strong>Importe bruto en centavos: <?=SMONEY.' '.$monto; ?></strong><br>
                  <strong>Moneda: <?= $moneda; ?></strong><br>
                </address>
                </div>
                <div class="col-4">
                  <address><strong>Datos cliente</strong><br><br>
                  <strong>Nombre: <?= $nombreCliente ?></strong><br>
                  <strong>Telefono: <?= $telCliente ?></strong><br>
                  <strong>Email: <?= $emailCliente ?></strong><br>
                  <?php
                  //if(!empty($direccion)){
                  ?>
                  <!-- <strong>Dirección: <?= $direccion ?></strong><br> -->
                  <?php
                  //}else{
                  ?>
                  <?php
                  //}
                  ?>
                  </address>
                </div>
                <div class="col-4"><strong>Datos empresa</strong><br><br>
                    <strong>Nombre: <?= NOMBRE_EMPRESA ?></strong><br>
                    <strong>Telefono: <?= TELEMPRESA ?></strong><br>
                    <strong>Email: </strong> <?= EMAIL_EMPRESA ?> <br>
            </div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                    <?php
                        if($reembolso){
                    ?>
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Movimiento</th>
                                <th class="text-right">Devolución</th>
                                <th class="text-right">Comisión</th>
                                <th class="text-right">Importe neto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($_SESSION['userData']['idrol'] == RCLIENTES) { ?>
                            <tr>
                                <td><?='Reembolso para '.$nombreCliente ?></td>
                                <td class="text-right"> -<?= SMONEY.$importeBruto.' '.$moneda ?></td>
                                <td class="text-right">0.00</td>
                                <td class="text-right">0.00</td>
                            </tr>
                            <?php }else{ ?>
                            <tr>
                                <td><?='Reembolso para '.$nombreCliente ?></td>
                                <td class="text-right"> <?= SMONEY.$montoreembolso.' '.$moneda ?></td>
                                <td class="text-right"> -<?= SMONEY.$comisionreembolso.' '.$moneda ?></td>
                                <td class="text-right"> <?= SMONEY.$ivareembolso.' '.$moneda ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                        }
                        ?>
                  <table class="table">
                    <thead class="table-light">
                      <tr>
                        <th>Detalle pedido</th>
                        <th class="text-right">Cantidad</th>
                        <th class="text-right">Precio</th>
                        <th class="text-right">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                        
                      <tr>
                        <td><?= $descripcion ?></td>
                        <td class="text-right">1</td>
                        <td class="text-right"><?= SMONEY.$monto.' '.$moneda ?></td>
                        <td class="text-right"><?= SMONEY.$monto.' '.$moneda ?></td>
                        
                      </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="custom-text-right text-right"><strong>Total de la compra:</strong> </td>
                            <td class="text-right"><?= SMONEY.$monto.' '.$moneda ?></td>
                        </tr>
                  </table>
                  <?php if($_SESSION['userData']['idrol'] != RCLIENTES){ ?>
                  <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th colspan="2">Detalles del pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="250"><strong>Total de la compra</strong></td>
                            <td><?= SMONEY.$totalCompra.' '.$moneda ?></td>
                        </tr>
                        <tr>
                            <td><strong>Comisión de Wompi</strong></td>
                            <td>-<?= SMONEY.$comision.' '.$moneda ?></td>
                        </tr>
                        <tr>
                            <td><strong>Iva Comision</strong></td>
                            <td><?= SMONEY.$importeNeto.' '.$moneda ?></td>
                        </tr>
                    </tbody>
                  </table>
                  <?php } ?>
                </div>
              </div>
              <div class="row d-print-none mt-2">
                <div class="col-12 custom-text-right"><a class="btn btn-primary" href="javascript:window.print('#sPedido');"><i class="bi bi-printer me-2"></i>Imprimir</a></div>
              </div>
            </section>
            <?php } ?>
          </div>
        </div>
      </div>
    </main>
    <?= footerAdmin($data); ?>