<?php
require_once 'Libraries/dompdf/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;
class Factura extends Controllers{
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

    public function generarFactura($idpedido)
    {
        if($_SESSION['permisosMod']['r']){
            if(is_numeric($idpedido)){
                $idpersona = "";
                if($_SESSION['permisosMod']['r'] and $_SESSION['userData']['idrol'] == RCLIENTES){
                    $idpersona = $_SESSION['userData']['idpersona'];
                }
                $data = $this->model->selectPedido($idpedido,$idpersona);
                if(empty($data)){
                    echo "Datos no encontrados";
                }else{
                $idpedido = $data['orden']['referenciacobro'];
                ob_end_clean();
                $html = getFile("Template/Modals/comprobantePDF",$data);
                $options = new Options();
                $options->set('isRemoteEnabled', TRUE);
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->render();
                $dompdf->stream("factura-".$idpedido.".pdf", array("Attachment" => false));
                }
                
                
            }else{
                echo "Dato no válido";
            } 
        }else{
            header('Location: '.base_url().'login');
            die();
        }
        
        
       
    }

    


    
}
?>