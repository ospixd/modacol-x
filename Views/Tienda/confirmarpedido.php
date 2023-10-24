<?php
headerTienda($data);
?>
<br><br><br>
<div class="jumbotron text-center">
  <h1 class="display-4">¡Gracias por tu compra!</h1>
  <p class="lead">Tu pedido fue procesado con éxito.</p>
  <p>No. Orden: <strong> <?= $data['orden'];?></strong></p>
    <?php
        if(!empty($data['transaccion'])){
    ?>
    <p>No. Transacción: <strong> <?= $data['transaccion']; ?></strong></p>
    <?php
        }
    ?>

  <hr class="my-4">
  <p>Uno de nuestros asesores te contactara pronto para coordinar la entrega.</p>
  <p>Puedes visualizar el estado de tu pedido en la sección pedidos de tu usuario.</p>
  <br>
  <a class="btn btn-primary btn-lg" href="<?= base_url();?>" role="button">Continuar</a>
</div>


<?php
	footerTienda($data);
	?> 