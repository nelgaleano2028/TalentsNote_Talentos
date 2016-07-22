<?php

    /*~ class_mailer.php
    .---------------------------------------------------------------------------.
    |   Software: mailer - PHP clase de correos                                 |
    |   Versión: 1.0.0                                                          |
    |   Contacto: (www.talentsw.com)                                            |
    | ------------------------------------------------------------------------- |
    |    Author: Juan Manuel lópez                                              |
    | Copyright (c) 2012-2016, Talentsw. All Rights Reserved.                   |
    | ------------------------------------------------------------------------- |
    |License: Distribuida para los desarrolladores web de Talentos y Tecnologia |
    | este programa es distribuido para el envió de correos el uso es           |
    | laboral, estudiantil y experimental.                                      |
    '---------------------------------------------------------------------------'
    
    /**
     * mailer - PHP envio de correos
     * @package mailer
     * @author Juan Manuel López
     * @copyright 2012 - 2016 Talentos y Tecnologia S.A.S
     */

    
    /*
    .--------------------------------.
    |Llamado de la libreria PHPMAILER|
    '--------------------------------'
    */
	
    require_once("class.phpmailer.php");
    require_once("class.smtp.php");
    require_once("class.pop3.php");
  
    

    
    class mailer extends PHPMailer{
        
        /*variables que se heredó de la clase PHPMailer las cuales me permiten configurar el envio de correos*/
        var $From;
        var $FromName;
        var $Host;
        var $Port;
        var $Mailer;
        var $SMTPAuth;
        var $Username;
        var $Password;
        var $WordWrap;
        
        function __construct(){
            
                /*COnfiguramos los parametos de la libreria php mailer*/
                 $this->From = 'servidorcorreostalentos@gmail.com';//$return[0]["DESCRIPCION"]; /*Quien envia el correo*/
                 $this->FromName = 'Administrador talentos y tecnologia';
                 $this->Host = 'smtp.gmail.com'; /*Host del servidor de correo*/
                 $this->Port = 465; /*Puerto del servidor de correo*/
                 $this->Mailer = "smtp";  // Alternative to IsSMTP()
                 $this->SMTPAuth = true; /*Se activa la autencticacion del servidor de correo*/
                 $this->Username = "servidorcorreostalentos@gmail.com";/*Usuario del servidor de correo */
                 $this->Password = "tytcali2015";/*Password del servidor de correo*/
                 $this->WordWrap = 72;
                 $this->SMTPSecure = "ssl";
                 
				 
        }
        
    }
?>