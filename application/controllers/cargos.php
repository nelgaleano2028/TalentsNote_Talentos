<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cargos extends CI_Controller
{
	public $data=array();
	public $view=array();
	public $login=array();
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
		$this->load->model( 'cargo' );
		
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
			'content' => 'admin/cargos/listar',
			'data' => $this->cargo->all()
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
	
	
	public function crear()
	{
		if(!empty($_POST ))
		{
			
			//configurar reglas de validacion
			$this->form_validation->set_rules('nombre_cargo','Nombre del cargo','trim|required|xss_clean|callback__caracteres');
			
			//configurar mensaje de error
			$this->form_validation->set_message('required','El campo %s esta vacío...');
			
			if($this->form_validation->run() == false)
			{
				$errores = array(
					'nombre'=>form_error('nombre_cargo')
				);
				$this->session->set_flashdata('errores',$errores);	
				redirect('cargos');
			}
			else
			{
				//cargar modelo de datos
				$this->load->model('cargo');
				
				if($this->cargo->crear( $this->input->post())== true )
				{
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
					
					$this->session->set_flashdata( 'message', $message);
					
					redirect('cargos','refresh');
				}
				else
				{
					$message=array(
						'type'=>'failure',
						'text'=>'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde'
					);
					
					$this->session->set_flashdata('message',$message);
					
					redirect('cargos','refresh');
				}
			}
		}
		//configurar vista
		$this->view=array(
			'title'=>'Talents Note',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'admin/cargos/crear'
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
	
	
	
	public function editar($id=null)
	{
		//validaciones
		if(empty( $id ) or !is_numeric( $id ))
		{
			$message=array(
				'type'=>'warning',
				'text'=>'El registro no existe.'
			);
		}
		
		
		//cargar el modelo de datos
		$this->load->model( 'cargo' );
		
		$this->data=$this->cargo->id( $id );
		
		if(empty($this->data))
		{
			$message=array(
				'type'=>'warning',
				'text'=>'El registro no existe.'
			);
			
			redirect('/cargos','refresh');
		}
		
		if(!empty( $_POST ))
		{
			
			//Configurar reglas de validacion
			$this->form_validation->set_rules('nombre_cargo','Nombre del cargo','trim|required|xss_clean|callback__caracteres');
			
			//configurar mensajes de error
			$this->form_validation->set_message('required','El campo %s esta vacío....');
			
			if($this->form_validation->run() == false){
				$errores = array(
					'nombre'=>form_error('nombre_cargo'));
				$this->session->set_flashdata('errores', $errores );	
				redirect('cargos/editar/'.$id);
			}
			else
			{

				if($this->cargo->editar( $id , $this->input->post() ) == true )
				{
					$message=array(
						'type'=>'success',
						'text'=>'El registro se ha guardado correctamente'
					);
					
					$this->session->set_flashdata( 'message', $message );
					
					redirect('/cargos','refresh');
				}
				else
				{
					$message=array(
						'type'=>'failure',
						'text'=>'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde'
					);
					
					$this->session->set_flashdata( 'message', $message );
					
					redirect('/cargos','refresh');
				}
			}
			
			
		}
		
		//configurar vista
		$this->view=array(
			'title'=>'Talents Note',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'data'=>$this->data,
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'admin/cargos/editar'
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
			
			redirect( '/cargos', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'cargo' );
		$this->data=$this->cargo->id($id);
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/cargos', 'refresh' ) ;
		}
		
		if($this->cargo->eliminar($id)==true){
			
			$message = array(
				'type' => 'success',
				'text' => 'El registro se elimino correctamente.' 
			);
										
			$this->session->set_flashdata( 'message', $message );	
									
					
			redirect( '/cargos', 'refresh' );
		
		}else{
			
			$message = array(
				'type' => 'failure',
				'text' => 'Ha ocurrido un error no se puede eliminar el registro. Esta asociado a un ingeniero.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
								
			redirect( '/cargos', 'refresh' ); 
			
		}
		
	
	}
	
	
	//validaciones
	public function _caracteres( $value = null )
	{
			
			if( empty( $value ) ) return false;
			
			 if( !preg_match("/[a-zA-Z áéíóúñ\.\-]+[a-zA-Z áéíóúñ\.\-]/", $value ) )
				return false;
			else
				return true;
		
		
	}	
}