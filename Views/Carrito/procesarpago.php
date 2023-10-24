<?php
headerTienda($data);

$subtotal = 0;
$total = 0;
foreach($_SESSION['arrCarrito'] as $producto) {
    $subtotal += $producto['precio'] * $producto['cantidad'];
    }
    $total = $subtotal + COSTOENVIO;
?>

<script src="https://www.paypal.com/sdk/js?client-id=<?= IDCLIENTE ?>&currency=<?= CURRENCY ?>"></script>
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?= $total ?>
                    },
                    description: "Compra en <?= NOMBRE_EMPRESA ?> por <?= SMONEY.$total ?>",
                }]
            });
        },
        
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                let base_url = "<?= base_url(); ?>";
                let dir = document.querySelector("#txtDireccion").value;
                let ciudad = document.querySelector("#txtCiudad").value;
                let inttipopago = 1;
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+'Tienda/procesarVenta';
                let formData = new FormData();
                formData.append('direccion',dir);
                formData.append('ciudad',ciudad);
                formData.append('inttipopago',inttipopago);
                formData.append('datapay',JSON.stringify(details));
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState != 4) return;
                    if(request.status == 200){
                        let objData = JSON.parse(request.responseText);
                        if(objData.status){
                            window.location = base_url+"Tienda/confirmarpedido/";
                        }else{
                            Swal.fire("", objData.msg, "error");
                        }
                    }
                }
            });
        } 
    }).render('#paypal-button-container');
</script>


<script type="text/javascript" src="https://checkout.wompi.co/widget.js"></script>

<!-- Modal -->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Términos y condiciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias tempora quibusdam impedit, dolores, delectus magni vel placeat velit, exercitationem cumque sequi? Pariatur possimus maxime nesciunt deleniti unde dignissimos, rem assumenda!</p>
        <br>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque, sit rem, aut culpa ex veritatis unde maiores rerum ut qui placeat voluptates at tenetur sint quos est magnam eaque voluptatum!</p>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<br><br><br>
<hr>
<!-- breadcrumb -->
<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?= base_url(); ?>" class="stext-109 cl8 hov-cl1 trans-04">
				Inicio
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				<?= $data['page_title']; ?>
			</span>
		</div>
	</div>
	<br>
		<div class="containers1">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm m-l-25 m-r--38 m-lr-0-xl">
						<div>
                            <?php
                            if(isset($_SESSION['login'])){

                            ?>
							<div style="flex: 1; padding: 20px; border-right: 1px solid #ccc;">
                                <div class="left-content" id="leftContent">
                                    <h3>Por favor confirmar para continuar al pago.</h3><br>
                                    <p>Estamos a punto de finalizar tu compra en nuestra tienda virtual, ¡gracias por elegir nuestros productos!.</p><br>
                                    <p>Por favor confirmar nuestros terminos y condiciones para continuar al método de pago.</p><br>
                                    <p><strong>Recuerda:</strong> Tu satisfacción es nuestra prioridad, y estamos aquí para ayudarte en cada paso del proceso de compra. Gracias por confiar en nosotros, ¡esperamos que disfrutes de tus nuevos productos!</p><br>
                
                                     <label class="switch">
                                        <input id="checkbox" name="checkbox" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                        <a href="#" data-toggle="modal" data-target="#modalTerminos">Términos y Condiciones</a>
                                     
                                    
                                    
                                    
                                </div>
                                <!-- <div class="bor8 bg0 m-b-12">
                                <input type="text" id="txtCiudad" class="stext-111 cl8 plh3 size-111 p-lr-15 valid validText" name="postcode" placeholder="Ciudad"> -->
                                </div>
                            </div>
                            <?php }else{ ?>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">Iniciar Sesión</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="profile" aria-selected="false">Crear Cuenta</a>
                                </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
                                <br>
                                <form id="formLogin">
                                    <div class="form-group">
                                        <label for="txtEmail">Correo Electronico</label>
                                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Ingresa el correo">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtPassword">Contraseña</label>
                                        <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Ingresa la clave">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                                </form>
                                                                    
                                
                                </div>
                                <div class="tab-pane fade" id="registro" role="tabpanel" aria-labelledby="profile-tab">
                                    <br>
                                        <form id="formRegister">
                                            <div class="form-group">
                                                <div clas="col col-md-6 form-group">
                                                    <label for="txtNombre">Nombres</label>
                                                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                                                </div>
                                                <div clas="col col-md-6 form-group">
                                                    <label for="txtApellido">Apellidos</label>
                                                    <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <div clas="col col-md-6 form-group">
                                                    <label for="txtTelefono">Teléfono</label>
                                                    <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                                                </div>
                                                <div clas="col col-md-6 form-group">
                                                    <label for="txtEmailCliente">Email</label>
                                                    <input type="email" class="form-control valid validEmail" id="txtEmailCliente" name="txtEmailCliente" required="">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Registrar</button>
                                        </form>
                                </div>
                                </div>
                                <?php } ?>
						</div>

					</div>
				</div> 

				<div id="resumenPago" class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50 notblock">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Resumen
						</h4>
                         <div class="right-content">           
						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span id="subTotalCompra" class="mtext-110 cl2">
                                <?= SMONEY.formatMoney($subtotal)?>
								</span>
							</div>
                            <div class="size-208">
								<span class="stext-110 cl2">
									Envío:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2">
                                <?= SMONEY.formatMoney(COSTOENVIO)?>
								</span>
							</div>
						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span id="totalCompra" class="mtext-110 cl2">
                                <?= SMONEY.formatMoney($total)?>
								</span>
							</div>
						</div>
                        </div>
                        <hr>
                        <?php
                            if(isset($_SESSION['login'])){

                            ?>

                        <div id="divMetodoPago" class="notblock">
                            <!-- <div id="divCondiciones">
                                <input type="checkbox" id="condiciones">
                                <label for="condiciones">Aceptar</label>
                                <a href="#" data-toggle="modal" data-target="#modalTerminos">Términos y Condiciones</a>
                            </div> -->
                                
                        <div id="optMetodoPago">
                            <hr>
                        <h4 class="mtext-109 cl2 p-b-30">
                            Método de pago
                        </h4>
                        <div class="divmetodpago">
                            <!-- <div>
                                <label for="paypal">
                                    <input type="radio" id="paypal" class="methodpago" name="payment-method" value="Paypal">
                                    <img src="media()?>/images/img-paypal.jpg" alt="Icono de Paypal" class="ml-space-sm" width="74" height="20">
                                    </label>
                            </div> -->
                            <div>
                                <label for="wompi">
                                    <input type="radio" id="wompi" class="methodpago" name="payment-method" checked="" value="wompi" >
                                    <img src="<?=media()?>/tienda/images/icons/visa.png" class="ml-space-sm" width="50" height="30"><img src="<?=media()?>/tienda/images/icons/tarjeta.png" class="ml-space-sm" width="50" height="30">
                                    </label>
                            </div>
                             <!-- <div>
                                <label for="contraentrega">
                                    <input type="radio" id="contraentrega" class="methodpago" name="payment-method" value="CT">
                                    <span>Contra Entrega</span>
                                </label>
                            </div> -->
                            <div id="divtipopago" class="notblock">
                                <label for="listtipopago">Tipo de pago</label>
                                <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <select name="time" id="listtipopago" class="js-select2">
                                        <?php
                                            if(count($data['tiposPago']) > 0){
                                                foreach($data['tiposPago'] as $tipopago) {
                                                    if($tipopago['idtipopago'] !=5 and $tipopago['idtipopago'] !=1 ){

                                                
                                        ?>
                                            <option value="<?= $tipopago['idtipopago'] ?>"><?= $tipopago['tipopago'] ?></option>

                                        <?php
                                                } 
                                            } 
                                        }
                                        ?>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                    
                                </div>
                                <br>
                                <button type="submit" id="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Procesar Pedido
						        </button>
                            </div>
                            <div id="divpaypal" class="notblock">
                            <div>
                                <p>Para completar la transacción, te enviaremos a los servidores seguros de Paypal.</p>
                            </div>
                            <br>
                            <hr>
                            <div id="paypal-button-container"></div>
                            
                            </div>

                            <div id="divwompi">
                                <div>
                                    <p>Para completar la transacción, te enviaremos a los servidores seguros de Wompi.</p>
                                </div>
                                <br>
                                <hr>
                                <div id="wompii">
                                    <?php
                                    $totalwompi = $total."00";    
                                    $referencia = codigoUnico();
                                    $integrity= getSecretWompi($referencia,$totalwompi);
                                    $nombres = $_SESSION['userData']['nombres'].' '.$_SESSION['userData']['apellidos']
                                    

                                    ?>
                                    <form action="https://checkout.wompi.co/p/" method="GET">
  <!-- OBLIGATORIOS -->
  <input type="hidden" name="public-key" value="<?= IDCLIENTEWOMPI ?>" />
  <input type="hidden" name="currency" value="COP" />
  <input type="hidden" name="amount-in-cents" value="<?= $totalwompi; ?>" />
  <input type="hidden" name="reference" value="<?= $referencia; ?>" />
  <input type="hidden" name="signature:integrity" value="<?= $integrity; ?>"/>
  <!-- OPCIONALES -->
  <input type="hidden" name="redirect-url" value="<?= BASE_URL; ?>Tienda/confirmarpedidowompi/" />
  <input type="hidden" name="customer-data:email" value="<?= $_SESSION['userData']['email_user'] ?>" />
  <input type="hidden" name="customer-data:full-name" value="<?= $nombres; ?>" />
  <input type="hidden" name="customer-data:phone-number" value="<?= $_SESSION['userData']['telefono'] ?>" />
  <input type="hidden" name="customer-data:legal-id" value="<?= $_SESSION['userData']['identificacion'] ?>" />
  <input type="hidden" name="customer-data:legal-id-type" value="CC" />
  <button class="waybox-button" type="submit">Pagar con Wompi</button>
</form>
                                <!-- <form id="wompi-widget">
                                    <script
                                        src="https://checkout.wompi.co/widget.js"
                                        data-render="button"
                                        data-public-key="<?= IDCLIENTEWOMPI ?>"
                                        data-currency="COP"
                                        data-amount-in-cents="<?= $totalwompi; ?>"
                                        data-reference="<?= $referencia; ?>"
                                        data-signature:integrity="<?= $integrity; ?>"
                                        >
                                        
                                    </script>  -->
                                    
                                
                                        
                                        
                                    
                                </div>
                            </div>
                            
                        </div>
                        </div>
                        </div>       
						
                        <?php } ?>
					</div>
				</div>
			</div>
		</div>
    
    <?php
    
footerTienda($data);
?>

<script>
    if(document.querySelector("#checkbox")){
        let check = document.querySelector("#checkbox");

        check.addEventListener('click', function(){
            let check = this.checked;
            if(check){
                document.querySelector("#resumenPago").classList.remove("notblock");
                document.querySelector("#divMetodoPago").classList.remove("notblock");
            }else{
                document.querySelector("#resumenPago").classList.add("notblock");
            }
        })
    }
</script>

 