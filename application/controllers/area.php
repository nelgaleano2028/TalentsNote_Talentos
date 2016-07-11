<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area extends CI_Controller{	
	
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
		$this->load->model( 'areas' );
		
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
				'<script type="text/javascript">
					$(document).ready(function(){
						setTimeout(function() {
					        $("#men").fadeOut("slow");
						}, 4000);
					});
				</script>'
			),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'admin/area/listar',
			'data' => $this->areas->all()
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
			
	public function crear(){
			
		if( !empty( $_POST ) ){ 	
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nombre_area', 'Nombre', 'trim|required|xss_clean|callback__alfanumeric');
			// Configurar mensajes de error
			$this->form_validation->set_message('_alfanumeric', 'El Campo %s tiene valores invalidos...');
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('nombre_area')
				);
				$this->session->set_flashdata('errores',$errores);	
				redirect('area');
			
			}else{
						
				// Cargar modelo de datos
				$this->load->model( 'areas' );
				
				if( $this->areas->crear( $this->input->post() ) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( 'area', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
						
					$this->session->set_flashdata( 'message', $message );
								
					redirect( 'area', 'refresh' ); 
					
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
				'<script type="text/javascript" src="'.base_url().'scripts/area/file.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
			),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'admin/area/crear',
			
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
			redirect( '/area', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'areas' );
		$this->data = $this->areas->id( $id );
		if(empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);	
			redirect( '/area', 'refresh' ) ;
		}

		if($_POST){ 
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nombre_area', 'Nombre', 'trim|required|xss_clean');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ($this->form_validation->run() == FALSE ){

				$errores = array(
					'nombre'=>form_error('nombre_area')
					);
				$this->session->set_flashdata('errores', $errores);	
				redirect('area/editar/'.$id);		
				
			}else{
									
				if($this->areas->editar($id,$this->input->post())){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
					$this->session->set_flashdata( 'message', $message );	
					redirect( '/area', 'refresh' );							
				}else{
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
					$this->session->set_flashdata( 'message', $message );
					redirect( '/area', 'refresh' ); 
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
			'section' => 'lista',
			'content' => 'admin/area/editar',
			
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
			
			redirect( '/area', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'areas' );
		
		$this->data = $this->areas->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/area', 'refresh' ) ;
		}
		
		if( $this->areas->eliminar( $id ) == true ){
			
			$message = array(
				'type' => 'success',
				'text' => 'El registro se elimino correctamente.' 
			);
										
			$this->session->set_flashdata( 'message', $message );	
									
					
			redirect( '/area', 'refresh' );
		
		}else{
			
			$message = array(
				'type' => 'failure',
				'text' => 'Ha ocurrido un error no se puede eliminar el registro. Intentalo mas tarde.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
								
			redirect( '/area', 'refresh' ); 
			
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