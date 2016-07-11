<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller{
	
	public $view = array();
	public $login = array();	
	public $data = array();
	public function __construct(){ 		
		parent::__construct(); 
				
		// Permisos
		$this->login = $this->session->userdata( 'login' );
		if( empty( $this->login ) ) redirect( '/usuario/login', 'refresh' );
	}	
	
	
	public function index(){
		
		// Permisos
		if($this->login[0]['id_perfil'] != 1){				
			$message = array(
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			);			
			redirect( '/admin/','refresh' );
		}
		
		// Load Model
		$this->load->model( 'cliente' );
		$this->view=array(
			
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.min.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/animate.css" type="text/css"/>',
				
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/datatable.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',				
			),
			'login' => $this->login,
			'section' => 'inicio',
			'content' => 'admin/clientes/listar',
			'data' => $this->cliente->all()
			
	    );	
		$this->load->view('includes/include', $this->view );
	}
	
				
	public function crear(){
		// Permisos
		if( $this->login[0]['id_perfil'] != 1  ){				
			$message = array(
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 	
			);
						
			redirect( '/admin/', 'refresh' );
		}
		
		if(!empty($_POST)){ 
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nombre_cliente', 'Nombre del cliente', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('nit', 'Nit', 'trim|required|callback__nit');
			$this->form_validation->set_rules('razon_social', 'Razón social', 'trim|required|xss_clean|callback__alfanumeric');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ($this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('nombre_cesantias'),
					'nit'=>form_error('nit'),
					'razon'=>form_error('razon_social')
				);
				$this->session->set_flashdata('errores',$errores);	
				redirect('clientes');
			
			}else{
				
				// Cargar modelo de datos
				$this->load->model( 'cliente' );
				
				if($this->cliente->crear($this->input->post()) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata('message',$message);		
					redirect('/clientes','refresh');
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);	
					$this->session->set_flashdata( 'message', $message );			
					redirect( '/clientes', 'refresh' ); 	
				}			
			}
			
			exit;
		
		}
		
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/clientes/file.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'login' => $this->login,
			'section' => 'inicio',
			'content' => 'admin/clientes/crear',
	    );
		
			
		$this->load->view( 'includes/include', $this->view );
				
	
	}
	
	public function editar( $id = null ){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 1  ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/', 'refresh' );
		
		}
				
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/clientes', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'cliente' );
		
		$this->data = $this->cliente->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/clientes', 'refresh' ) ;
		}
		
		if( !empty( $_POST ) ){ 
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nombre_cliente', 'Nombre del cliente', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('nit', 'Nit', 'trim|required|callback__nit');
			$this->form_validation->set_rules('razon_social', 'Razón social', 'trim|required|xss_clean|callback__alfanumeric');
			
			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('nombre_cesantias'),
					'nit'=>form_error('nit'),
					'razon'=>form_error('razon_social')
				);
				$this->session->set_flashdata('errores',$errores);	
				redirect('clientes/editar/'.$id);	
			
			}else{
				
												
				if( $this->cliente->editar( $id, $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/clientes', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/clientes', 'refresh' ); 
					
				}				
					
			}
			
			exit;
		
		}
		
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),			
			'data' => $this->data,
			'login' => $this->login,
			'section' => 'inicio',
			'content' => 'admin/clientes/editar',
	    );
		
		$this->load->view( 'includes/include', $this->view );
			
	}
	
	public function eliminar( $id = null ){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 1  ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/', 'refresh' );
		
		}
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/clientes', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'cliente' );
		
		$this->data = $this->cliente->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/clientes', 'refresh' ) ;
		}
		
		if( $this->cliente->eliminar( $id ) == true ){
			
			$message = array(
				'type' => 'success',
				'text' => 'El registro se elimino correctamente.' 
			);
										
			$this->session->set_flashdata( 'message', $message );	
									
					
			redirect( '/clientes', 'refresh' );
		
		}else{
			
			$message = array(
				'type' => 'failure',
				'text' => 'Ha ocurrido un error no se puede eliminar el registro. Hay incidentes asociados al cliente.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
								
			redirect( '/clientes', 'refresh' ); 
			
		}
		
	
	}
	
/*
==============================	
	 Incidentes
============================== */		
	public function perfil_cliente( $id = null ){
		
		$id=$this->login[0]['id_contacto'];
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 3 and $this->login[0]['estado'] != 1 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/', 'refresh' );
		
		}
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/admin/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'contactos' );
		
		$this->data = $this->contactos->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/admin/', 'refresh' ) ;
		}
		
		
		if( !empty( $_POST ) ){
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('telefono', 'Telefono', 'trim|required|xss_clean|callback__phone');
			$this->form_validation->set_rules('correo', 'Nit', 'trim|required|valid_email');
			$this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|xss_clean|matches[re_contrasena]');
			$this->form_validation->set_rules('re_contrasena', 'Repetir Contraseña', 'trim|xss_clean');


			
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			$this->form_validation->set_message('_phone', 'El Campo %s no es un teléfono valido...');
			$this->form_validation->set_message('valid_email', 'El Campo %s no es un correo valido...');
			$this->form_validation->set_message('matches','Las contraseñas no son iguales');

			
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'contra'=>form_error('contrasena'),
					'recontra'=>form_error('re_contrasena'),
			        'cel'=>form_error('telefono'),
			        'correo'=>form_error('correo'),
					);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('clientes/perfil_cliente/'.$id); 
			
			}else{
				
				
				// if( $_FILES['foto']['name'] != ''){
					
					// 	$file = explode( '.', $_FILES['foto']['name'] );		
					// 	if($file[1] != 'gif' and $file[1] != 'jpg' and $file[1] != 'png' and $file[1] != 'gif'){
								
					// 		$message = array(
					// 			'type' => 'failure',
					// 			'text' => 'El archivo que intenta subir no tiene una extención valida'	
					// 		);
					// 		$this->session->set_flashdata( 'message', $message );				
					// 		redirect( '/clientes/perfil_cliente/'.$this->login[0]['id_usuario'], 'refresh' );	
							
					// 		}
							
					// 	if( !is_dir( './usuarios' ) ){
							
					// 		$message = array(
					// 			'type' => 'failure',
					// 			'text' => 'No existe el directorio ingeniero..'	
					// 		);
								
					// 		$this->session->set_flashdata( 'message', $message );		
								
					// 		redirect( '/clientes/perfil_cliente/'.$this->login[0]['id_usuario'], 'refresh' );	
							
					// 	}
						
					// 	if( !empty( $this->data[0]['img'] ) ){
							
					// 		if( is_file( './ususarios/'.$this->data[0]['img'] ) )
					// 				unlink( './usuarios/'.$this->data[0]['img'] );
							
					// 	}
							
							
					// 	$_FILES['foto']['name']=$this->login[0]['Usuario'].'.'.$file[1];
					// 	$name = str_replace( ' ', '-', $_FILES['foto']['name'] );
					// 	$name = str_replace( '/', '-', $name );					
					// 	$name = strtolower( $name );					
					// 	move_uploaded_file($_FILES["foto"]["tmp_name"], './usuarios/'.$name );					
					// 	 // crear valores de configuracion para cargar la libreria
					// 	$config['image_library'] = 'GD2';   // libreria a utilizar
					// 	$config['source_image'] = './usuarios/'.$name;  // imagen fuente, aqui se debe colocar la ruta completa del archivo en el servidor tomando como referencia la raíz del sitio (ejemplo ./uploads/)
					// 	$config['width'] =  85;          // ancho de la imagen a generar
					// 	$config['height'] = 60;          // alto de la imagen a generar
					// 	$config['maintain_ratio'] = TRUE;
					// 	$config['create_thumb'] = FALSE;     // especificar que se quiere generar un thumbnail						 
					// 	$this->load->library('image_lib', $config); 					
					// 	$this->image_lib->resize();         // crear thumbnail							
					// 	$_POST['img'] = $name;
				// }	
			
				$this->load->model('usuarios');
				 
				if( $contrasena=$this->usuarios->contrasena_cliente($this->login[0]['id_contacto'], $this->input->post('contrasena_original'))== false){
				
					$message = array(
								'type' => 'failure',
								'text' => 'La contraseña anterior no es valida intentelo de nuevo' 
					);
											
					$this->session->set_flashdata( 'message', $message );		
					redirect( '/clientes/perfil_cliente/'.$this->login[0]['id_usuario'], 'refresh' );
				
				}
					
				if( $this->contactos->editar( $id, $this->input->post() ) == true ){
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
					redirect( '/clientes/perfil_cliente/'.$this->login[0]['id_usuario'], 'refresh' );
											
				}else{
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
					$this->session->set_flashdata( 'message', $message );
					redirect( '/clientes/perfil_cliente/'.$id, 'refresh' ); 
				}
				exit;
			}			
			exit;
		}
		$this->load->model( array( 'usuarios' ) );
		$usuario= $this->usuarios->entrar_cliente($this->login[0]['id_contacto']);
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'usuario'=>$usuario,
			'data' => $this->data,
			'login' => $this->login,
			'section' => 'nuevo',
			'content' => 'clientes/perfil_cliente'
			
	    );
		
		$this->load->view( 'includes/include_cliente', $this->view );	
		
	}
	

/*
===================================
	Front end
=================================== */	
	public function incidente_crear( $incidencia = null ){
		
		// Validaciones
		if( empty( $incidencia ) or !is_numeric( $incidencia ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/clientes/ver_incidente/', 'refresh' ) ;
		}
				
		
		$this->load->model( array( 'ingenieros',  'notas', 'incidencia' ) );
		
		$this->data = $this->incidencia->id( $incidencia );
		
		
		// Validaciones
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/clientes/ver_incidente/', 'refresh' ) ;
		}
		
						
		if( !empty( $_POST ) ){
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('notas', 'Notas', 'trim|required|xss_clean');
						
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('notas')
				);
												
				$this->session->set_flashdata( 'errores', $errores );	
				redirect( 'clientes/incidente_crear/'.$incidencia);
			
			}else{			
				date_default_timezone_set("America/Bogota");
									
				$nota = array(
					'id_incidencia' => $incidencia,
					'notas' => $this->input->post( 'notas' ),
					'firmausuario' => $this->login[0]['Usuario'],
					'fecha' => date( 'Y-m-d h:i:s/a', time())
				);
			
				if( $this->notas->crear( $nota ) == true  ){
					
					//enviar correos
					$this->enviar_correo($incidencia);
					
					$message = array(
						'type' => 'success',
						'text' => 'El registro se guardo correctamente.' 
					);
												
					$this->session->set_flashdata( 'message', $message );	
											
							
					redirect( '/clientes/ver_incidente/', 'refresh' );
					
				}else{
					
					$message = array(
						'type' => 'failure',
						'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
								
					$this->session->set_flashdata( 'message', $message );
										
					redirect( '/clientes/ver_incidente/', 'refresh' ); 
					
				}
				
			}
		
		}
		
		// Load Model
		$this->load->model( array( 'incidencia', 'areas', 'notas', 'usuarios' ) );
		$usuario= $this->usuarios->entrar_cliente($this->login[0]['id_contacto']);
		
		$this->view=array(
			'title'=>'Talents Note',
			'css'=>array(

                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				'<link type="text/css" rel="stylesheet" href="'.base_url().'style/summernote/summernote.css" media="screen"/>',
				'<link type="text/css" rel="stylesheet" href="'.base_url().'style/themes/base/jquery-ui.css" media="screen"/>',
				'<link type="text/css" rel="stylesheet" href="'.base_url().'style/dataTables.bootstrap.css" media="screen"/>', 
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',         
				'<style type="text/css">
				  .modal-body div img {
				    max-width: 100%; }
				</style>'
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/clientes/tabla.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/summernote/summernote.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/clientes/file.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/clientes/dialog.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#notas").summernote({
							height: "300px",
					        toolbar: [
					  		    ["style", ["bold", "italic","underline","clear"]],
					  		    ["para", ["ul","ol"]]
					        ]
						});
					});
				</script>'
				
			),
			'usuario'=>$usuario,
			'incidencia'=>$this->incidencia->id($incidencia),
			'id_incidencia' => $incidencia,
			'notas' => $this->notas->incidencia($incidencia),
			'areas' => $this->areas->all(),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'clientes/incidente/crear'
			
	    );
		
		$this->load->view( 'includes/include_cliente', $this->view );
		

	}
	
	public function enviar_correo( $incidencia = null){
		
		$this->load->model('incidencia');
		
		$enviar=$this->incidencia->correo( $incidencia );

		 $this->load->library('My_PHPMailer');
		 $mail = new PHPMailer();
		 $mail->Host = "vladimir.bello@talentsw.com";
		 // $mail->Host = "ssl://smtp.googlemail.com";
		 // $mail->Port = 465; /*Puerto del servidor de correo*/
	  	//  $mail->Mailer = "smtp";  // Alternative to IsSMTP()
	  	//    $mail->SMTPAuth = true; /*Se activa la autencticacion del servidor de correo*/
		 // $mail->Username = "servidorcorreostalentos@gmail.com";
		 // $mail->Password = "tytcali2015";
		 // $mail->WordWrap = 72;
   		// $mail->SMTPSecure = "ssl"; 
		 $mail->FromName = "Administrador AFQsas";
		 $mail->Subject = $enviar[0]['asunto'];
		 $mail->AddAddress($enviar[0]['correo_ingeniero'],'ingeniero');
		 $mail->AddAddress($enviar[0]['correo_contacto'],'cliente');
		 $body = '<table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table">
					<tbody><tr>
						<td align="center" bgcolor="#c7c7c7">
							<table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
								<tbody><tr><td class="w640" width="640" height="20"></td></tr>
								<tr>
									<td class="w640" width="640"><table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#000000">
					<tbody><tr>
						<td class="w15" width="15"></td>
						<td class="w325" width="350" valign="middle" align="left">&nbsp;</td>
						<td class="w30" width="30"></td>
						<td class="w255" width="255" valign="middle" align="right"><table cellpadding="0" cellspacing="0" border="0">
						  <tbody><tr>	
					</tr>
				</tbody></table></td>
						<td class="w15" width="15"></td>
					</tr>
				</tbody></table>
										
									</td>
								</tr>
								<tr>
								<td id="header" class="w640" width="640" align="center" bgcolor="#000000">
					
					<table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
						<tbody><tr><td class="w30" width="30"></td><td class="w580" width="580" height="30"><h1 style="color: #47c8db !important; font: bold 32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"><singleline label="Title">Administrador AFQsas</singleline></h1></td><td class="w30" width="30"></td></tr>
						<tr>
							<td class="w30" width="30"></td>
							<td class="w580" width="580">
								<div align="center" id="headline">
									<p>
										<strong><singleline style="color: #47c8db !important; font:  32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"label="Title">Detalle del Incidente</singleline></strong>
									</p>
								</div>
							</td>
							<td class="w30" width="30"></td>
						</tr>
					</tbody></table>
					
					
				</td>
								</tr>
								
								<tr><td class="w640" width="640" height="30" bgcolor="#ffffff"></td></tr>
								<tr id="simple-content-row"><td class="w640" width="640" bgcolor="#ffffff">
					<table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
						<tbody><tr>
							<td class="w30" width="30"></td>
							<td class="w580" width="580">
							  <table cellpadding="0" cellspacing="0" border="0" width="600">
											<tr>
											   <td><strong>Codigo:</strong> </td>
											   <td>'.$enviar[0]['id_incidencia'].'</td>
											</tr>
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
											 <tr>
											   <td><strong>Estado:</strong> </td>
											   <td>'.$enviar[0]['estado'].'</td>
											</tr>
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
				
											 <tr>
											   <td><strong>Prioridad:</strong> </td>
											   <td>'.$enviar[0]['prioridad'].'</td>
											</tr>
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
				
											 <tr>
											   <td><strong>Causa:</strong></td>
											   <td>'.$enviar[0]['causa'].'</td>
											</tr>
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
				
											<tr>
											   <td><strong>Asunto:</strong> </td>
											   <td>'.$enviar[0]['asunto'].'</td>
											</tr>
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
				
											<tr>
											   <td> <strong>Notas: </strong></td>
											   <td>'.$enviar[0]['notas'].'</td>
											</tr>
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
				
											<tr>
											   <td><strong>Empresa:</strong> </td>
											   <td>'.$enviar[0]['cliente'].'</td>
											</tr>
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
				
											 <tr>
											   <td><strong>Fecha Inicial:</strong> </td>
											   <td>'.$enviar[0]['fecha'].'</td>
											</tr>
											
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
											
											<tr>
											   <td><strong>Fecha Final:</strong> </td>
											   <td>'.$enviar[0]['fecha_final'].'</td>
											</tr>
											
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
											
											<tr>
											   <td><strong>Ingeniero:</strong> </td>
											   <td>'.$enviar[0]['ingeniero'].'</td>
											</tr>
											
											
											</table> 
												
							</td>
							<td class="w30" width="30"></td>
						</tr>
					</tbody></table>
				</td></tr>
								<tr><td class="w640" width="640" height="15" bgcolor="#ffffff"></td></tr>
							</tbody></table>
						</td>
					</tr>
				</tbody></table>';
		 $mail->IsHTML(true); // El correo se envía como HTML
		 $mail->Body = $body;
		 $mail->AltBody = "Talents notes";
		 
		 switch ($enviar[0]['imagen']) {
			 
			 case 'no_subio.png':
			 	$mail->send();
				break;
			 case 'no_disponible.png':
			 	$mail->send();
				break;
			default: 
				$mail->AddAttachment("./incidentes/".$enviar[0]['imagen'], $enviar[0]['imagen'] );
				if($mail->Send()== true){
				 
				 if( is_file( './incidentes/'.$enviar[0]['imagen'] ) )
				 unlink( './incidentes/'.$enviar[0]['imagen'] );
				 
				 $this->incidencia->update_imagen($incidencia);
			 	}	
			 break; 	 
		 }
		 	 
		return true;
		
	}
	
	public function ver_incidente(){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 3  ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/', 'refresh' );
		
		}
		
		//Load model
		$this->load->model( array( 'incidencia', 'usuarios' ));
		$usuario= $this->usuarios->entrar_cliente($this->login[0]['id_contacto']);
		
		$cliente= $this->contactos->id($this->login[0]['id_contacto']);
		
		$datos=$this->incidencia->cliente($cliente[0]['id_cliente']);
		
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.min.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/datatable.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script type="text/javascript" language="javascript">
					$( document ).ready(function() {
						var recurso= $("#vigilante").text();
                        $("#vigilante" ).load(General.base+"clientes/vigilante?cliente="+recurso);
					});
				</script>'
			),
			'usuario'=>$usuario,
			'data' => $datos,
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'clientes/incidente/listar'
			
	    );
		
		$this->load->view( 'includes/include_cliente', $this->view );
	  
	
	}
	
	public function vigilante(){
	
		
		$cliente= $this->input->get('cliente', TRUE);
		
		
		$this->load->model( array( 'incidencia' ));
		
		$this->incidencia->cambiar_condicion($cliente);
		
		
		
		
	}
	
	
	public function nuevo_incidente(){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 3 and $this->login[0]['estado'] != 1 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/', 'refresh' );
		
		}
		
		if( !empty( $_POST ) ){ 
		
			unset($_POST['valor']);
	
			// Configurar Reglas de validación
			$this->form_validation->set_rules('categorias', 'categorias', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_subcategoria', 'Subcategoria', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_condicion', 'Condición', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_area', 'Área', 'trim|required|xss_clean');
			$this->form_validation->set_rules('asunto', 'Subcategoria', 'trim|required|xss_clean|_alfanumeric');
			$this->form_validation->set_rules('detalle', 'Detalle', 'trim|required|xss_clean|_alfanumeric');
		
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			$this->form_validation->set_message('_alfanumeric', 'El Campo %s tiene que ser alfanúmericos...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('categorias'),
					'sub'=>form_error('id_subcategoria'),
					'condicion'=>form_error('id_condicion'),
					'area'=>form_error('id_area'),
					'asunto'=>form_error('asunto'),
					'detalle'=>form_error('detalle')
				);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('clientes/nuevo_incidente');
			
			}else{

				// 	$_POST['imagen']=$name;
				// 	// if ($_FILES['imagen2']['size']>5242880 or $_FILES['imagen2']['size']==0) {
				// 	// 	$error = array(
				// 	// 			'error' =>"La imagen no tiene el tamaño permitido"
				// 	// 		);
				// 	// 	$this->session->set_flashdata('error',$error);	
				// 	// 	redirect( '/clientes/nuevo_incidente');
						
				// 		if (!move_uploaded_file($_FILES["imagen2"]["tmp_name"],'.../incidentes/'.$name )){

				// 			$errors = array(
				// 				'errors' =>"No se puede subir el archivo"
				// 			);
				// 			$this->session->set_flashdata('errors',$errors);	
				// 		}
				// 	// }5242880
				$rr = $this->input->post('imagen');
                $_FILES['imagen']['name']= $rr; 
				if($_FILES['imagen']['name'] !=''){

						$file = explode( '.', $_FILES['imagen']['name'] );
						
						if( !is_dir( './incidentes' ) ){
							
							$message = array(
								'type' => 'failure',
								'text' => 'No existe el directorio ingeniero.'	
							);
								
							$this->session->set_flashdata( 'message', $message );		
								
							redirect( '/clientes/nuevo_incidente/', 'refresh' );	
							
						}
					
					$name = str_replace( ' ', '-', $_FILES['imagen']['name'] );
					$name = str_replace( '/', '-', $name );
					$name = strtolower( $name ); 
					$dividircade = explode(",", $name);
					if ($_FILES['imagen2']['size']>5242880 or $_FILES['imagen2']['size']==0) {
						$error = array(
								'error' =>"La imagen no tiene el tamaño permitido"
							);
						$this->session->set_flashdata('error',$error);	
						redirect( '/clientes/nuevo_incidente');
					}
					move_uploaded_file($_FILES["imagen2"]["tmp_name"], './incidentes/'.$name );						

					$config['image_library'] = 'GD2';   // libreria a utilizar
					$config['source_image'] = './incidentes/'.$name;  // imagen fuente, aqui se debe colocar la ruta completa del archivo en el servidor tomando como referencia la raíz del sitio (ejemplo ./uploads/)
					$config['width'] =  1024;          // ancho de la imagen a generar
					$config['height'] = 768;          // alto de la imagen a generar
					$config['maintain_ratio'] = TRUE;
					$config['create_thumb'] = FALSE;     // especificar que se quiere generar un thumbnail
					$this->load->library('image_lib', $config); 
					$this->image_lib->resize();         // crear thumbnail	
					$_POST['imagen']=$name;  	///die();	
				}else{
					$_POST['imagen']='no_subio.png';
				}

				// Load model
				$this->load->model( array('incidencia', 'contactos') );
				$contacto= $this->contactos->id($this->login[0]['id_contacto']);
				$_POST['id_cliente'] = $contacto[0]['id_cliente'];
				$_POST['id_contacto']= $this->login[0]['id_contacto'];
				if( $this->incidencia->crear( $this->input->post()) == true ){			
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
					$this->session->set_flashdata( 'message', $message );	
					redirect( '/clientes/ver_incidente', 'refresh' );
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
					$this->session->set_flashdata( 'message', $message );
					redirect( '/clientes/ver_incidente', 'refresh' ); 
					
				}
			}
		}
		
		// Load model
		$this->load->model( array( 'categorias', 'areas', 'usuarios','causas','estados' ) );
		$usuario= $this->usuarios->entrar_cliente($this->login[0]['id_contacto']);
		
		
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/themes/base/jquery-ui.css" />',
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				'<link type="text/css" rel="stylesheet" href="'.base_url().'style/summernote/summernote.css" media="screen"/>',
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/summernote/summernote.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',				
				'<script type="text/javascript" src="'.base_url().'scripts/clientes/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#detalle").summernote({
							height: "300",
					        toolbar: [
					  		    ["style", ["bold", "italic","underline","clear"]],
					  		    ["para", ["ul","ol"]]
					        ]
						});
					});
				</script>'
			),
			'usuario'=>$usuario,
			'categorias' => $this->categorias->all(),
			'areas' => $this->areas->all(),
			'causas' => $this->causas->all(),
			'condicion' => $this->estados->all2(),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'clientes/incidente/crear_nuevo'
			
	    );
		
		$this->load->view( 'includes/include_cliente', $this->view );
	    
	}


/*
===================================
	Ajax request
=================================== */		
	public function subcategorias(){
		
		if( empty( $_POST ) ) return false;
		
		// Load model 
		$this->load->model( 'subcategorias' );
		
		$this->data = $this->subcategorias->categoria( $this->input->post( 'categoria' ) );
		
		if( empty( $this->data ) ) return false;
		
		$options='<option value="">Seleccione...</option>';
		
		foreach( $this->data as $value ){
			$options .= '<option value="'.$value['id'].'">'.$value['opcion'].'</option>';
		}
		
		echo $options;
		
		unset( $options, $this->data );
		
		
	}	
	
	public function imagen_incidencia($id= null){
		
		// Load model 
		$this->load->model( 'incidencia' );
		
		$imagen=$this->incidencia->imagen($this->input->post( 'imagen' ));
		
		echo json_encode( $imagen[0]['imagen']) ;		
	}	
	
/*
===================================
	Validaciones
=================================== */	
	public function _alfanumeric( $value = null ){
		
		if( empty( $value ) ) return false;
		 if( !preg_match("/[a-zA-Z0-9 áéíóúñ\.]+[a-zA-Z0-9 áéíóúñ\.]/", $value ) )
      		return false;
		else
			return true;
	
	
	}
	
	public function _nit( $value = null ){
		
		if( empty( $value ) ) return false;
		
		 if( !preg_match("/[0-9\.\-]+[0-9\.\-]/", $value ) )
      		return false;
		else
			return true;
	
	
	}	
	
	public function _phone( $value = null ){
		
		if( empty( $value ) ) return false;
		 if( !preg_match("/[0-9\-\s]/", $value ) )
      		return false;
		else
			return true;
	
	
	}	
/*
===================================
	Reportes
=================================== */	

	public function reportes(){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 3 and $this->login[0]['estado'] != 1 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/', 'refresh' );
		
		}
		
		//Load model
		$this->load->model( array( 'incidencia', 'usuarios' ));
		$usuario= $this->usuarios->entrar_cliente($this->login[0]['id_contacto']);
		$cliente= $this->contactos->id($this->login[0]['id_contacto']);
		
		$datos=$this->incidencia->cliente_contacto($cliente[0]['id_cliente']);
		
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools.css" type="text/css" />',
				'<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools_JUI.css" type="text/css"/>',
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.min.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/date.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/imprimir.js"></script>',
			),
			'usuario'=>$usuario,
			'data' => $datos,
			'login' => $this->login,
			'section' => 'ver',
			'cliente'=>$cliente[0]['id_cliente'],
			'content' => 'clientes/incidente/reportes'
			
	    );
		
		$this->load->view( 'includes/include_cliente', $this->view );
	  
	
	}
	
	public function reporte_print( $incidencia = null, $type = 'xls'){

        // Cargar modelo de datos
		$this->load->model( 'incidencia' );
		$this->load->model( 'notas' );
		$this->load->model( 'contactos' );
		
		// Load Library
		$this->load->library( array('fpdf', 'exp')); 
		
				
		if( !empty( $incidencia ) ){
	
			$this->data = $this->incidencia->id( $incidencia );
			$this->date = $this->notas->incidencia($incidencia);
			$contacto= $this->contactos->cliente2($this->data[0]['id_cliente']);
			$file = $this->exp->onlyExport( $this->data,$this->date);			
		}
		
		if(!empty( $_POST)){
			
			$this->data = $this->incidencia->id($incidencia);	
			$file = $this->exp->fullExport($this->data);	
			$type = $this->input->post( 'type' );
			
		}
			
		// Impresion en excel 
		if( $type  == 'xls' ) {
		
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=downloaded.xls" );
			
			echo $file;
			
		}
		
		
		// Impresion en pdf 
		if( $type  == 'pdf' ) {
			
			$this->fpdf->FPDF('L','mm','Legal');
			$this->fpdf->AddPage('L','Legal');
			$this->fpdf->AliasNbPages();

			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(15,10,'Codigo',1,0,	'C');
			$this->fpdf->Cell(20,10,'Estado',1,0,'C');
			$this->fpdf->Cell(40,10,'Cliente',1,0,'C');
			$this->fpdf->Cell(20,10,'Prioridad',1,0,'C');
			$this->fpdf->Cell(40,10,'Asunto',1,0,'C');
			$this->fpdf->Cell(100,10,'Detalle',1,0,'C');
			$this->fpdf->Cell(40,10,'Empresa',1,0,'C');
			$this->fpdf->Cell(30,10,'Fecha',1,0,'C');
			$this->fpdf->Cell(30,10,'Fecha de cierre',1,0,'C');
			$this->fpdf->Ln();
			if(!empty($this->data)){
				$this->fpdf->SetWidths(array(15,20,40,20,40,100,40,30,30));
				$this->fpdf->Row(array($this->data[0]['id_incidencia'],$this->data[0]['estado'],utf8_decode($contacto[0]['nombre']),utf8_decode($this->data[0]['condicion']),
							utf8_decode($this->data[0]['asunto']),strip_tags(utf8_decode($this->data[0]['detalle'])),
							utf8_decode($this->data[0]['cliente']),$this->data[0]['fecha'],$this->data[0]['fecha_final']));
			}else{
				$this->fpdf->SetWidths(array(280));
				$this->fpdf->Row(array("NO HAY DATOS EN LA TABLA"));
			}
			$this->fpdf->Ln();
			$this->fpdf->Ln();
			$this->fpdf->Ln();
			$this->fpdf->Ln();
			$this->fpdf->Cell(100,10,'Fecha de nota',1,0,'C');
			$this->fpdf->Cell(117,10,'Nota',1,0,'C');
			$this->fpdf->Cell(117,10,'Usuario',1,0,'C');
			$this->fpdf->Ln();
			if(!empty($this->date) ){
				$this->fpdf->SetWidths(array(100,117,117));
				foreach ($this->date as $fila){
                	$this->fpdf->Row(array($fila['fecha'],strip_tags(utf8_decode($fila['notas'])),$fila['contacto'].$fila['ingeniero']));               
            	}
			}else{
				$this->fpdf->SetWidths(array(334));
				$this->fpdf->Row(array("NO HAY DATOS EN LA TABLA"));
			}
			$this->fpdf->output();
		}
	}
	
	
	public function reporte_print2( $incidencia = null, $type = 'xls'){

            // Cargar modelo de datos
		$this->load->model( 'incidencia' );
		
		// Load Library
		$this->load->library( array('fpdf', 'exp2')); 
		
				
		if( !empty( $incidencia ) ){
	
			$this->data = $this->incidencia->id3( $incidencia );
			$file = $this->exp2->onlyExport( $this->data );	
		}
		
		// Impresion en excel 
		if( $type  == 'xls' ) {
		
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=downloaded.xls" );
			
			echo $file;
			
		}

		// Impresion en pdf 
		if( $type  == 'pdf' ) {
			$this->fpdf->FPDF('L','mm','Legal');
			$this->fpdf->AddPage('L','Legal');
			$this->fpdf->AliasNbPages();
			$this->fpdf->SetFont('Arial','B',11);
			$this->fpdf->SetWidths(array(16,20,30,20,30,75,40,23,23,60));
			$this->fpdf->Row(array('Codigo','Estado','Ingeniero','Prioridad','Categoria','Detalle','Asunto del Caso','Fecha','Fecha Final','Notas del Caso(Solucion)'));
			$this->fpdf->SetWidths(array(16,20,30,20,30,75,40,23,23,60));
			$total=count($this->data);
			
			for ($i=0; $i <$total ; $i++) 
			{
   				$this->fpdf->Row(array($this->data[$i]['id_incidencia'],$this->data[$i]['nombre_estado'],utf8_decode($this->data[$i]['nombre']),utf8_decode($this->data[$i]['descripcion']),
   								utf8_decode($this->data[$i]['opcion']),strip_tags(utf8_decode($this->data[$i]['detalle'])),strip_tags(utf8_decode($this->data[$i]['asunto'])),
   								$this->data[$i]['fecha'],$this->data[$i]['fecha_final'],strip_tags(utf8_decode($this->data[$i]['notas']))));
			}

			$this->fpdf->output();
			
		}	
	}		
}

?>