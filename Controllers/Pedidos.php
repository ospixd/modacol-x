<?php
require_once("Models/TTipoPago.php");
class Pedidos extends Controllers{
    use TTipoPago;
    public function __construct()
    {
        
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'login');
        }
        getPermisos(MPEDIDOS);

    }

    public function Pedidos()
    {
        
        $data['page_tag'] = "Pedidos";
        $data['page_title'] = "Pedidos <small>Tienda Virtual</small>";
        $data['page_name'] = "pedidos";
        $data['page_functions_js'] = "functions_pedidos.js";
        $this->views->getView($this,"pedidos",$data);
    }

    public function getPedidos(){
        if($_SESSION['permisosMod']['r']){
            $idpersona = "";
            
            if($_SESSION['userData']['idrol'] == RCLIENTES ){
            $idpersona = $_SESSION['userData']['idpersona'];
        }
            $arrData = $this->model->selectPedidos($idpersona); 
            //dep($arrData);
            
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';
                
                $arrData[$i]['transaccion'] = $arrData[$i]['referenciacobro'];
                if($arrData[$i]['idtransaccionpaypal'] != ""){
                    $arrData[$i]['transaccion'] = $arrData[$i]['idtransaccionpaypal'];
                }

                $arrData[$i]['monto'] = SMONEY.formatMoney($arrData[$i]['monto']);
        
                if($_SESSION['permisosMod']['r']){
                    $btnView .= ' <a title="Ver detalle" href="'.base_url().'pedidos/orden/'.$arrData[$i]['idpedido'] .'" target="_blanck" class="btn btn-info btn-sm"><i class="far fa-eye"></i></a> 
                    <a title="Generar PDF" href="'.base_url().'factura/generarFactura/'.$arrData[$i]['idpedido'] .'" target="_blanck" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a> ';

                    if($arrData[$i]['idtipopago'] == 5){
                        $btnView .= '<a title="Ver transaccion" href="'.base_url().'pedidos/transaccion/'.$arrData[$i]['idtransaccionpaypal'] .'" target="_balnck" class="btn btn-info btn-sm"><i class="fa fa-paypal" aria-hidden="true"></i></a>';
                    }else{
                        $btnView .= '<button class="btn btn-secondary btn-sm" diabled=""><i class="fa fa-paypal" aria-hidden="true"></i></button>';
                    }
                }
                if($_SESSION['permisosMod']['u']){
                    $btnEdit = '<button class="btn btn-primary btn-sm " onclick="fntEditInfo(this,'.$arrData[$i]['idpedido'].')" title="Editar Pedido"><i class="fas fa-pencil-alt"></i></button>';
                }
        
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
            die();
    }

    public function orden ($idpedido){
        if(!is_numeric($idpedido)){
            header("Location:".base_url().'pedidos');
        }
        $idpersona = "";
        if ($_SESSION['userData']['idrol'] == RCLIENTES ){
            $idpersona = $_SESSION['userData']['idpersona'];
        }

        $data['page_tag'] = "Pedido - Tienda Virtual";
        $data['page_title'] = "Pedido <small>Tienda Virtual</small>";
        $data['page_name'] = "pedido";
        $data['arrPedido'] = $this->model->selectPedido($idpedido,$idpersona);
        $this->views->getView($this,"orden",$data);
    }

    public function transaccion ($transaccion){
    
        $idpersona = "";
        if ($_SESSION['userData']['idrol'] == RCLIENTES ){
            $idpersona = $_SESSION['userData']['idpersona'];
        }

        $requestTransaccion = $this->model->selectTransWompi($transaccion,$idpersona);
        $requestDireccion = $this->model->selectDireccion($transaccion,$idpersona);
        
        $data['page_tag'] = "Detalle transacción - Tienda Virtual";
        $data['page_title'] = "Detalle transacción";
        $data['page_name'] = "detalle_transaccion";
        $data['direccion'] = $requestDireccion;
        $data['objTransaccion'] = $requestTransaccion;
        $data['page_functions_js'] = "functions_pedidos.js";
        $this->views->getView($this,"transaccion",$data);
    }

    public function getTransaccion(string $transaccion){
        if($_SESSION['permisosMod']['r'] and $_SESSION['userData']['idrol'] != RCLIENTES){
            if($transaccion == ""){
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }else{
                $transaccion = strClean($transaccion);
                $requestTransaccion = $this->model->selectTransWompi($transaccion); 
                if(empty($requestTransaccion)){
                    $arrResponse = array("status" => false, "msg" => "Datos no disponibles.");
                }else{
                    $htmlModal = getFile("Template/Modals/modalReembolso",$requestTransaccion);
                    $arrResponse = array("status" => true, "html" => $htmlModal);
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

        }
        die();
    }

    public function setReembolso(){
        if($_POST){
            if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES){
                $transaccion = strClean($_POST['idtransaccion']);
                $observacion = strClean($_POST['observacion']);

                $requestTransaccion = $this->model->reembolsoPaypal($transaccion,$observacion); 
                if($requestTransaccion){
                    $arrResponse = array("status" => true, "msg" => "El reembolso se ha procesado con éxito.");
                }else{
                    $arrResponse = array("status" => false, "msg" => "No fue posible procesar el reembolso");
                }

            }else{
                $arrResponse = array("status" => false, "msg" => "No es posible realizar el proceso, consulte al administrador");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPedido(string $pedido){
        if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES){
            if($pedido == ""){
                $arrResponse = array("status" => false, "msg" => "Datos Incorrectos");
            }else{
                $requestPedido = $this->model->selectPedido($pedido,"");
                if(empty($requestPedido)){
                    $arrResponse = array("status" => false, "msg" => "Datos no disponibles");
                }else{
                    $requestPedido['tipospago'] = $this->getTiposPagoT();
                    $htmlModal = getFile("Template/Modals/modalPedido",$requestPedido);
                    $arrResponse = array("status" => true, "html" => $htmlModal);
                }
                
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();

    }

    public function setPedido(){
        if($_POST){
            if($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrol'] != RCLIENTES){

                $idpedido = !empty($_POST['idpedido']) ? intval($_POST['idpedido']) : "";
                $estado = !empty($_POST['listEstado']) ? strClean($_POST['listEstado']) : "";
                $idtipopago = !empty($_POST['listTipopago']) ? intval($_POST['listTipopago']) : "";
                //$transaccion = !empty($_POST['txtTransaccion']) ? strClean($_POST['txtTransaccion']) : "";

                if($idpedido == ""){
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                }else{
                    if($idtipopago == ""){
                        if($estado == ""){
                            $arrResponse = array("status" => false, "msg" => "Datos invalidos");
                        }else{
                            $transaccion = "";
                            $requestPedido = $this->model->updatePedido($idpedido,"","",$estado);
                            if($requestPedido){
                                $arrResponse = array("status" => true, "transaccion" =>"", "msg" => "Datos actualizados correctamente.");
                            }else{
                                $arrResponse = array("status" => false, "msg" => "No fue posible almacenar la información.");
                            }
                        }
                    }else{
                        if($idtipopago == "" or $estado == ""){
                            $arrResponse = array("status" => false, "msg" => "Datos no validos.");
                        }else{
                            $transaccion = 1;
                            $requestPedido = $this->model->updatePedido($idpedido,$transaccion,$idtipopago,$estado);
                            if($requestPedido){
                                $arrResponse = array("status" => true, "transaccion" => $transaccion, "msg" => "Datos actualizados correctamente");
                            }else{
                                $arrResponse = array("status" => false, "msg" => "No es posible actualizar la información.");
                            }
                        }
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
        }
        die(); 
    }

}



?>