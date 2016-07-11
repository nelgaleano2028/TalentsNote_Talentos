<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto extends CI_Controller{
	
	
	public $view = array();
	public $login = array();	
	public $data = array();	
	public $mobile = true;	
	public function __construct(){ 
		
		parent::__construct(); 
				
		// Permisos
		$this->login = $this->session->userdata( 'login' );		
		if( empty( $this->login ) ) redirect( '/usuario/login', 'refresh' );		
		if( $this->login[0]['id_perfil'] != 1 ){					
			$message = array(
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			);						
			redirect( '/admin/welcome/', 'refresh' );		
		}
				
	}	
	
	public function index(){
		
		$this->load->model('contactos');
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
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'),
			'login' => $this->login,
			'section' => 'inicio',
			'cliente' => $this->cliente->all(),
			'content'=>'admin/contacto/listar',
			'data' => $this->contactos->all()
	    );		
			$this->load->view( 'includes/include', $this->view);
		
	}
	
	public function crear(){
		
		if( !empty( $_POST ) ){ 
						
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('id_cliente', 'Cliente', 'trim|required|xss_clean');
			$this->form_validation->set_rules('correo', 'Correo', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('telefono', 'Telefono', 'trim|required|callback__telefono');
			
			
			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			 $this->form_validation->set_message('valid_email', 'Correo invalido...');	
			 $this->form_validation->set_message('_telefono', 'El campo %s Teléfono invalido...');							
			 $this->form_validation->set_message('_alfanumeric', 'El campo %s No es alfanumerico...');							
			
			
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('nombre'),
			        'apellido'=>form_error('apellido'),
			        'cliente'=>form_error('id_cliente'),
			        'correo'=>form_error('correo'),
			        'tel'=>form_error('telefono')
					);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('contacto/');
			
			}else{
				
				
				// Cargar modelo de datos
				$this->load->model( 'contactos' );
				
				if( $this->contactos->crear( $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/contacto/', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/contacto/', 'refresh' ); 
					
				}
				
				
					
			}
					
		}
		
		// cargar modelo de datos
		$this->load->model( 'cliente' );
		
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
			'login' => $this->login,
			'cliente' => $this->cliente->all(),
			'section' => 'inicio',
			'content' => 'admin/contacto/crear',
			

	    );
		
		$this->load->view( 'includes/include', $this->view );
		
		
	}
	
	public function editar( $id = null ){
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/contacto/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'contactos' );
		
		$this->data = $this->contactos->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/contacto/', 'refresh' ) ;
		}
		
		
		
		if( !empty( $_POST ) ){ 
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('id_cliente', 'Cliente', 'trim|required|xss_clean');
			$this->form_validation->set_rules('correo', 'Correo', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('telefono', 'Telefono', 'trim|required|callback__telefono');
			
			
			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			 $this->form_validation->set_message('valid_email', 'Correo invalido...');	
			 $this->form_validation->set_message('callback__telefono', 'Teléfono invalido...');	
									
			if ( $this->form_validation->run() == FALSE ){
					$errores = array(
					'nombre'=>form_error('nombre'),
			        'apellido'=>form_error('apellido'),
			        'cliente'=>form_error('id_cliente'),
			        'correo'=>form_error('correo'),
			        'tel'=>form_error('telefono')
					);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('contacto/editar/'.$id);
			
			}else{
							
				if( $this->contactos->editar_admin( $id, $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/contacto/', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/contacto/', 'refresh' ); 
					
				}
			}
		}
		
		// cargar modelo de datos
		$this->load->model( 'cliente' );
		
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
			'content'=>'admin/contacto/editar',
			'cliente' => $this->cliente->all()
	    );
		
		$this->load->view( 'includes/include', $this->view);
		
	
	}
	
	public function eliminar( $id = null ){
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/contacto/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'contactos' );
		
		$this->data = $this->contactos->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/contacto/', 'refresh' ) ;
		}
		
		if( $this->contactos->eliminar( $id ) == true ){
			
			$message = array(
				'type' => 'success',
				'text' => 'El registro se elimino correctamente.' 
			);
										
			$this->session->set_flashdata( 'message', $message );	
									
					
			redirect( '/contacto/', 'refresh' );
		
		}else{
			
			$message = array(
				'type' => 'failure',
				'text' => 'Ha ocurrido un error no se puede eliminar el registro. Intentalo mas tarde.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
								
			redirect( '/contacto/', 'refresh' ); 
			
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