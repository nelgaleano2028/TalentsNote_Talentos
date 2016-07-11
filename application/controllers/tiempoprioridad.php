<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiempoprioridad extends CI_Controller{
	
	public $view = array();
	public $login = array();	
	public $data = array();	
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
			redirect( '/admin/', 'refresh' );
		}
	}
	
	
	public function index(){
		
		// Load Model
		$this->load->model( 'tiempoprioridads' );
		$this->load->model( 'cliente' );		
		$this->load->model( 'condiciones' );		
		$this->view = array(
			
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
				'<script type="text/javascript" language="javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" language="javascript" src="'.base_url().'scripts/datatable.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/tiempoprioridad/file.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'data' => $this->tiempoprioridads->all(),
			'login' => $this->login,
			'section' => 'ver',
			'condicion' => $this->condiciones->datos(),
			'cliente' => $this->cliente->tiempoprioridad(),
			'content' => 'admin/timeprioridad/listar'
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	    
	}
	
	public function crear(){
		
		
		if( !empty( $_POST ) ){
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('id_condicion', 'Prioridad', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_cliente', 'Prioridad', 'trim|required|xss_clean');
			$this->form_validation->set_rules('horas', 'Prioridad', 'trim|required|xss_clean|integer');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('integer', 'El Campo %s no es valido...');
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('id_condicion'),
			        'cli'=>form_error('id_cliente'),
			        'hora'=>form_error('horas')
					);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('tiempoprioridad');
			
			}else{
				
				// Load Model
				$this->load->model( 'tiempoprioridads' );
			
				if( $this->tiempoprioridads->crear( $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/tiempoprioridad', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/tiempoprioridad', 'refresh' ); 
					
				}
			
			}
			
		}
		// Load model
		$this->load->model( 'cliente' );
		$this->load->model( 'condiciones' );
		
		$this->view = array(
			
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',

				),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'cliente' => $this->cliente->tiempoprioridad(),
			'condicion' => $this->condiciones->datos(),
			'login' => $this->login,
			'section' => 'ver',
			'content' => 'admin/timeprioridad/crear'
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	    
	}
	
	public function editar( $id = null ){
		
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'failure',
				'text' => 'No existe el registro.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
			
			redirect( '/tiempoprioridad', 'refresh' );  
		
		}
		
		// Load Model
		$this->load->model( 'tiempoprioridads' );
		
		$this->data = $this->tiempoprioridads->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'failure',
				'text' => 'No existe el registro.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
			
			redirect( '/tiempoprioridad', 'refresh' );  
		
		}
		
		
		if( !empty( $_POST ) ){
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('id_condicion', 'Prioridad', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_cliente', 'Prioridad', 'trim|required|xss_clean');
			$this->form_validation->set_rules('horas', 'Prioridad', 'trim|required|xss_clean|integer');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('integer', 'El Campo %s no es valido...');
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('id_condicion'),
			        'cli'=>form_error('id_cliente'),
			        'hora'=>form_error('horas')
					);
				$this->session->set_flashdata('errores', $errores);	
				redirect('tiempoprioridad/editar/'.$id);	
			
			}else{
				
				
			
				if( $this->tiempoprioridads->editar( $id, $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/tiempoprioridad', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/tiempoprioridad', 'refresh' ); 
					
				}
			
			}
			
		}

		// Load model
		$this->load->model( 'cliente' );
		$this->load->model( 'estados' );
		
		$this->view = array(
			
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'data' => $this->data,
			'cliente' => $this->cliente->tiempoprioridad(),
			'condicion' => $this->estados->all2(),
			'login' => $this->login,
			'section' => 'ver',
			'content' => 'admin/timeprioridad/editar'
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	  
	}
	
	public function eliminar( $id = null ){
		
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'failure',
				'text' => 'No existe el registro.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
			
			redirect( '/tiempoprioridad', 'refresh' );  
		
		}
		
		// Load Model
		$this->load->model( 'tiempoprioridads' );
		
		$this->data = $this->tiempoprioridads->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'failure',
				'text' => 'No existe el registro.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
			
			redirect( '/tiempoprioridad', 'refresh' );  
		
		}
		
		if( $this->tiempoprioridads->eliminar( $id ) == true ){			
				
			$message = array(
					'type' => 'success',
					'text' => 'El registro se elimino correctamente.' 
			);
								
			$this->session->set_flashdata( 'message', $message );	
							
			
			redirect( '/tiempoprioridad', 'refresh' );
										
		}else{
		
			$message = array(
					'type' => 'failure',
					'text' => 'Ha ocurrido un error no se puede eliminar el registro. Intentalo mas tarde.'	
			);
				
			$this->session->set_flashdata( 'message', $message );
						
			redirect( '/tiempoprioridad', 'refresh' ); 
			
		}
		
		
	}
	
}
?>