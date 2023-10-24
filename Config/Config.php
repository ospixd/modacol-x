<?php

    const BASE_URL = "https://modacolx.vercel.app/";

    //Zona horaria
    date_default_timezone_set('America/Bogota');
    
    //Datos de conexion a la base de datos
    const DB_HOST = "localhost";
    const DB_NAME = "db_tiendavirtual";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB_CHARSET = "charset=utf8";

    //Deliminadores decimal y millar Ej. 24,1998.00
    const SPD = ".";
    const SPM = ",";

    //Simbolo de moneda
    const SMONEY = "$";
    const CURRENCY = "USD";

    //API PAYPAL
    //SANDBOX
    const URLPAYPAL = "https://api-m.sandbox.paypal.com";
    const IDCLIENTE = "AbMzHzxJbR5lcdWHhGq7DsPnfb7cKbgLFZeMBsALgGmJojvWmCZDn76qcw_G6moGkHmRG8934Pt4tJ7u";
    const SECRET = "ENGnSXI7mioNQSMmqtk5MwPBb4R08xPiENAxktmY87q6DA7hZVKrQf37vbY-nNsNht3IkGQB6Mtphm8z";
    //LIVE
    //const URLPAYPAL = "htps://api-m.paypal.com";
    //const IDCLIENTE = "AaDb79viiiLXfOwKMXZEgRuAGDm9nsh1H6CVCFglLbtO44ka-2QqN7Y28RgvBs5toNs9Ats__b7Z6dm4";
    //const SECRET = "EMnQP9HNlCjJNcLVq6mVebY-ICOjSogSZpvazTZ-l8YKKRC6rVNaK-7UO4YL3NFU5UTWVvOxg2AO6naI";


    //API WOMPI SANDBOX
    const URLWOMPI = "https://sandbox.wompi.co/v1";
    const CURRENCYWOMPI = "COP";
    const IDCLIENTEWOMPI = "pub_test_1drS2eRh8Nw0Sjk3YAup65kQdlHqlHDL";
    const SECRETOINTEGRIDAD = "test_integrity_rxUcgd6nowmCn9OacITrMLwB9UZAyXmo";
    const LLAVEPRIVADA = "prv_test_yt2jOzvaF4FBirWDkJhH68BwkTcvCON8";
    const COMISIONWOMPI = 0.0265;
    const MASWOMPI = 700;
    const IVAWOMPI = 0.19;

    //API WOMPI LIVE
    // const URLWOMPI = "https://production.wompi.co/v1";
    // const CURRENCYWOMPI = "CO";
    // const IDCLIENTEWOMPI = "pub_prod_x0eCuLijsZ9mDo9rMki8LFBBdkwnl8Tq";
    // const SECRETOINTEGRIDAD = "prod_integrity_vD1Ul4g2hgHG9jdOUb0arYZSLtgStLYi";



    //Datos envio de correo
    const NOMBRE_REMITENTE = "Tienda Virtual";
    const EMAIL_REMITENTE = "no-reply@tecnojuan.c1.is";

    //Datos empresa
    const NOMBRE_EMPRESA = "ModaCol-X";
    const WEB_EMPRESA = "www.tecnojuan.c1.is";
    const DIRECCION = "Cali, Colombia";
    const TELEMPRESA = "(+57) 3005946581";
    const WHATSAPP = "+573005946581";
    const EMAIL_EMPRESA = "info@modacolx.com";
    const EMAIL_PEDIDOS = "info@modacolx.com";
    const EMAIL_SUSCRIPCION = "info@modacolx.com";

    const CAT_SLIDER = "1,2,3";
    const CAT_BANNER = "4,5,6";
    const CAT_FOOTER = "1,2,3,4,5";
    
    //Datos de encriptacion

    const KEY = 'tecnojuan';
    const METHODENCRIPT = "AES-128-ECB";

    const COSTOENVIO = 0;

    //ROLES
    const RADMINISTRADOR = 1;
    const RCLIENTES = 8;

    //Modulos
    const MPEDIDOS = 5;
    const MCLIENTES = 3;
    const MSUSCRIPCIONES = 8;

    //Productos por pagina
    const CANTPRODHOME = 8;
    const PROPDPORPAGINA = 8;
    const PROPDPORCATEGORIA = 8;
    const PRODBUSCAR = 8;

    const STATUS = array('Completo','Aprobado','Cancelado','Reembolsado','Pendiente','Entregado');

    const FACEBOOK = "https://www.facebook.com/profile.php?id=100095385461354";
    const INSTAGRAM = "https://www.instagram.com/tecno.juanse/";
?>
