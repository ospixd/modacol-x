<?php
require_once("Models/TCategoria.php");
require_once("Models/Tproducto.php");
require_once("Models/TTipoPago.php");
require_once("Models/TCliente.php");

class Carrito extends Controllers{
    use TCategoria, TProducto, TTipoPago, TCliente;
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function carrito()
    {

        $data['page_tag'] = NOMBRE_EMPRESA.' - Carrito';
        $data['page_title'] = 'Carrito de compras';
        $data['page_name'] = "carrito";
       $this->views->getView($this,"carrito",$data);
    }

    public function procesarpago()
    {   
        if(empty($_SESSION['arrCarrito'])){
            header("Location: ".base_url());
            die();
        }
        // if(isset($_SESSION['login'])){
        //     $this->setDetalleTemp();
        // }
        // $referencia = 2;
        // $monto = 40000;
        // $moneda = CURRENCYWOMPI;
        // $secreto = SECRETOINTEGRIDAD;
        // $cadena = $referencia.$monto.$moneda.$secreto;
        
       
        $data['page_tag'] = NOMBRE_EMPRESA.' - Procesar pago';
        $data['page_title'] = 'Procesar pago';
        $data['page_name'] = "procesarpago";
        //$data['cadena'] = hash("sha256", $cadena);
        $data['tiposPago'] = $this->getTiposPagoT();
       $this->views->getView($this,"procesarpago",$data);
    }

    // public function setDetalleTemp(){
    //     $sid = session_id();
    //     $arrPedido = array('idcliente' => $_SESSION['idUser'],
    //                         'idtransaccion' => $sid,
    //                         'productos' => $_SESSION['arrCarrito']);

    //     $this->insertDetalleTemp($arrPedido);
    // }

    


    
}
?>