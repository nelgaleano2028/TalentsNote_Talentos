<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Usuario extends CI_Controller{
	
	
	public $view = array();
	public $login = array();
	public $data = array();	
	public function __construct(){ 	
		parent::__construct(); 
		
		// Permisos
		$this->login = $this->session->userdata( 'login' );
		
	}	

/*
===========================
	LOGIN
=========================== */	
	public function login(){
		
		if( !empty( $_POST ) ){
	
			// Configurar Reglas de validación
			$this->form_validation->set_rules('username', 'Usuario', 'trim|required|xss_clean|_alfanumeric');
			$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean');
						
			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			 $this->form_validation->set_message('_alfanumeric', 'Valor alfanúmerico invalido...');							
			
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('username'),
			        'clave'=>form_error('password')
					);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('ingeniero/perfil_ingeniero/'.$id);
			
			}else{
				
				// Load Model
				$this->load->model( 'usuarios' );
				
				$this->data = $this->usuarios->login( $this->input->post());

				if(empty($this->data)){
					
					$message = array(
							'type' => 'failure',
							'text' => 'Usuario o Contraseña invalido' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
					redirect( '/usuario/login'); 
				}

				$this->data = array('login'=>$this->data);
				$this->session->set_userdata($this->data );
				redirect( '/admin/', 'refresh' ); 
					
			}
			
		}

		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/login.css" type="text/css" />'
			),
			'scripts'=>array(				
			),
			'content'=>'login',
			'login'=>$this->login
	    );
		
		$this->load->view('includes/include_u', $this->view);
		
	}
	
	
	public function recuperar(){
		
		if( !empty( $_POST ) ){
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('username', 'Usuario', 'trim|required|xss_clean|_alfanumeric');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			$this->form_validation->set_message('_alfanumeric', 'Valor alfanúmerico invalido...');
			
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('username')
				);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('usuario/recuperar/'); 
			}else{
				
				// Load Model
				$this->load->model( 'usuarios' );
				
				if($this->usuarios->ver_usuario( $_POST['username'] ) == False){
					
					$message = array(
							'type' => 'failure',
							'text' => 'Los datos son incorrectos intentalo de nuevo.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
					
					redirect( '/usuario/login', 'refresh' ); 
					
					
				}else{
					
					$message = array(
							'type' => 'success',
							'text' => 'Enviamos un mensaje a su correo.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
					
					redirect( '/usuario/login', 'refresh' );      
				} 
				
			}
			
		}
			
	}
	
	public function cambiar_contadmin(){
		
		if( !empty( $_POST ) ){
			$this->form_validation->set_rules('contrasena_original', 'Contrasena antigua', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('contrasena', 'Nueva contrasena', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('re_contrasena', 'Repetir contrasena', 'trim|required|xss_clean|callback__alfanumeric');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			$this->form_validation->set_message('_alfanumeric', 'Valor alfanúmerico invalido...');
			
			if ( $this->form_validation->run() == FALSE ){
				
			}else{
				$this->load->model( 'usuarios' );
				
				if( $this->usuarios->contrasena_admin($this->input->post('contrasena_original'))== false){
				
					$message = array(
								'type' => 'failure',
								'text' => 'La contraseña anterior no es valida intentelo de nuevo' 
						);
											
						$this->session->set_flashdata( 'message', $message );	
										
						
						redirect( '/usuario/cambiar_contadmin/', 'refresh' );
				
				}
				if( $this->usuarios->editar_admin($this->input->post() ) == true ){
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/usuario/cambiar_contadmin/', 'refresh' );
											
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/usuario/cambiar_contadmin/', 'refresh' ); 
					
				}
			}
		}
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'login' => $this->login,
			'section' => 'nuevo',
			'content' => 'admin/usuario/cambiar_contrasena',
				    
		);
		
		$this->load->view( 'includes/include', $this->view );
			
	}
	
	public function logout(){
		
		
		// REMOVE SESSION	

        $this->session->unset_userdata( 'login' );
		$this->session->unset_userdata( 'id_usuario' );
		$this->session->unset_userdata( 'id_contacto' );
		$this->session->unset_userdata( 'id_empresa' );
		$this->session->unset_userdata( 'id_perfil' );
		$this->session->unset_userdata( 'id_ingeniero' );
		$this->session->unset_userdata( 'Usuario' );
		$this->session->sess_destroy();
		redirect('/usuario/login','refresh');
		
	}
	
	public function index(){
		
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 1 ){
			redirect('/usuario/login','refresh');
		
		}
		
		// Load Model
		$this->load->model( 'usuarios' );		
		$this->load->model( 'perfiles' );		
		
		$this->view = array(
			
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.min.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>'
			),
			'scripts'=>array(
				
				'<script type="text/javascript" src="'.base_url().'scripts/datatable.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'				
			),
			'login' => $this->login,
			'section' => 'nuevo',
			'content' => 'admin/usuario/listar',
			'data' => $this->usuarios->all()
	    
		);
		
		$this->load->view( 'includes/include', $this->view );
	}

	public function vistarecordar(){
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/login.css" type="text/css" />'
			),
			'scripts'=>array(				
			),
			'content'=>'recordar',
			'login'=>$this->login
	    );
		$this->load->view('includes/include_u', $this->view);
	}
	
	public function crear_cliente(){
		
		if( empty( $this->login ) ) redirect( '/usuario/login', 'refresh' );
		
		if( $this->login[0]['id_perfil'] != 1 ){
			$message = array(
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			);
			redirect( '/admin/', 'refresh' );
		}
		
		if( !empty( $_POST ) ){ 
	
			// Configurar Reglas de validación
			$this->form_validation->set_rules('Usuario', 'Usuario', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean');
			
			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			 $this->form_validation->set_message('_alfanumeric', 'Valor alfanúmerico invalido...');							
			
			
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('Usuario'),
			        'clave'=>form_error('password'),
				);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('usuario/crear_cliente/'); 
			
			}else{
		
				$_POST['contraseña'] = $this->input->post( 'password' );
				unset( $_POST['password'] );
												
				// Cargar modelo de datos
				$this->load->model( 'usuarios' );
				
				if($this->usuarios->crear( $this->input->post() ) == true ){			
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
					redirect( '/usuario/', 'refresh' );
												
				}else{
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
					$this->session->set_flashdata( 'message', $message );
					redirect( '/usuario/', 'refresh' ); 
					
				}
			}
		}
		// Cargar modelos de datos
		$this->load->model( array( 'contactos') );
				
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(

				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/usuario/file_cliente.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
			),
			'contacto' => $this->contactos->usuario(),
			'login' => $this->login,
			'section' => 'nuevo',
			'content' => 'admin/usuario/crear_cliente',
				    
		);
		
		$this->load->view( 'includes/include', $this->view );
	   	
		
	}
	
	public function crear_ingeniero(){
		
		if( empty( $this->login ) ) redirect( '/usuario/login', 'refresh' );
		
		if( $this->login[0]['id_perfil'] != 1 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/', 'refresh' );
		
		}
		
		if( !empty( $_POST ) ){ 
						
			// Configurar Reglas de validación
			$this->form_validation->set_rules('Usuario', 'Usuario', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean');
			
			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			 $this->form_validation->set_message('_alfanumeric', 'Valor alfanúmerico invalido...');							
			
			
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('Usuario'),
			        'clave'=>form_error('password'),
					);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('usuario/crear_ingeniero/');  
			
			}else{
				
				$_POST['contraseña'] = $this->input->post( 'password' );
				unset( $_POST['password'] );
												
				// Cargar modelo de datos
				$this->load->model( 'usuarios' );
				
				if( $this->usuarios->crear( $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/usuario/', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/usuario/', 'refresh' ); 
					
				}
					
			}
					
		}
		// Cargar modelos de datos
		$this->load->model( array( 'ingenieros') );
				
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
			'ingenieros' => $this->ingenieros->usuario(),
			'login' => $this->login,
			'section' => 'nuevo',
			'content' => 'admin/usuario/crear_ingeniero',
				    
		);
		
		$this->load->view( 'includes/include', $this->view );
	   	
		
	}
	
	public function editar( $id = null ){
		
		if( empty( $this->login ) ) redirect( '/usuario/login', 'refresh' );
		
		if( $this->login[0]['id_perfil'] != 1 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/welcome/', 'refresh' );
		
		}
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/usuario/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'usuarios' );
		
		$this->data = $this->usuarios->id($id);
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/usuario/', 'refresh' ) ;
		}
		
		
		
		if( !empty( $_POST ) ){ 
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('Usuario', 'Usuario', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_perfil', 'Perfil', 'trim|required|xss_clean');
			
			// Configurar mensajes de error
		    $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			$this->form_validation->set_message('_alfanumeric', 'Valor alfanúmerico invalido...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('Usuario'),
			        'clave'=>form_error('password'),
			        'perfil'=>form_error('id_perfil')
				);
				$this->session->set_flashdata('errores', $errores);	
				redirect('usuario/editar/'.$id);	
			
			}else{
				
				$_POST['contraseña'] = $this->input->post('password');
				unset( $_POST['password'] );							
				if($this->usuarios->editar($id,$this->input->post())){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata('message',$message );	
									
					
					redirect( '/usuario/', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/usuario/', 'refresh' ); 
					
				}
				
				
					
			}
			
		}
		
		// Cargar modelos de datos
		$this->load->model( array( 'contactos', 'empresa', 'ingenieros', 'perfiles' ) );
		
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
			'contacto' => $this->contactos->usuario(),
			'empresa' => $this->empresa->usuario(),
			'ingenieros' => $this->ingenieros->usuario(),
			'perfiles' => $this->perfiles->usuario(),
			'login' => $this->login,
			'section' => 'nuevo',
			'content' => 'admin/usuario/editar',
				    
		);
		
		$this->load->view( 'includes/include', $this->view );
	  		
	
	}
	
	public function eliminar( $id = null ){
		
		if( empty( $this->login ) ) redirect( '/usuario/login', 'refresh' );
		
		if( $this->login[0]['id_perfil'] != 1 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/welcome/', 'refresh' );
		
		}
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/usuario/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'usuarios' );
		
		$this->data = $this->usuarios->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/usuario/', 'refresh' ) ;
		}
		
		if( $this->usuarios->eliminar( $id ) == true ){
			
			$message = array(
				'type' => 'success',
				'text' => 'El registro se elimino correctamente.' 
			);
										
			$this->session->set_flashdata( 'message', $message );	
									
					
			redirect( '/usuario/', 'refresh' );
		
		}else{
			
			$message = array(
				'type' => 'failure',
				'text' => 'Ha ocurrido un error no se puede eliminar el registro. Intentalo mas tarde.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
								
			redirect( '/usuario/', 'refresh' ); 
			
		}
		
	
	}	
	
	// Validaciones
	public function _alfanumeric( $value = null ){
		
		if( empty( $value ) ) return false;
		
		 if( !preg_match("/[a-zA-Z0-9 áéíóúñ\.]+[a-zA-Z0-9 áéíóúñ\.]/", $value ) )
      		return false;
		else
			return true;
	
	
	}
	
	public function _telefono( $value = null ){
		
		if( empty( $value ) ) return false;
		
		 if( !preg_match("/[0-9\-\s]+/", $value ) )
      		return false;
		else
			return true;
	
	
	}
	
		
}
?>