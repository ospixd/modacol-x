<?php

class Productos extends Controllers{
    public function __construct()
    {
        
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'login');
        }
        
        
        getPermisos(4);

    }

    public function Productos()
    {
        
        $data['page_tag'] = "Productos";
        $data['page_title'] = "PRODUCTOS <small>Tienda Virtual</small>";
        $data['page_name'] = "productos";
        $data['page_functions_js'] = "functions_productos.js";
        $this->views->getView($this,"productos",$data);
    }

    
    public function getProductos()
    {
    if($_SESSION['permisosMod']['r']){

    $arrData = $this->model->selectProductos();
    
    for ($i = 0; $i < count($arrData); $i++) {
        $btnView = '';
        $btnEdit = '';
        $btnDelete = '';

        if($arrData[$i]['status'] == 1)
        {
            $arrData[$i]['status'] = '<span class="me-1 badge bg-success">Activo</span>';
        }else{
            $arrData[$i]['status'] = '<span class="me-1 badge bg-danger">Inactivo</span>';
        }

        $arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);

        if($_SESSION['permisosMod']['r']){
            $btnView = '<button class="btn btn-info btn-sm " onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver Producto"><i class="far fa-eye"></i></button>';
        }
        if($_SESSION['permisosMod']['u']){
            $btnEdit = '<button class="btn btn-primary btn-sm " onclick="fntEditInfo(this,'.$arrData[$i]['idproducto'].')" title="Editar Producto"><i class="fas fa-pencil-alt"></i></button>';
        }
      
        if($_SESSION['permisosMod']['d']){      
            $btnDelete = '<button class="btn btn-danger btn-sm " onclick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar Producto"><i class="far fa-trash-alt"></i></button>';
        }

        $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
    }
    echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
}
    die();

    

        
    }

    public function setProducto()
    {

        if($_POST){
            

            if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['txtPrecio']) || empty($_POST['listCategoria']) || empty($_POST['listStatus']) )
            {
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos');
            }else{
                if($_SESSION['permisosMod']['w']){
                    
                    $idProducto = intval($_POST['idProducto']);
                    $strNombre = strClean($_POST['txtNombre']);
                    $strDescripcion = strClean($_POST['txtDescripcion']);
                    $strCodigo = strClean($_POST['txtCodigo']);
                    $intCategoriaId = intval($_POST['listCategoria']);
                    $strPrecio = strClean($_POST['txtPrecio']);
                    $intStock = intval($_POST['txtStock']);
                    $intStatus = intval($_POST['listStatus']);
                    $request_producto = "";
                    $ruta = strtolower(clear_cadena($strNombre));
                    $ruta = str_replace(" ","-",$ruta);

                    if($idProducto == 0)
                    {
                        $option = 1;
                        if($_SESSION['permisosMod']['w']){
                        $request_producto = $this->model->insertProducto($strNombre,
                                                                        $strDescripcion,
                                                                        $strCodigo,
                                                                        $intCategoriaId,
                                                                        $strPrecio,
                                                                        $intStock,
                                                                        $ruta,
                                                                        $intStatus);
                        }
                    }else{

                        $option = 2;
                        if($_SESSION['permisosMod']['u']){
                        $request_producto = $this->model->updateProducto($idProducto,
                                                                        $strNombre,
                                                                        $strDescripcion,
                                                                        $strCodigo,
                                                                        $intCategoriaId,
                                                                        $strPrecio,
                                                                        $intStock,
                                                                        $ruta,
                                                                        $intStatus );
                        }
                    }
                    

                    if($request_producto > 0)
                    {
                        if($option == 1)
                        {
                            $arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Producto guardado correctamente.');
                        }else{
                            $arrResponse = array('status' => true, 'idproducto' => $idProducto, 'msg' => 'Producto actualizado correctamente.');
                        }
                    }else if($request_producto == false)
                    {
                        $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el código ingresado.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                    }

            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();

        

        
        
    }
        
    

}

public function getProducto(int $idproducto)
{
    if($_SESSION['permisosMod']['r']){
    $idproducto = intval($idproducto);
    if($idproducto > 0)
    {
        $arrData = $this->model->selectProducto($idproducto);
        if(empty($arrData)){
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        }else{
            $arrImg = $this->model->selectImages($idproducto);
            if(count($arrImg) > 0){
                for($i=0; $i < count($arrImg); $i++){
                    $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                }
            }
            $arrData['images'] = $arrImg;
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
       echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    }
       die();
    } 
}

public function setImage()
{
    if($_POST)
    {
        if(empty($_POST['idproducto'])){
            $arrResponse = array('status' => false, 'msg' => 'Error de carga.');
        }else{
            $idProducto = intval($_POST['idproducto']);
            $foto       = $_FILES['foto'];
            $imgNombre  = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg';
            $request_image = $this->model->insertImage($idProducto,$imgNombre);
        if($request_image)
        {
            $uploadImage = uploadImage($foto,$imgNombre);
            $arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Imagen cargada correctamente');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error de carga.');
        }
        
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    }

  die();
}

public function delFile()
{
    if($_POST){
        if(empty($_POST['idproducto']) || empty($_POST['file'])){
            $arrResponse = array('status' => false, 'msg' => 'Datos Incorrectos');
        }else{
            $idProducto = intval($_POST['idproducto']);
            $imgNombre = strClean($_POST['file']);
            $request_image = $this->model->deleteImage($idProducto, $imgNombre);

            if($request_image){
                $deleteFile = deleteFile($imgNombre);
                $arrResponse = array('status' => true, 'msg' => 'Foto eliminada');
            }else{
                $arrResponse = array('status' => true, 'msg' => 'Error al eliminar foto');
            }
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    }
    die();
}

public function delProducto(){
    if($_POST){
        if($_SESSION['permisosMod']['d']){
        $intIdproducto = intval($_POST['idproducto']);
        $requestDelete = $this->model->deleteProducto($intIdproducto);
        if($requestDelete)
        {
            $arrResponse = array('status' => true, 'msg' => 'Producto eliminado con éxito');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    }
}
    die();
}

public function generateCode(){
    $refcobro = $this->model->generateCodes();
    if($refcobro)
    {
        $arrResponse = array('status' => true, 'codigo' => $refcobro, 'msg' => 'Codigo generado con éxito');
    }
    else
    {
        $arrResponse = array('status' => false, 'msg' => 'Error al generar el codigo');
    }
    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    die();
}

}

?>