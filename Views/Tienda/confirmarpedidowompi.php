<?php
headerTienda($data);
$id = $_GET['id'];
$objWompi = getTransaccionWompi($id);
$datosWompi = serialize($objWompi);
$status = $objWompi->data->status;
dep($objWompi);
if($status == "APPROVED"){
?>
<br><br><br>
<div class="jumbotron text-center">
  <h1 class="display-4">¡Ya casi!</h1>
  <div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm m-l-25 m-r--38 m-lr-0-xl">
            <div>
              <label for="tipopago">Necesitamos los datos de envío</label>
                <div class="bor8 bg0 m-b-12">
                <select class="form-control" id="departamento" name="departamento" required>
                <option value = "">Selecciona tu departamento</option>
                <option value = "Amazonas">Amazonas</option>
                <option value = "Antioquia">Antioquia</option>
                <option value = "Arauca">Arauca</option>
                <option value = "Atlántico">Atlántico</option>
                <option value = "Bolívar">Bolívar</option>
                <option value = "Boyacá">Boyacá</option>
		            <option value = "Caldas">Caldas</option>
                <option value = "Caquetá">Caquetá</option>
                <option value = "Casanare">Casanare</option>
                <option value = "Cauca">Cauca</option>
                <option value = "Cesar">Cesar</option>
                <option value = "Chocó">Chocó</option>		            
                <option value = "Córdoba">Córdoba</option>
                <option value = "Cundinamarca">Cundinamarca</option>
                <option value = "Guainía">Guainía</option>
		            <option value = "Guaviare">Guaviare</option>
                <option value = "Huila">Huila</option>
                <option value = "La Guajira">La Guajira</option>
                <option value = "Magdalena">Magdalena</option>
		            <option value = "Meta">Meta</option>
                <option value = "Nariño">Nariño</option>
                <option value = "Norte de Santander">Norte de Santander</option>
                <option value = "Putumayo">Putumayo</option>                
                <option value = "Quindío">Quindío</option>  
		            <option value = "Risaralda">Risaralda</option>
                <option value = "San Andrés y Providencia">San Andrés y Providencia</option>
                <option value = "Santander">Santander</option>
                <option value = "Sucre">Sucre</option>
                <option value = "Tolima">Tolima</option>
                <option value = "Valle del Cauca">Valle del Cauca</option>
                <option value = "Vaupés">Vaupés</option>
                <option value = "Vichada">Vichada</option>
              </select>
                </div>
                <div class="bor8 bg0 m-b-12">
                  <input type="text" id="txtCiudad1" class="stext-111 cl8 plh3 size-111 p-lr-15 valid validText" name="postcode" placeholder="Ciudad">
                </div>
                <div class="bor8 bg0 m-b-12">
                  <input type="text" id="txtDireccion1" class="stext-111 cl8 plh3 size-111 p-lr-15 valid validText" name="state" placeholder="Dirección completa de envío" required="">
                </div>
            </div>
            <button class="btn btn-primary" id="confirmacion">Finalizar</button>
          </div>
      </div>
  </div>
  <?php
   // $id = $_GET['id'];
?>
 
</div>
<?php
}else{
?>
<br><br><br>
<div class="jumbotron text-center">
  <h1 class="display-4">Lo sentimos.</h1> <br> <br>
  <h4>Tu pedido no fue aprobado por wompi.</h4> <br> <br>
  <a class="btn btn-primary" href="<?= BASE_URL; ?>carrito/procesarpago">Volver a intentarlo.</a>
<?php
}
?>
</div>

<script>
                                        
                                        document.addEventListener('DOMContentLoaded', function () {
                                          function procesarVenta(){
                                        let base_url = "<?= base_url(); ?>";
                                        let idtransaccion = "<?= $id; ?>";
                                        let dir = document.querySelector("#txtDireccion1").value;
                                        let ciudad = document.querySelector("#txtCiudad1").value;
                                        let departamento = document.querySelector("#departamento").value;
                                        let inttipopago = 5;
                                        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                                        let ajaxUrl = base_url+'Tienda/procesarVentaWompi';
                                        let formData = new FormData();
                                        formData.append('direccion',dir);
                                        formData.append('ciudad',ciudad);
                                        formData.append('departamento',departamento);
                                        formData.append('inttipopago',inttipopago);
                                        formData.append('idtransaccion',idtransaccion);
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
                                        }
                                        document.getElementById('confirmacion').addEventListener('click', procesarVenta);
                                        });
                                        

                                        
                                    </script>

<?php
	footerTienda($data);
	?> 