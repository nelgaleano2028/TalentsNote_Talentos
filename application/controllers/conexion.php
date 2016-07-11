<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conexion extends CI_Controller{
	
	
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
		$this->load->model( 'conexions' );
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>'
				
			),
			'scripts'=>array(
				
				// '<script type="text/javascript" src="'.base_url().'scripts/datatable.js"></script>',
				// '<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
				
			),
			'content'=>'admin/conexion/listar',
			'login' => $this->login,
			'section' => 'ver',
			'content' => 'admin/conexion/listar',
			'data' => $this->conexions->all()
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
					
	}
			
	public function crear(){
		
		
		if( !empty( $_POST ) ){ 
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('id_tipo_conexion', 'Detalle', 'trim|required|xss_clean');
			$this->form_validation->set_rules('detalles', 'Detalle', 'trim|required|xss_clean|callback__alfanumeric');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('callback__alfanumeric', 'El Campo %s tiene valores invalidos...');
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				//Recargar vista 
			
			}else{
							
				// Cargar modelo de datos
				$this->load->model( 'conexions' );
				
				if( $this->conexions->crear( $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/conexion/', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/conexion/', 'refresh' ); 
					
				}				
					
			}
			
			exit;
		
		}
		
		
		// Load Model
		$this->load->model( 'conexions' );
		
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(),
			'scripts'=>array(
				'<!-- Validator	-->',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.validate.js"></script>',
				'<!-- /Validator  -->',
				'<script type="text/javascript" src="'.base_url().'scripts/conexion/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
			),
			'login' => $this->login,
			'section' => 'ver',
			'content' => 'admin/conexion/crear',
			'tipo_conexion' => $this->conexions->tipo_conexion()
			
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
			
			redirect( '/conexion/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'conexions' );
		
		$this->data = $this->conexions->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/conexion/', 'refresh' ) ;
		}
		
		
		
		if( !empty( $_POST ) ){ 
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('id_tipo_conexion', 'Detalle', 'trim|required|xss_clean');
			$this->form_validation->set_rules('detalles', 'Detalle', 'trim|required|xss_clean|callback__alfanumeric');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('callback__alfanumeric', 'El Campo %s tiene valores invalidos...');
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			
			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				//Recargar vista 
			
			}else{
												
				if( $this->conexions->editar( $id, $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/conexion/', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( '/conexion/', 'refresh' ); 
					
				}
				
				
					
			}
			
			exit;
		
		}
		
		
		
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(),
			'scripts'=>array(
				'<!-- Validator	-->',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.validate.js"></script>',
				'<!-- /Validator  -->',
				'<script type="text/javascript" src="'.base_url().'scripts/conexion/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
			),
			'data' => $this->data,
			'login' => $this->login,
			'section' => 'ver',
			'content' => 'admin/conexion/editar',
			'tipo_conexion' => $this->conexions->tipo_conexion()
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	    	
	
	}
	
	public function eliminar( $id = null ){
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/conexion/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'conexions' );
		
		$this->data = $this->conexions->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/conexion/', 'refresh' ) ;
		}
		
		if( $this->conexions->eliminar( $id ) == true ){
			
			$message = array(
				'type' => 'success',
				'text' => 'El registro se elimino correctamente.' 
			);
										
			$this->session->set_flashdata( 'message', $message );	
									
					
			redirect( '/conexion/', 'refresh' );
		
		}else{
			
			$message = array(
				'type' => 'failure',
				'text' => 'Ha ocurrido un error no se puede eliminar el registro. Intentalo mas tarde.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
								
			redirect( '/conexion/', 'refresh' ); 
			
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
		
		
}
?>