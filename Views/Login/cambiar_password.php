<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sebastian Ospina">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media();?>/images/favicon.ico">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/style1.css">
 
 
    <title><?= $data['page_tag'];?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1><?= $data['page_title'];?></h1>
      </div>
      <div class="login-box flipped">
      <div id="divLoading">
          <div>
          <img src="<?= media(); ?>/images/tail-spin.svg" alt="Loading">
        </div>
      </div>
        <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
            <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona']; ?>" required="">
            <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required="">
            <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required="">
          <h3 class="login-head"><i class="fas fa-key"></i>Cambiar Contraseña</h3>
          <div class="mb-3">
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva Contraseña" required="">
          </div>
          <div class="mb-3">
            <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar Contraseña" required="">
          </div>
          <div class="mb-3 btn-container d-grid">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESTABLECER</button>
          </div>
        </form>
      </div>
    </section>
    <script>
      const base_url = "<?= base_url(); ?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media();?>/js/jquery-3.7.0.min.js"></script>
    <script src="<?= media();?>/js/bootstrap.min.js"></script>
    <script src="<?= media();?>/js/fontawesome.js"></script>
    <script src="<?= media();?>/js/main.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= media();?>/js/<?= $data['page_functions_js'];?>"></script>
      
    
  </body>
</html>