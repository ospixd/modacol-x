<?php

class Suscriptores extends Controllers{
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
        
        
        getPermisos(MSUSCRIPCIONES);

    }

    public function Suscriptores()
    {
        
        $data['page_tag'] = "Suscriptores";
        $data['page_title'] = "Suscriptores <small>Tienda Virtual</small>";
        $data['page_name'] = "suscriptores";
        $data['page_functions_js'] = "functions_suscriptores.js";
        $this->views->getView($this,"suscriptores",$data);
    }

    public function getSuscriptores(){
        if($_SESSION['permisosMod']['r']){
            $arrData = $this->model->selectSuscriptores();
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
    }
}
?>