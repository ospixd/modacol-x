<?php
class Perfil extends Controllers{
    public function __construct()
    {
        //sessionStart();
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'login');
        }
        

    }

    public function perfil(){
        $data['page_tag'] = "Perfil";
        $data['page_title'] = "Perfil de usuario";
        $data['page_name'] = "perfil";
        $data['page_functions_js'] = "functions_perfiles.js";
        $this->views->getView($this,"perfil",$data);
    }

    public function putPerfil(){
        if($_POST){
            if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) )
            {
                $arrResponse = array('status' => false, 'msg' => 'Datos Incorrectos');
            }else{
                $idUsuario = $_SESSION['idUser'];
                $strIdentificacion = strClean($_POST['txtIdentificacion']);
                $strNombre = strClean($_POST['txtNombre']);
                $strApellido = strClean($_POST['txtApellido']);
                $intTelefono = intval(strClean($_POST['txtTelefono']));
                $strPassword = "";
                if(!empty($_POST['txtPassword'])){
                    $strPassword = hash("SHA256",$_POST['txtPassword']);
                }

                $request_user = $this->model->updatePerfil($idUsuario,
                                                            $strIdentificacion,
                                                            $strNombre,
                                                            $strApellido,
                                                            $intTelefono,
                                                            $strPassword);

                if($request_user)
                {
                    sessionUser($_SESSION['idUser']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados Correctamente.');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                }

                
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }


public function putDFiscal (){
    if($_POST){
        if(empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']))
        {
            $arrResponse = array('status' => false, 'msg' => 'Datos Incorrectos');
        }else{
            $idUsuario = $_SESSION['idUser'];
            $strNit = strClean($_POST['txtNit']);
            $strNomFiscal = strClean($_POST['txtNombreFiscal']);
            $strDirFiscal = strClean($_POST['txtDirFiscal']);

            $request_datafiscal = $this->model->updateDataFiscal($idUsuario,
                                                        $strNit,
                                                        $strNomFiscal,
                                                        $strDirFiscal);

            if($request_datafiscal)
            {
                sessionUser($_SESSION['idUser']);
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados Correctamente.');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'No es posible actualizar los datos.');
            }
            
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    }
    die();
}
}
?>