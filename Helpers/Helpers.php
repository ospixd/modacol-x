<?php
use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;
require 'Exception.php';

require 'PHPMailer.php';

require 'SMTP.php';

//Retorna la URL del proyecto

function base_url()
{
    return BASE_URL;
}

//Retorna la URL de assets
function media()
{
    return BASE_URL."Assets";
}

function headerAdmin($data="")
{
    $view_header = "Views/Template/header_admin.php";
    require_once ($view_header);
}
function footerAdmin($data="")
{
    $view_footer = "Views/Template/footer_admin.php";
    require_once ($view_footer);
}

function headerTienda($data="")
{
    $view_header = "Views/Template/header_tienda.php";
    require_once ($view_header);
}
function footerTienda($data="")
{
    $view_footer = "Views/Template/footer_tienda.php";
    require_once ($view_footer);
}


//Muestra Información formateada
function dep($data)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

function getModal(string $namemodal, $data)
{
    $view_modal = "Views/Template/Modals/{$namemodal}.php";
    require_once $view_modal;
}

function getFile(string $url, $data)
{
    ob_start();
    require_once("Views/{$url}.php");
    $file = ob_get_clean();
    return $file;
}

function sendEmail($data,$template)
{
    
     $asunto = $data['asunto'];
     $emailDestino = $data['email'];
     $empresa = NOMBRE_REMITENTE;
     $remitente = EMAIL_REMITENTE;
     $emailCopia = !empty($data['emailCopia']) ? $data['emailCopia'] : "";

     //ENVIO DE CORREO
     $de = "MIME-Version: 1.0\r\n";
     $de .= "Content-type: text/html; charset=UTF-8\r\n";
     $de .= "From: {$empresa} <{$remitente}>\r\n";
     $de .= "Bcc: $emailCopia\r\n";
     ob_start(); //cargar en memoria (bufer) el archivo que se le mande
     require_once("Views/Template/Email/".$template.".php");
     $mensaje = ob_get_clean();
     $send = mail($emailDestino, $asunto, $mensaje, $de);
     return $send;

}


function getPermisos(int $idmodulo)
    {
        require_once ("Models/PermisosModel.php");
        $objPermisos = new PermisosModel();
        $idrol = $_SESSION['userData']['idrol'];
        $arrPermisos = $objPermisos->permisosModulo($idrol);
        $permisos = '';
        $permisosMod = '';

        if(count($arrPermisos) > 0){
            $permisos = $arrPermisos;
            $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
        }
        $_SESSION['permisos'] = $permisos;
        $_SESSION['permisosMod'] = $permisosMod;
    }

    function sessionUser(int $idpersona){
     require_once("Models/LoginModel.php");
     $objLogin = new LoginModel();
     $request = $objLogin->sessionLogin($idpersona);
     return $request;
    }

//    function sessionStart(){
//      session_start();
//      $inactive = 3600;
//      if(isset($_SESSION['timeout'])){
//         $session_in = time() - $_SESSION['inicio'];
//         if($session_in > $inactive){
//             header("Location: ".BASE_URL."/logout");
//         }
//      }else{
//         header("Location: ".BASE_URL."/logout");
//      }
//    }

function uploadImage(array $data, string $name)
{
    $url_temp = $data['tmp_name'];
    $destino = 'Assets/images/uploads/'.$name;
    $move = move_uploaded_file($url_temp, $destino);
    return $move;
}

function deleteFile(string $name)
{
    unlink('Assets/images/uploads/'.$name);
}


//Elimina exceso de espacios entre palabras
function strClean($strCadena){
    $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>","",$string);
    $string = str_ireplace("</script>","",$string);
    $string = str_ireplace("<script src>","",$string);
    $string = str_ireplace("<script type=>","",$string);
    $string = str_ireplace("SELECT * FROM","",$string);
    $string = str_ireplace("DELETE FROM","",$string);
    $string = str_ireplace("INSERT INTO","",$string);
    $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
    $string = str_ireplace("DROP TABLE","",$string);
    $string = str_ireplace("OR '1'='1","",$string);
    $string = str_ireplace('OR "1"="1"',"",$string);
    $string = str_ireplace('OR ´1´=´1´',"",$string);
    $string = str_ireplace("is NULL; --","",$string);
    $string = str_ireplace("is NULL; --","",$string);
    $string = str_ireplace("LIKE '","",$string);
    $string = str_ireplace('LIKE "',"",$string);
    $string = str_ireplace("LIKE ´","",$string);
    $string = str_ireplace("OR 'a'='a","",$string);
    $string = str_ireplace('OR "a"="a',"",$string);
    $string = str_ireplace("OR ´a´=´a","",$string);
    $string = str_ireplace("OR ´a´=´a","",$string);
    $string = str_ireplace("--","",$string);
    $string = str_ireplace("^","",$string);
    $string = str_ireplace("[","",$string);
    $string = str_ireplace("]","",$string);
    $string = str_ireplace("==","",$string);
    return $string;
}

function clear_cadena(string $cadena){
    //Reemplazamos la A y a
    $cadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $cadena );

    //Reemplazamos la I y i
    $cadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $cadena );

    //Reemplazamos la O y o
    $cadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $cadena );

    //Reemplazamos la U y u
    $cadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $cadena );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
    array('N', 'n', 'C', 'c','','','',''),
    $cadena
    );
    return $cadena;
}

    function passGenerator($length = 10)
    {
        $pass = "";
        $longitudPass=$length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);

        for($i=1; $i<=$longitudPass; $i++)
        {
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

    function token()
    {
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }

    function formatMoney($cantidad)
    {
        $cantidad = number_format($cantidad,0,SPD,SPM);
        return $cantidad;
    }

    function codigoUnico(){
        $codigo = "";
        $longitudCod = 15;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $longitudCadena = strlen($cadena);

        for($i=1; $i<=$longitudCod; $i++)
        {
            $pos = rand(0,$longitudCadena-1);
            $codigo .= substr($cadena,$pos,1);
        }
        return $codigo;
    }
 
    function getTokenPaypal(){
        $payLogin = curl_init(URLPAYPAL."/v1/oauth2/token");
        curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($payLogin, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($payLogin, CURLOPT_USERPWD, IDCLIENTE.":".SECRET);
        curl_setopt($payLogin, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result=curl_exec($payLogin);
        $err = curl_error($payLogin);
        curl_close($payLogin);
        if($err){
            $request = "CURL Error #:".$err;
        }else{
            $objData = json_decode($result);
            $request = $objData->access_token;
        }
        return $request;
        
        
        
    }

    function getTransaccionWompi($id){
        $wompi = curl_init(URLWOMPI."/transactions/".$id);
        curl_setopt($wompi, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($wompi, CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($wompi);
        $err = curl_error($wompi);
        curl_close($wompi);
        if($err){
            $request = "CURL Error #:".$err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }

    

    function getDatosWompi($id){
        $arrHeader = array('Authorization: Bearer '.LLAVEPRIVADA);
        $payLogin = curl_init(URLWOMPI."/transactions?reference=".$id);
        curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($payLogin, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($payLogin, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($payLogin);
        $err = curl_error($payLogin);
        curl_close($payLogin);
        if($err){
            $request = "CURL Error #:".$err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }

    function getSecretWompi(string $referencia, string $monto){
        $cadena = $referencia.$monto.CURRENCYWOMPI.SECRETOINTEGRIDAD;
        $return = hash("sha256", $cadena);
        return $return;
    }

    

    function getTokenWompi(){
        $payLogin = curl_init(URLWOMPI."/merchants/pub_test_1drS2eRh8Nw0Sjk3YAup65kQdlHqlHDL");
        curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($payLogin, CURLOPT_RETURNTRANSFER,TRUE);
        $result=curl_exec($payLogin);
        $err = curl_error($payLogin);
        curl_close($payLogin);
        if($err){
            $request = "CURL Error #:".$err;
        }else{
            $objData = json_decode($result);
            $request = $objData;
            $resultado = array($objData->data->presigned_acceptance->acceptance_token,
                            $objData->data->presigned_acceptance->permalink);
            // $token = $objData->data->presigned_acceptance->acceptance_token;
            // $permaLink = $objData->data->presigned_acceptance->permalink;
        }
        return $resultado;
    }

    function CurlConnectionGet(string $ruta, string $contentType = null, string $token){
        $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != null){
            $arrHeader = array('Content-Type:'.$content_type,
                            'Authorization: Bearer '.getTokenPaypal());
        }else{
            $arrHeader = array('Content-Type:'.$token);
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:".$err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }

    function CurlConnectionPost(string $ruta, string $contentType = null, string $token){
        $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != null){
            $arrHeader = array('Content-Type:'.$content_type,
                            'Authorization: Bearer '.getTokenPaypal());
        }else{
            $arrHeader = array('Content-Type:'.$token);
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:".$err;
        }else{
            $request = json_decode($result);
        }
        return $request;
    }

    function Meses(){
        $meses = array("Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre");
        return $meses;
    }

    function getCatFooter(){
        require_once("Models/CategoriasModel.php");
        $objCategoria = new CategoriasModel();
        $request = $objCategoria->getCategoriasFooter();
        return $request;
    }




?>