<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresas extends CI_Controller{
	
	public $view=array();
	public $data=array();
	public $login=array();
	public $mobile = true;
	public function __construct(){
		
		parent::__construct();
		
		// Permisos
		$this->login = $this->session->userdata('login');
		
		if(empty($this->login)) redirect( '/usuario/login', 'refresh' );
		
		if($this->login[0]['id_perfil']!= 1){
						
			$message = array(
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			);			
			redirect( '/admin/welcome/', 'refresh' );
		}
		
	}
	
	public function index(){
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(),
			'scripts'=>array(),
			'content'=>'admin/empresas/listar'
	    );
		$this->load->view('includes/include',$this->view);
	}
	
	public function crear()
	{
		if(!empty($_POST))
		{
			//Configurar reglas de validación
			$this->form_validation->set_rules('nombre_empresa','Nombre de la empresa','trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('nit', 'Nit','trim|required|xss_clean|callback__nit');
			$this->form_validation->set_rules('telefono','Telefono','trim|required|xss_clean|callback__telefono');
			$this->form_validation->set_rules('direccion','Dirección','trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('website','Web Site','trim|required|xss_clean');
			
			//Configurar mensajes de error
			$this->form_validation->set_message('required','El campo %s esta vacío');
			
			if($this->form_validation->run()== FALSE)
			{
				//Recargar vista
				
			}
			else
			{
				//Cargar modelo de datos
				$this->load->model('empresa');
				
	
				if( $this->empresa->crear( $this->input->post() ) == true )
				{
					
					$message=array(
						'type'=>'success',
						'text'=>'El registro se ha guardado correctamente.'
					);
					
					$this->session->set_flashdata('message',$message);
					
					redirect('/empresas/','refresh');
				}
				else
				{
					$message=array(
						'type'=>'failure',
						'text'=>'Ha ocurrido un error no se puede guardar el registro. Intentelo de mas tarde'
					);
					
					$this->session->set_flashdata('message',$message);
					
					redirect('/empresas/','refresh');
				}
				
				
			}
			
		}
		//Configurar vista
		$this->view=array(
			'title'=>'talents notes',
			'css'=>array(),
			'scripts'=>array(
			  '<!-- Validator	-->',
			  '<script type="text/javascript" src="'.base_url().'scripts/jquery.validate.js"></script>',
			  '<!-- /Validator  -->',
			  '<script type="text/javascript" src="'.base_url().'scripts/empresa/file.js"></script>',
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
			  'content'=>'admin/empresas/crear'
		);
		
		
			$this->load->view( 'includes/include', $this->view);
		
	}
	
	public function editar($id= null)
	{
		//validaciones
		if(empty($id) or !is_numeric($id)){
			
			$message=array(
				'type'=>'warning',
				'text'=>'El registro no existe.'
			);
		}
		
		//cargar modelo de datos
		$this->load->model('empresa');
		
		$this->data=$this->empresa->id( $id );
		
		if(empty($this->data))
		{
			$message=array(
				'type'=>'warning',
				'text'=>'El registro no existe.'
				
			);
			
			redirect('/empresas/','refresh');
		}
		
		if(!empty( $_POST ))
		{
			//Configurar reglas de validación
			$this->form_validation->set_rules('nombre_empresa','Nombre de la empresa','trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('nit', 'Nit','trim|required|xss_clean|callback__nit');
			$this->form_validation->set_rules('telefono','Telefono','trim|required|xss_clean|callback__telefono');
			$this->form_validation->set_rules('direccion','Dirección','trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('website','Web Site','trim|required|xss_clean');
			
			//Configurar mensajes de error
			$this->form_validation->set_message('required','El campo %s esta vacío');
			
			if($this->form_validation->run()==false)
			{
				//recargar vista
			}
			else
			{
				if($this->empresa->editar( $id, $this->input->post() ) == true )
				{
					$message=array(
						'type'=>'success',
						'text'=>'el registro se guardo correctamente'
					);
					
					$this->session->set_flashdata('message',$message);
					
					redirect('/empresas/','refresh');
				}
				else
				{
					$message=array(
						'type'=>'failure',
						'text'=>'Ha currido un error no se ha podido guardar el registro. Intentalo mas tarde');
						
						$this->session->set_flashdata('message',$message);
						
						redirect('/empresas/','refresh');
				}
			}
			exit;
			
		}
		
		//configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(),
			'scripts'=>array(
			'<!--validator-->',
			'<script type="text/javascript" src="'.base_url().'scripts/jquery.validate.js"></script>',
			'<script type="text/javascript" src="'.base_url().'scripts/empresa/file.js"></script>',
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
				</script>'),
			'data'=> $this->data,
			'content'=>'admin/empresas/editar'
		);
		
		
		
			$this->load->view( 'includes/include', $this->view);
		
	
	}
	
	//validaciones
	public function _alfanumeric( $value = null )
	{
		
		if( empty( $value ) ) return FALSE;
		
		 if( !preg_match("/[a-zA-Z0-9 áéíóúñ\.]+[a-zA-Z0-9 áéíóúñ\.]/", $value ) )
      		return FALSE;
		else
			return TRUE;
	
	
	}
	
	public function _nit($value=null)
	{
		if(empty($value)) return FALSE;
		
		if(!preg_match("/[0-9\.\-]+[0-9\.\-]/",$value))
			return FALSE;
		else
			return TRUE; 
	}
	
	public function _telefono($value=null)
	{
		if(empty($value)) return FALSE;
		
		if(!preg_match("/[0-9\.\-]+[0-9\.\-]/",$value))
			return FALSE;
		else
			return TRUE;
	}
	
		
}