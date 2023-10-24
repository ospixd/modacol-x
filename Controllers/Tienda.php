<?php
require_once("Models/TCategoria.php");
require_once("Models/Tproducto.php");
require_once("Models/TCliente.php");
require_once("Models/LoginModel.php");

class Tienda extends Controllers{
    use TCategoria, TProducto, TCliente;
    public $login;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->login = new LoginModel();

    }

    public function tienda()
    {

        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = NOMBRE_EMPRESA;
        $data['page_name'] = "tienda";
        //$data['productos'] = $this->getProductosT();
        $pagina = 1;
        $cantProductos = $this->cantProductos();
        $total_registro = $cantProductos['total_registro'];
        $desde = ($pagina-1) * PROPDPORPAGINA;
        $total_paginas = ceil($total_registro / PROPDPORPAGINA);
        $data['productos'] = $this->getProductosPage($desde,PROPDPORPAGINA);
        $data['pagina'] = $pagina;
        $data['total_paginas'] = $total_paginas;
        $data['categorias'] = $this->getCategorias();
        $this->views->getView($this,"tienda",$data);
    }

    public function categoria($params){
        if(empty($params)){
            header("Location:".base_url());
        }else{
            $arrParams = explode(",",$params);
            $idCategoria = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $pagina = 1;
            if(count($arrParams) > 2 AND is_numeric($arrParams[2])){
                $pagina = $arrParams[2];
            }

            $cantProductos = $this->cantProductos($idCategoria);
            $total_registro = $cantProductos['total_registro'];
            $desde = ($pagina - 1) * PROPDPORCATEGORIA;
            $total_paginas = ceil($total_registro / PROPDPORCATEGORIA);
            $infoCategoria = $this->getProductosCategoriaT($idCategoria,$ruta,$desde,PROPDPORCATEGORIA);
            $categoria = strClean($params);
            $data['page_tag'] = NOMBRE_EMPRESA. " - ".$infoCategoria['categoria'];
            $data['page_title'] = $infoCategoria['categoria'];
            $data['page_name'] = "categoria";
            $data['productos'] = $infoCategoria['productos'];
            $data['infoCategoria'] = $infoCategoria;
            $data['pagina'] = $pagina;
            $data['total_paginas'] = $total_paginas;
            $data['categorias'] = $this->getCategorias();
            $this->views->getView($this,"categoria",$data);
        }
    }

    public function producto($params){
        if(empty($params)){
            header("Location:".base_url());
        }else{
            $arrParams = explode(",",$params);
            $idproducto = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoProducto = $this->getProductoT($idproducto,$ruta);
            if(empty($infoProducto)){
                header("Location:".base_url());
            }
            
            $data['page_tag'] = NOMBRE_EMPRESA. " - ".$infoProducto['nombre'];
            $data['page_title'] = $infoProducto['nombre'];
            $data['page_name'] = "producto";
            $data['producto'] = $infoProducto;
            $data['productos'] = $this->getProductosRandom($infoProducto['categoriaid'],8,"r");
            $this->views->getView($this,"producto",$data);
        }
    }

    public function addCarrito()
    {
        if($_POST){
            //unset($_SESSION['arrCarrito']); exit;
            $arrCarrito = array();
            $cantCarrito = 0;
            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $cantidad = $_POST['cant'];
            if(is_numeric($idproducto) and is_numeric($cantidad)){
                $arrInfoProducto = $this->getProductoIDT($idproducto);
                if(!empty($arrInfoProducto)){
                                    
                    $arrProducto = array('idproducto' => $idproducto,
                                        'producto' => $arrInfoProducto['nombre'],
                                        'cantidad' => $cantidad,
                                        'precio' => $arrInfoProducto['precio'],
                                        'imagen' => $arrInfoProducto['images'][0]['url_image']
                                        );

                    if(isset($_SESSION['arrCarrito'])){
                        $on = true;
                        $arrCarrito = $_SESSION['arrCarrito'];
                        for ($pr=0; $pr < count($arrCarrito); $pr++) {
                            if($arrCarrito[$pr]['idproducto'] == $idproducto){
                                $arrCarrito[$pr]['cantidad'] += $cantidad;
                                $on = false;
                            }
                        }
                        if($on){
                            array_push($arrCarrito,$arrProducto);
                        }
                        $_SESSION['arrCarrito'] = $arrCarrito;
                    }else{
                        array_push($arrCarrito, $arrProducto);
                        $_SESSION['arrCarrito'] = $arrCarrito;
                    }
                    foreach ($_SESSION['arrCarrito'] as $pro) {
                        $cantCarrito += $pro['cantidad'];
                    }
                    $htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
                    $arrResponse = array("status" => true,
                                            "msg" => 'Agregado correctamente.',
                                            "cantCarrito" => $cantCarrito,
                                            "htmlCarrito" => $htmlCarrito);
                    

                }else{
                    $arrResponse = array("status" => false, "msg" => "Producto no existente");
                }
            }else{
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos");
            }

            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

            
        }
        die();
    }

    public function delCarrito(){
        if($_POST){
            $arrCarrito = array();
            $cantCarrito = 0;
            $subtotal = 0;
            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $option = $_POST['option'];
            if(is_numeric($idproducto) and ($option == 1 or $option == 2)){
                $arrCarrito = $_SESSION['arrCarrito'];
                for ($pr=0; $pr < count($arrCarrito); $pr++) {
                    if($arrCarrito[$pr]['idproducto'] == $idproducto){
                        unset($arrCarrito[$pr]);
                    }
                }
                sort($arrCarrito);
                $_SESSION['arrCarrito'] = $arrCarrito;
                foreach ($_SESSION['arrCarrito'] as $pro) {
                    $cantCarrito += $pro['cantidad'];
                    $subtotal += $pro['cantidad'] * $pro['precio'];
                }
                $htmlCarrito ="";
                if($option == 1){
                $htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
                }
                $arrResponse = array("status" => true,
                                            "msg" => '!Se agrego al carrito¡',
                                            "cantCarrito" => $cantCarrito,
                                            "htmlCarrito" => $htmlCarrito,
                                            "subTotal" => SMONEY.formatMoney($subtotal),
                                            "total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
                                    );
            }else{
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function updCarrito(){
        if($_POST){
            $arrCarrito = array();
            $totalProducto = 0;
            $subtotal = 0;
            $total = 0;

            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $cantidad = intval($_POST['cantidad']);
            if(is_numeric($idproducto) and $cantidad > 0){
                $arrCarrito = $_SESSION['arrCarrito'];
                for ($p=0; $p < count($arrCarrito); $p++) {
                    if($arrCarrito[$p]['idproducto'] == $idproducto){
                        $arrCarrito[$p]['cantidad'] = $cantidad;
                        $totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
                        break;
                    }
                }
                $_SESSION['arrCarrito'] = $arrCarrito;
                foreach ($_SESSION['arrCarrito'] as $pro) {
                    $subtotal += $pro['cantidad'] * $pro['precio'];
                }
                
                $arrResponse = array("status" => true,
                                        "msg" => '!Producto Actualizado',
                                        "totalProducto" => SMONEY.formatMoney($totalProducto),
                                        "subTotal" => SMONEY.formatMoney($subtotal),
                                        "total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
                                    );

            }else{
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function registro(){
        if($_POST){
            if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']))
            {
                $arrResponse = array('status' => false, 'msg' => 'Datos Incorrectos');
            }else{
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strApellido = ucwords(strClean($_POST['txtApellido']));
                $strTelefono = intval(strClean($_POST['txtTelefono']));
                $strEmail = strtolower(strClean($_POST['txtEmailCliente']));
                $intTipoId = 8;
                $request_user = "";

                $strPassword = passGenerator();
                $strPasswordEncript = hash("SHA256",$strPassword);
                $request_user = $this->insertCliente($strNombre,
                                                    $strApellido,
                                                    $strTelefono,
                                                    $strEmail,
                                                    $strPasswordEncript,
                                                    $intTipoId);
            }
            if($request_user > 0)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    $nombreUsuario = $strNombre.' '.$strApellido;
                    $dataUsuario = array('nombreUsuario' => $nombreUsuario,
                                            'email' => $strEmail,
                                            'password' => $strPassword,
                                            'asunto' => 'Bienvenido a Tecno Juan');
                    $_SESSION['idUser'] = $request_user;
                    $_SESSION['login'] = true;
                    $this->login->sessionLogin($request_user);
                    //sendEmail($dataUsuario,'email_bienvenida');
                
                }else if($request_user == false){
                        $arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');
                    }
                    else{
                        
                        $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                    }

                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            } 

            public function procesarVentaWompi(){
                $idtransaccion = $_POST['idtransaccion'];
                $objWompi = getTransaccionWompi($idtransaccion);
                $datosWompi = serialize($objWompi);
                
                $status = $objWompi->data->status;

                if($status == "APPROVED"){
                    $status = "Aprobado";
                    $metodo = $objWompi->data->payment_method_type;
                    if($metodo == "CARD"){
                        $metodo = "Tarjeta";
                    }else if($metodo == "NEQUI"){
                        $metodo = "Nequi";
                    }else if($metodo == "BANCOLOMBIA_TRANSFER"){
                        $metodo = "Botón Bancolombia";
                    }else if($metodo == "BANCOLOMBIA_QR"){
                        $metodo = "Bancolombia QR";
                    }else if($metodo == "PSE"){
                        $metodo = "PSE";
                    }
                    $idtransaccion = $objWompi->data->id;
                    $referenciacobro = $objWompi->data->reference;
                    $personaid = $_SESSION['idUser'];
                    $tipopagoid = intval($_POST['inttipopago']);
                    $direccionenvio = strClean($_POST['departamento']).', '.strClean($_POST['ciudad']).', '.strClean($_POST['direccion']);
                    $monto = 0;
                    $subtotal = 0;
                    $costo_envio = COSTOENVIO;
                    if(!empty($_SESSION['arrCarrito'])){
                        foreach ($_SESSION['arrCarrito'] as $pro) {
                            $subtotal += $pro['cantidad'] * $pro['precio'];
                        }
                        $monto = $subtotal + COSTOENVIO;
                        $valor = $monto."00";
                        if(is_object($objWompi)){
                            $totalWompi = formatMoney($objWompi->data->amount_in_cents);
                            if($valor == $totalWompi){
                                $status = "Completo";
                            }
                            $request_pedido = $this->insertPedidoWompi( $idtransaccion,
                                                                    $referenciacobro,
                                                                    $datosWompi,
                                                                    $personaid,
                                                                    $costo_envio,
                                                                    $monto,
                                                                    $tipopagoid,
                                                                    $metodo,
                                                                    $direccionenvio,
                                                                    $status);
                            if($request_pedido > 0){
                                foreach ($_SESSION['arrCarrito'] as $producto) {
                                    $productoid = $producto['idproducto'];
                                    $precio = $producto['precio'];
                                    $cantidad = $producto['cantidad'];
                                    $this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
                                }
                                $infoOrden = $this->getPedido($request_pedido);
                                $dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
                                                    'email' => $_SESSION['userData']['email_user'],
                                                    'emailCopia' => EMAIL_PEDIDOS,
                                                    'pedido' => $infoOrden);
                            //sendEmail($dataEmailOrden,"email_notificacion_orden");
                            $refcobro = $infoOrden['orden']['referenciacobro'];
                            $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                            $transaccion = openssl_encrypt($idtransaccion, METHODENCRIPT, KEY);
                            $arrResponse = array('status' => true, 'orden' => $orden, 'refcobro' => $refcobro, 'transaccion' => $transaccion, 'msg' => 'Pedido realizado');

                            $_SESSION['dataorden'] = $arrResponse;
                            unset($_SESSION['arrCarrito']);
                            session_regenerate_id(true);

                            }else{
                                $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido');
                            }
                            
                        }else{
                            $arrResponse = array("status" => false, "msg" => "Hubo un error en la transacción.");
                        }
                    }else{
                        $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido');
                    }
                }else{
                    $arrResponse = array("status" => false, "msg" => 'Pedido no aprobado');
                } 
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();        
            }

            public function procesarVenta(){

                if($_POST){ 
                    
                    $referenciacobro = NULL;
                    $idtransaccionpaypal = NULL;
                    $datospaypal = NULL;
                    $personaid = $_SESSION['idUser'];
                    $monto = 0;
                    $tipopagoid = intval($_POST['inttipopago']);
                    $direccionenvio = strClean($_POST['direccion']).', '.strClean($_POST['ciudad']);
                    $status = "Pendiente";
                    $subtotal = 0;
                    $costo_envio = COSTOENVIO;

                    if(!empty($_SESSION['arrCarrito'])){
                        foreach ($_SESSION['arrCarrito'] as $pro) {
                            $subtotal += $pro['cantidad'] * $pro['precio'];
                        }
                        $monto = $subtotal + COSTOENVIO;
                        //Pago contraentrega
                        if(empty($_POST['datapay'])){
                             
                            //crear pedido
                            $request_pedido = $this->insertPedido( $idtransaccionpaypal,
                                                                    $datospaypal,
                                                                    $personaid,
                                                                    $costo_envio,
                                                                    $monto,
                                                                    $tipopagoid,
                                                                    $direccionenvio,
                                                                    $status);

                            if($request_pedido > 0){
                            //insertamos detalle
                            foreach ($_SESSION['arrCarrito'] as $producto) {
                            $productoid = $producto['idproducto'];
                            $precio = $producto['precio'];
                            $cantidad = $producto['cantidad'];
                            $this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
                            }
                            $infoOrden = $this->getPedido($request_pedido);
                            $dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
                                                    'email' => $_SESSION['userData']['email_user'],
                                                    'emailCopia' => EMAIL_PEDIDOS,
                                                    'pedido' => $infoOrden);
                            //sendEmail($dataEmailOrden,"email_notificacion_orden");
                            $refcobro = $infoOrden['orden']['referenciacobro'];
                            $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                            $transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
                            $arrResponse = array('status' => true, 'orden' => $orden, 'refcobro' => $refcobro, 'transaccion' => $transaccion, 'msg' => 'Pedido realizado');

                            $_SESSION['dataorden'] = $arrResponse;
                            unset($_SESSION['arrCarrito']);
                            session_regenerate_id(true);
                        }
                            //Pago con paypal
                        }else{
                            $jsonPaypal = $_POST['datapay'];
                            $objPaypal = json_decode($jsonPaypal);
                            $status = "Aprobado";

                            if(is_object($objPaypal)){
                                $datospaypal = $jsonPaypal;
                                $idtransaccionpaypal = $objPaypal->purchase_units[0]->payments->captures[0]->id;
                                if($objPaypal->status == "COMPLETED"){
                                    $totalPaypal = formatMoney($objPaypal->purchase_units[0]->amount->value);
                                    if($monto == $totalPaypal){
                                        $status = "Completo";
                                    }
                                    //crear pedido
                                    $request_pedido = $this->insertPedido($idtransaccionpaypal,
                                                                            $datospaypal,
                                                                            $personaid,
                                                                            $costo_envio,
                                                                            $monto,
                                                                            $tipopagoid,
                                                                            $direccionenvio,
                                                                            $status);

                                    if($request_pedido > 0){
                                        //insertamos detalle
                                        foreach ($_SESSION['arrCarrito'] as $producto) {
                                            $productoid = $producto['idproducto'];
                                            $precio = $producto['precio'];
                                            $cantidad = $producto['cantidad'];
                                            $this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);
                                        }
                                        $infoOrden = $this->getPedido($request_pedido);
                                        $dataEmailOrden = array('asunto' => "Se ha creado la orden No.".$request_pedido,
                                                    'email' => $_SESSION['userData']['email_user'],
                                                    'emailCopia' => EMAIL_PEDIDOS,
                                                    'pedido' => $infoOrden);
                                        //sendEmail($dataEmailOrden,"email_notificacion_orden");
                                        $refcobro = $infoOrden['orden']['referenciacobro'];
                                        $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                                        $transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
                                        $arrResponse = array('status' => true, 'orden' => $orden, 'refcobro' => $refcobro, 'transaccion' => $transaccion, 'msg' => 'Pedido realizado');

                                        $_SESSION['dataorden'] = $arrResponse;
                                        unset($_SESSION['arrCarrito']);
                                        session_regenerate_id(true);
                                    }else{
                                        $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido');
                                    }
                                }else{
                                    $arrResponse = array("status" => false, "msg" => 'No es posible completar el pago');
                                }
                            }else{
                                $arrResponse = array("status" => false, "msg" => "Hubo un error en la transacción.");
                            }
                        }

                    }else{
                        $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido');
                    }

                }else{
                    $arrResponse = array("status" => false, "msg" => "No es posible procesar el pedido.");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
                

            }
            public function confirmarpedido(){
                if(empty($_SESSION['dataorden'])){
                    header("Location: ".base_url());
                }else{
                    $dataorden = $_SESSION['dataorden'];
                    $idpedido = openssl_decrypt($dataorden['orden'], METHODENCRIPT, KEY);
                    $transaccion = openssl_decrypt($dataorden['transaccion'],METHODENCRIPT, KEY);
                    $data['page_tag'] = "Confirmar Pedido";
                    $data['page_title'] = "Confirmar Pedido";
                    $data['page_name'] = "confirmarpedido";
                    $data['orden'] = $dataorden['refcobro'];
                    $data['transaccion'] = $transaccion;
                    $this->views->getView($this,"confirmarpedido",$data);
                }
                unset($_SESSION['dataorden']);
            }
            public function confirmarpedidowompi(){
                // if(empty($_SESSION['dataorden'])){
                //     header("Location: ".base_url());
                // }else{
                    //$dataorden = $_SESSION['dataorden'];
                    //$idpedido = openssl_decrypt($dataorden['orden'], METHODENCRIPT, KEY);
                    //$transaccion = openssl_decrypt($dataorden['transaccion'],METHODENCRIPT, KEY);
                    $data['page_tag'] = "Confirmar Pedido";
                    $data['page_title'] = "Confirmar Pedido";
                    $data['page_name'] = "confirmarpedido";
                    //$data['orden'] = $dataorden['refcobro'];
                    //$data['transaccion'] = $transaccion;
                    $this->views->getView($this,"confirmarpedidowompi",$data);
                }
                //unset($_SESSION['dataorden']);

                public function page($pagina = NULL){
                    $pagina = is_numeric($pagina) ? $pagina : 1;
                    $cantProductos = $this->cantProductos();
                    $total_registro = $cantProductos['total_registro'];
                    $desde = ($pagina - 1) * PROPDPORPAGINA;
                    $total_paginas = ceil($total_registro / PROPDPORPAGINA);
                    $data['productos'] = $this->getProductosPage($desde,PROPDPORPAGINA);
                    $data['page_tag'] = NOMBRE_EMPRESA;
                    $data['page_title'] = NOMBRE_EMPRESA;
                    $data['page_name'] = "tienda";
                    $data['pagina'] = $pagina;
                    $data['total_paginas'] = $total_paginas;
                    $data['categorias'] = $this->getCategorias();
                    $this->views->getView($this,"tienda",$data);
                }

                public function search(){
                    if(empty($_REQUEST['s'])){
                        header("location: ".base_url());
                    }else{
                        $busqueda = strClean($_REQUEST['s']);
                    }

                    $pagina = empty($_REQUEST['p']) ? 1 : intval($_REQUEST['p']);
                    $cantProductos = $this->cantProdSearch($busqueda);
                    $total_registro = $cantProductos['total_registro'];
                    $desde = ($pagina - 1) * PRODBUSCAR;
                    $total_paginas = ceil($total_registro / PRODBUSCAR);
                    $data['productos'] = $this->getProductosSearch($busqueda,$desde,PRODBUSCAR);
                    $data['page_tag'] = NOMBRE_EMPRESA;
                    $data['page_title'] ="Resultado de: ".$busqueda;
                    $data['page_name'] = "tienda";
                    $data['pagina'] = $pagina;
                    $data['total_paginas'] = $total_paginas;
                    $data['busqueda'] = $busqueda;
                    $data['categorias'] = $this->getCategorias();
                    $this->views->getView($this,"search",$data);
                    
                }

                public function suscripcion(){
                    if($_POST){
                        $nombre = ucwords(strtolower(strClean($_POST['nombreSub'])));
                        $email = strtolower(strClean($_POST['emailSub']));
                        $suscripcion = $this->setSuscripcion($nombre,$email);
                        if($suscripcion > 0){
                            $arrResponse = array('status' => true, 'msg' => "Gracias por tu suscripcion.");
                            //Enviar correo
                            $dataUsuario = array('asunto' => "Nueva suscripción",
                                                    'email' => EMAIL_SUSCRIPCION,
                                                    'nombreSuscriptor' => $nombre,
                                                    'emailSuscriptor' => $email);
                            sendEmail($dataUsuario,"email_suscripcion");
                        }else{
                            $arrResponse = array('status' => false, 'msg' => "El email ya fue registrado.");
                        }
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    }
                    

                    die();
                }




            }
        

            
        
                

    


    

?>