<?php
require_once("Libraries/Core/Mysql.php");
trait TCliente{

    private $con;
    private $intIdUsuario;
    private $strNombre;
    private $strApellido;
    private $intTelefono;
    private $strEmail;
    private $strPassword;
    private $strToken;
    private $intTipoId;
    private $intIdTransaccion;
    private $referenciaCobro;


    public function insertCliente(string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid){
        $this->con = new Mysql();
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intTipoId = $tipoid;
        
        
        $return = 0;

        $sql = "SELECT * FROM persona WHERE
        email_user = '{$this->strEmail}' ";

        $request = $this->con->select_all($sql);

        if(empty($request))
        {
            $query_insert = "INSERT INTO persona(nombres,apellidos,telefono,email_user,password,rolid) VALUES(?,?,?,?,?,?)";

            $arrData = array(
                            $this->strNombre,
                            $this->strApellido,
                            $this->intTelefono,
                            $this->strEmail,
                            $this->strPassword,
                            $this->intTipoId
                            );
            $request_insert = $this->con->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = false;
        }
        return $return;
    }

    public function insertPedidoWompi(string $idtransaccion, string $referenciacobro, string $datoswompi, int $personaid, float $costo_envio, string $monto, int $tipopagoid, string $metodo, string $direccionenvio, string $status){
        $this->con = new Mysql();

        $query_insert = "INSERT INTO pedido(referenciacobro,idtransaccionpaypal,datospaypal,personaid,costo_envio,monto,tipopagoid,metodopago,direccion_envio,status)VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrData = array($referenciacobro,
                        $idtransaccion, 
                        $datoswompi,
                        $personaid,
                        $costo_envio,
                        $monto,
                        $tipopagoid,
                        $metodo,
                        $direccionenvio,
                        $status);
        $request_insert = $this->con->insert($query_insert,$arrData);
        $return = $request_insert;      
         
        return $return;
    }
 
    public function insertPedido(string $idtransaccionpaypal = NULL, string $datospaypal = NULL, int $personaid, float $costo_envio, string $monto, int $tipopagoid, string $direccionenvio, string $status){
        $this->con = new Mysql();

             do{
                $referenciacobro = codigoUnico();
                $consulta_referencia = "SELECT * FROM pedido WHERE referenciacobro = '{$referenciacobro}'";
                $request_consul = $this->con->select_all($consulta_referencia);

            }while ($request_consul == "");

            $query_insert = "INSERT INTO pedido(referenciacobro,idtransaccionpaypal,datospaypal,personaid,costo_envio,monto,tipopagoid,direccion_envio,status)VALUES(?,?,?,?,?,?,?,?,?)";
            $arrData = array($referenciacobro,
                        $idtransaccionpaypal,
                        $datospaypal,
                        $personaid,
                        $costo_envio,
                        $monto,
                        $tipopagoid,
                        $direccionenvio,
                        $status);
            $request_insert = $this->con->insert($query_insert,$arrData);
            $return = $request_insert;      
         
        return $return;
        
    }

    public function insertDetalle(int $idpedido, int $productoid, float $precio, int $cantidad ){
        $this->con = new Mysql();
        $query_insert = "INSERT INTO detalle_pedido(pedidoid,productoid,precio,cantidad)VALUES(?,?,?,?)";
        $arrData = array($idpedido,
                        $productoid,
                        $precio,
                        $cantidad);
        $request_insert = $this->con->insert($query_insert,$arrData);
        $return = $request_insert;
        return $return;
    }

    public function insertDetalleTemp(array $pedido){
        $this->intIdUsuario = $pedido['idcliente'];
        $this->intIdTransaccion = $pedido['idtransaccion'];
        $productos = $pedido['productos'];

        $this->con = new Mysql();
        $sql = "SELECT * FROM detalle_temp WHERE transaccionid = '{$this->intIdTransaccion}' AND personaid = $this->intIdUsuario";
        $request = $this->con->select_all($sql);

        if(empty($request)){
            foreach ($productos as $producto) {
                $query_insert = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) VALUES(?,?,?,?,?)";
                $arrData = array(       $this->intIdUsuario,
                                        $producto['idproducto'],
                                        $producto['precio'],
                                        $producto['cantidad'],
                                        $this->intIdTransaccion
                                );
                $request_insert = $this->con->insert($query_insert,$arrData);
            }
        }else{
            $sqlDel = "DELETE FROM detalle_temp WHERE transaccionid = '{$this->intIdTransaccion}' AND personaid = $this->intIdUsuario";
            $request = $this->con->delete($sqlDel);

            foreach ($productos as $producto) {
                $query_insert = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) VALUES(?,?,?,?,?)";
                $arrData = array(       $this->intIdUsuario,
                                        $producto['idproducto'],
                                        $producto['precio'],
                                        $producto['cantidad'],
                                        $this->intIdTransaccion
                                );
                $request_insert = $this->con->insert($query_insert,$arrData);
            }
        }
    }
    
    public function getPedido(int $idpedido){
        $this->con = new Mysql();
        $request = array();
        $sql = "SELECT p.idpedido,
                        p.referenciacobro,
                        p.idtransaccionpaypal,
                        p.personaid,
                        p.fecha,
                        p.costo_envio,
                        p.monto,
                        p.tipopagoid,
                        t.tipopago,
                        p.direccion_envio,
                        p.status
                    FROM pedido as p
                    INNER JOIN tipopago t
                    ON p.tipopagoid = t.idtipopago
                    WHERE p.idpedido = $idpedido";

        $reques_pedido = $this->con->select($sql);
        if(count($reques_pedido) > 0){
            $sql_detalle = "SELECT p.idproducto,
                                    p.nombre as producto,
                                    d.precio,
                                    d.cantidad
                                FROM detalle_pedido d
                                INNER JOIN producto p
                                ON d.productoid = p.idproducto
                                WHERE d.pedidoid = $idpedido";
        $requestProductos = $this->con->select_all($sql_detalle);
        $request = array('orden' => $reques_pedido,
                        'detalle' => $requestProductos);
        }
        return $request;
    }

    public function setSuscripcion(string $nombre, string $email){
        $this->con = new Mysql();
        $sql = "SELECT * FROM suscripciones WHERE email = '{$email}'";
        $request = $this->con->select_all($sql);
        if(empty($request)){
            $query_insert = "INSERT INTO suscripciones (nombre,email)
                                VALUES(?,?)";
            $arrData = array($nombre,$email);

            $request_insert = $this->con->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = false;
        }
        return $return;

    }
}

?>