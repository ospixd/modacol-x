<?php

class ClientesModel extends Mysql
{

    private $intIdUsuario;
    private $strIdentificacion;
    private $strNombre;
    private $strApellido;
    private $intTelefono;
    private $strEmail;
    private $strPassword;
    private $strToken;
    private $intTipoId;
    private $intStatus;
    private $strNit;
    private $strNomFiscal;
    private $strDirFiscal;

    public function __construct()
    {
       parent::__construct();
    }

    public function insertCliente(string $identificacion, string $nombre, string $apellido, int $telefono, string $email, int $tipoid, string $nit, string $nomfiscal, string $dirfiscal, string $password){
        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->intTipoId = $tipoid;
        $this->strNit = $nit;
        $this->strNomFiscal = $nomfiscal;
        $this->strDirFiscal = $dirfiscal;
        $this->strPassword = $password;
        
        $return = 0;

        $sql = "SELECT * FROM persona WHERE
        email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}' ";

        $request = $this->select_all($sql);

        if(empty($request))
        {
            $query_insert = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,rolid,nit,nombrefiscal,direccionfiscal,password) VALUES(?,?,?,?,?,?,?,?,?,?)";

            $arrData = array($this->strIdentificacion,
                            $this->strNombre,
                            $this->strApellido,
                            $this->intTelefono,
                            $this->strEmail,
                            $this->intTipoId,
                            $this->strNit,
                            $this->strNomFiscal,
                            $this->strDirFiscal,
                            $this->strPassword
                            );
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = false;
        }
        return $return;
    }

    public function selectClientes()
    {   
        $sql= "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,status FROM persona WHERE rolid = 8 and status != 0 ";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCliente(int $idpersona){
        $this->intIdUsuario = $idpersona;
        $sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,nit,nombrefiscal,direccionfiscal,status,
        DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro
        FROM persona 
        WHERE idpersona = $this->intIdUsuario and rolid = 8";
        $request = $this->select($sql);
        return $request;
    }

    public function updateCliente(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $nit, string $nomfiscal, string $dirfiscal, string $password, ){

        $this->intIdUsuario = $idUsuario;
        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strNit = $nit;
        $this->strNomFiscal = $nomfiscal;
        $this->strDirFiscal = $dirfiscal;
        $this->strPassword = $password;
        

        $sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario) 
                                    OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario) ";
        $request = $this->select_all($sql);

        if(empty($request))
        {
            if($this->strPassword != "")
            {
                $sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, nit=?, nombrefiscal=?, direccionfiscal=?, password=?  WHERE idpersona = $this->intIdUsuario";
                $arrData = array(
                                    $this->strIdentificacion,
                                    $this->strNombre,
                                    $this->strApellido,
                                    $this->intTelefono,
                                    $this->strEmail,
                                    $this->strNit,
                                    $this->strNomFiscal,
                                    $this->strDirFiscal,
                                    $this->strPassword
                                    );
            }else{
                $sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, nit=?, nombrefiscal=?, direccionfiscal=?  WHERE idpersona = $this->intIdUsuario";
                $arrData = array( 
                                    $this->strIdentificacion,
                                    $this->strNombre,
                                    $this->strApellido,
                                    $this->intTelefono,
                                    $this->strEmail,
                                    $this->strNit,
                                    $this->strNomFiscal,
                                    $this->strDirFiscal
                                    );
            }
            $request = $this->update($sql,$arrData);

        }else{
            $request = false;
        }

        return $request;

    }

    public function deleteCliente(int $intIdpersona)
    {
        $this->intIdUsuario = $intIdpersona;
        $sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario ";
        $arrData = array(0);
        $request = $this->update($sql,$arrData);
        return $request;

    }

}