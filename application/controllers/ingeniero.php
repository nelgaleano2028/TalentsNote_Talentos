<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingeniero extends CI_Controller{
	
	
	public $view = array();
	public $login = array();
	public $data = array();
	public function __construct(){ 
		
		parent::__construct(); 
						
		// Permisos
		$this->login = $this->session->userdata( 'login' );
		if(empty($this->login )) redirect('/usuario/login', 'refresh' );
		
	}	
	
	public function index(){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 1 ){		
			$message = array(			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			);			
			redirect( '/admin/', 'refresh' );
		}
		
		// Load Model
		$this->load->model( 'ingenieros' );
		$this->load->model( array( 'areas', 'epsm', 'pension', 'cesantia', 'cargo' ) );		
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
			'eps' => $this->epsm->ingeniero(),
			'pension' => $this->pension->ingeniero(),
			'cesantia' => $this->cesantia->ingeniero(),
			'cargo' => $this->cargo->ingeniero(),
			'area' => $this->areas->all(),
			'login' => $this->login,
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'admin/ingeniero/listar',
			'data' => $this->ingenieros->all()
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
				
	}
	
	
	
	public function crear(){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 1 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/', 'refresh' );
		}
		if( !empty( $_POST ) ){ 
						
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('cedula', 'Cédula', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('celular', 'Celular', 'trim|required|xss_clean|callback__telefono');
			$this->form_validation->set_rules('correo', 'Correo', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('estado_laboral', 'Estado laboral', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_eps', 'Eps', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_pensiones', 'Pensiones', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_cesantias', 'Cesantias', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_cargo', 'Cargo', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_area', 'Área', 'trim|required|xss_clean');

			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			 $this->form_validation->set_message('valid_email', 'Correo invalido...');	
			 $this->form_validation->set_message('_telefono', 'Teléfono invalido...');							
						
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
						'nombre'=>form_error('nombre'),
				        'cedula'=>form_error('cedula'),
				        'celular'=>form_error('celular'),
				        'correo'=>form_error('correo'),
				        'estado'=>form_error('estado_laboral'),
				        'eps'=>form_error('id_eps'),
				        'pension'=>form_error('id_pensiones'),
				        'cesantia'=>form_error('id_cesantias'),
				        'cargo'=>form_error('id_cargo'),
				        'area'=>form_error('id_area')
					);
				$this->session->set_flashdata('errores',$errores);	
				redirect('ingeniero');
			
			}else{
				
				// Cargar modelo de datos
				$this->load->model( 'ingenieros' );
				
				if( $this->ingenieros->crear( $this->input->post()) == true ){			
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
									
					
					redirect( '/ingeniero', 'refresh' );
												
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
					$this->session->set_flashdata( 'message', $message );
					redirect( '/ingeniero', 'refresh' ); 
				}
		
			}
		}
		
		// cargar modelo de datos
		$this->load->model( array( 'areas', 'epsm', 'pension', 'cesantia', 'cargo' ) );
		
		// Configurar vista
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
					'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(
				'<script src="//code.jquery.com/jquery-1.10.2.js"></script>',
 				'<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'eps' => $this->epsm->ingeniero(),
			'pension' => $this->pension->ingeniero(),
			'cesantia' => $this->cesantia->ingeniero(),
			'cargo' => $this->cargo->ingeniero(),
			'area' => $this->areas->all(),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'admin/ingeniero/crear'
			
	    );
		$this->load->view('includes/include', $this->view );
	    	
		
	}
	
	public function editar( $id = null ){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 1 ){
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
			redirect( '/ingeniero', 'refresh' ) ;
		}
		// Cargar modelo de datos
		$this->load->model( 'ingenieros' );
		$this->data = $this->ingenieros->id( $id );
		if( empty( $this->data ) ){ 
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			redirect( '/ingeniero', 'refresh' ) ;
		}

		if( !empty( $_POST ) ){ 
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('cedula', 'Cédula', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('celular', 'Celular', 'trim|required|xss_clean|callback__telefono');
			$this->form_validation->set_rules('correo', 'Correo', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('estado_laboral', 'Estado laboral', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_eps', 'Eps', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_pensiones', 'Pensiones', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_cesantias', 'Cesantias', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_cargo', 'Cargo', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_area', 'Área', 'trim|required|xss_clean');
			// Configurar mensajes de error
			 $this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			 $this->form_validation->set_message('valid_email', 'Correo invalido...');	
			 $this->form_validation->set_message('_telefono', 'Teléfono invalido...');	
												
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('nombre'),
			        'cedula'=>form_error('cedula'),
			        'celular'=>form_error('celular'),
			        'correo'=>form_error('correo'),
			        'estado'=>form_error('estado_laboral'),
			        'eps'=>form_error('id_eps'),
			        'pension'=>form_error('id_pensiones'),
			        'cesantia'=>form_error('id_cesantias'),
			        'cargo'=>form_error('id_cargo'),
			        'area'=>form_error('id_area')
					);
				$this->session->set_flashdata('errores',$errores);	
				redirect('ingeniero/editar/'.$id);	 
			
			}else{
												
				if( $this->ingenieros->editar_admin($id,$this->input->post())== true){			
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
					$this->session->set_flashdata( 'message', $message );						
					redirect( '/ingeniero/', 'refresh' );
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
					$this->session->set_flashdata( 'message', $message );
					redirect( '/ingeniero/', 'refresh' ); 
				}	
			}	
		}
		
		// cargar modelo de datos
		$this->load->model( array( 'areas', 'epsm', 'pension', 'cesantia', 'cargo' ) );
		
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
			'eps' => $this->epsm->ingeniero(),
			'pension' => $this->pension->ingeniero(),
			'cesantia' => $this->cesantia->ingeniero(),
			'cargo' => $this->cargo->ingeniero(),
			'area' => $this->areas->all(),
			'id' => $id,
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'admin/ingeniero/editar'
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	  				
	
	}

	public function eliminar( $id = null ){
		
		// Permisos
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
			
			redirect( '/ingeniero', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'ingenieros' );
		
		$this->data = $this->ingenieros->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/ingeniero', 'refresh' ) ;
		}
		
		if( $this->ingenieros->eliminar( $id ) == true ){
			
			$message = array(
				'type' => 'success',
				'text' => 'El registro se elimino correctamente.' 
			);
										
			$this->session->set_flashdata( 'message', $message );	
									
					
			redirect( '/ingeniero', 'refresh' );
		
		}else{
			
			$message = array(
				'type' => 'failure',
				'text' => 'Ha ocurrido un error no se puede eliminar el registro. Intentalo mas tarde.'	
			);
						
			$this->session->set_flashdata( 'message', $message );
								
			redirect( '/ingeniero', 'refresh' ); 
			
		}
		
	
	}	


/*
==============================	
	 Incidentes
============================== */	
	public function incidente_crear( $incidencia = null ){
		
		// Validaciones
		if( empty( $incidencia ) or !is_numeric( $incidencia ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/', 'refresh' ) ;
		}
		
		$this->load->model( 'ingenieros' );
		
		
		$this->data = $this->ingenieros->id( $this->login[0]['id_ingeniero'] );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/ingeniero', 'refresh' ) ;
		}
		
		if( !empty( $_POST ) ){
			// Configurar Reglas de validación
			$this->form_validation->set_rules('nota', 'Detalle', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_estado', 'Estado', 'trim|xss_clean');
			$this->form_validation->set_rules('id_condicion', 'Prioridad', 'trim|xss_clean');
			$this->form_validation->set_rules('id_area', 'Área', 'trim|xss_clean');
			$this->form_validation->set_rules('causa', 'Causa', 'trim|xss_clean');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'nombre'=>form_error('nota'),
					'estado'=>form_error('id_estado'),
					'condicion'=>form_error('id_condicion'),
					'area'=>form_error('id_area'),
					'causa'=>form_error('causa')
				);
				$this->session->set_flashdata('errores', $errores);	
				redirect('ingeniero/incidente_crear/'.$incidencia); 
			
			}else{             
				date_default_timezone_set("America/Bogota");
                // Load Model
				$this->load->model( array( 'notas', 'incidencia' ) );

				$click=$this->incidencia->vistas($incidencia);

				$nota = array(
					'id_incidencia' => $incidencia,
					'notas' => $this->input->post( 'nota' ),
					'firmausuario' => $this->login[0]['Usuario'],
					'fecha' => date('Y-m-d H-i-s', time())
				);			
				
				$update_incidencia = array(
					'id_estado' => $this->input->post( 'id_estado' ),
					'id_condicion' => $this->input->post( 'id_condicion' ),
					'causa' => $this->input->post( 'causa' )
				);
				
				if(($this->input->post('id_ingeniero'))){
					// si el ingeniero se elije asi mismo 
					if($this->login[0]['id_ingeniero'] == $this->input->post( 'id_ingeniero' ) ){
						
						$message = array(
							'type' => 'failure',
							'text' => 'Este esta caso ya ha sido asignado a usted.'	
							);
										
							$this->session->set_flashdata( 'message', $message );
							redirect('/ingeniero/incidente_crear/'.$nota['id_incidencia'],'refresh'
						);

					}
						
					if( $this->login[0]['id_ingeniero'] != $this->input->post( 'id_ingeniero' ) and $this->input->post( 'id_estado' ) !='2' ){
			
						$update_incidencia['id_ingeniero'] = $this->input->post( 'id_ingeniero' );
						$update_incidencia['id_area'] = $this->input->post('id_area');
					}
		
				}
				
				if($click==false){
					$fecha=$this->incidencia->id($incidencia);
					$arreglo= array(
						'id_incidencia' =>$this->input->post('id_incidencia22'),
						'id_ingeniero' =>$this->input->post('id_ingeniero22'),
						'fechaclick' =>$this->input->post('fechclick'),
						'click' => $this->input->post('click'),
						'empresa' => $this->input->post('id_cliente22'),
						'horas' =>$fecha[0]['fecha']
					);
					$this->incidencia->crear_vistas($arreglo);
				}

				// si el ingeniero cierra el incidente
				if($this->input->post('id_estado') == '2'){
					$update_incidencia['fecha_final']=date('Y-m-d H:i:s/a',time());
				}
				 
				if($this->incidencia->editar($incidencia,$update_incidencia)== true){
					//enviar correos
					$this->notas->crear($nota);
					$this->enviar_correo($incidencia);
					$message = array(
						'type' => 'success',
						'text' => 'El registro se guardo correctamente.' 
					);
												
					$this->session->set_flashdata( 'message', $message );	
					redirect( '/ingeniero/ver_incidentes_clientes/'.$this->login[0]['id_ingeniero'], 'refresh' );
					
				}else{
					
					$message = array(
						'type' => 'failure',
						'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
								
					$this->session->set_flashdata( 'message', $message );
										
					redirect( '/ingeniero/ver_incidentes_clientes/'.$this->login[0]['id_ingeniero'], 'refresh' ); 
					
				}
				
			}
		
		}
		
		// Load Model
		$this->load->model( array('incidencia','notas','areas','usuarios','estados','causas' ) );
		$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
		$this->load->helper('ckeditor');
		$this->view=array(
			'title'=>'Talents Note',
			'css'=>array( 
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				'<link type="text/css" rel="stylesheet" href="'.base_url().'style/themes/base/jquery-ui.css" media="screen"/>',
				'<link type="text/css" rel="stylesheet" href="'.base_url().'style/dataTables.bootstrap.css" media="screen"/>', 
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',
				'<link type="text/css" rel="stylesheet" href="'.base_url().'style/summernote/summernote.css" media="screen"/>',    
				'<style type="text/css">
				  .modal-body div img {
				    max-width: 100%; }
				</style>'
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/summernote/summernote.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/ingeniero/file.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/ingeniero/bootstrap.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#nota").summernote({
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
			'incidencia'=>$this->incidencia->id2($incidencia),
			'area_ing'=>$this->ingenieros->id($this->login[0]['id_ingeniero']),
			'id_incidencia' => $incidencia,
			'estado'=>$this->estados->all(),
			'condicion'=>$this->estados->all2(),
			'causa'=>$this->causas->all(),
			'notas' => $this->notas->incidencia($incidencia),
			'areas' => $this->areas->all(),
			'click' => $this->incidencia->vistas($incidencia),
			'usuario2' => $this->usuarios->id2($this->login[0]['id_ingeniero'],'id_ingeniero'),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'ingeniero/incidentes/crear'
			
	    );
		
		$this->load->view( 'includes/include_ingeniero', $this->view );
		

	}

	public function _extraer_tiempo($id =null, $fechadb= null ){
		
		date_default_timezone_set("America/Bogota");
		$h_bd=$fechadb;
		$h_actual = date( 'Y-m-d h:i:s', time());
		$h1= explode(" ", $h_bd);
        $h_dif1=explode(":", $h1[1]);
        $h2= explode(" ", $h_actual);
        $h_dif2=explode(":", $h2[1]);
		$diferencia_min= $h_dif2[1] - $h_dif1[1];
		$diferencia_hor=  ($h_dif2[0] - $h_dif1[0]) * 60;
		$this->load->model('trigger');

		if($this->trigger->consultar_incidente($id)!=0){
			return true;
				
		}else{
			if($h_dif2[0] > $h_dif1[0]){
				if($this->trigger->crear($id,$diferencia_hor)== true)
			       return true;
			}elseif($h_dif2[1] > $h_dif1[1]){
				if($this->trigger->crear($id,$diferencia_min)== true)
					return true;
			}else{
				if($this->trigger->crear( $id, 1 )== true)
					return true;
			}
			
		}
		
	}
	
	
	public function incidente_resuelto( $incidencia = null ){
		
		// Validaciones
		if( empty( $incidencia ) or !is_numeric( $incidencia ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/ingeniero/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'incidencia' );
		
		$this->data = $this->incidencia->resuelto( $incidencia );
		
		$this->load->model( array( 'usuarios' ,'notas') );
		$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
		
		$this->view = array(
			
			'title'=>'Talents Notes',
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
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/ingeniero/bootstrap.js"></script>',
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
			'usuario'=>$usuario,
			'incidencia' => $this->data,
			'login' => $this->login,
			'notas' => $this->notas->incidencia( $incidencia ),
			'section' => 'lista',
			'content' => 'ingeniero/incidentes/resuelto'
			
	    );
		
		$this->load->view( 'includes/include_ingeniero', $this->view );
	}
	
	public function enviar_correo($incidencia = null){
		
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
		 $mail->FromName = 'Administrador talentos y tecnologia';
		 $mail->Subject = $enviar[0]['asunto'];
		 $mail->AddAddress($enviar[0]['correo_contacto'],'cliente');
		 $mail->AddAddress($enviar[0]['correo_ingeniero'],'ingeniero');
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
						<tbody><tr><td class="w30" width="30"></td><td class="w580" width="580" height="30"><h1 style="color: #47c8db !important; font: bold 32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"><singleline label="Title">Administrador</singleline></h1></td><td class="w30" width="30"></td></tr>
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
		 if(!$mail->Send()) 
        {	
            return false;
        } else {
        	
            return true;
        }
		
	}
	
	public function incidente_cliente(){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 3 ){		
			$message = array(
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			);		
			redirect( '/admin/welcome/', 'refresh' );
		}

		$this->view=array(
			'title'=>'Talents Note',
			'css'=>array(
				'<link type="text/css" rel="stylesheet" href="'.base_url().'style/tabla_incidente_cliente.css" media="screen/>'),
			'scripts'=>array(),
			'content'=>'ingeniero/incidentes/incidente_cliente'
		);
		
		
			$this->load->view('includes/include_ingeniero', $this->view);
		
	}
	
	public function ver_incidentes_clientes( $id = null ){
		
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/ingeniero', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model(array('usuarios','ingenieros','incidencia','areas','estados'));
		$this->data = $this->incidencia->ingeniero($id);
		$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
		
		$this->view = array(
			
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
				
			    '<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>', 
				'<script type="text/javascript" src="'.base_url().'scripts/datatableincidentes.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'usuario'=>$usuario,
			'data' => $this->data,
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'ingeniero/incidentes/ver_incidentes_clientes'
			
	    );
		
		$this->load->view( 'includes/include_ingeniero', $this->view );
		
		
	}
	
	public function ver_incidentes_resueltos($id = null){
		
		
		// Validaciones
		if( empty( $id ) or !is_numeric( $id ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			redirect( '/ingeniero', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model(array('usuarios','ingenieros','incidencia','areas','estados'));
		$this->data = $this->incidencia->ingeniero_resueltos($id);
		$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
		$this->view = array(
			
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
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/datatableincidentes.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			
			),
			'usuario'=>$usuario,
			'data' => $this->data,
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'ingeniero/incidentes/ver_resueltos'
			
	    );
		
		$this->load->view( 'includes/include_ingeniero', $this->view );
		
		
	}
	
	public function libreta(  ){
		
		
		// Cargar modelo de datos
		$this->load->model( array( 'usuarios', 'contactos' ) );
		
		$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
		
		$this->data = $this->contactos->libreta_direcciones();

		$this->view = array(
			
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
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'usuario'=>$usuario,
			'data' => $this->data,
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'ingeniero/incidentes/libreta'
			
	    );
		
		$this->load->view( 'includes/include_ingeniero', $this->view );
		
		
	}
	
	public function crear_incidentes(){
		// Permisos
		if( $this->login[0]['id_perfil'] != 2 ){
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
			redirect( '/admin/welcome/', 'refresh' );
		}
		
	
		if(!empty($_POST)){			
			unset($_POST['valor']);
			// Configurar Reglas de validación
			$this->form_validation->set_rules('categorias', 'categorias', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_subcategoria', 'Subcategoria', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_condicion', 'Condición', 'trim|required|xss_clean');
			$this->form_validation->set_rules('id_area', 'Área', 'trim|required|xss_clean');
			$this->form_validation->set_rules('asunto', 'Subcategoria', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('detalle', 'Detalle', 'trim|required|xss_clean|callback__alfanumeric');
			$this->form_validation->set_rules('id_cliente', 'Cliente', 'trim|required|xss_clean');
		
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
					'detalle'=>form_error('detalle'),
					'cliente'=>form_error('id_cliente')
				);
				$this->session->set_flashdata('errores', $errores);	
				redirect('ingeniero/crear_incidentes/');
				
			}else{

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
					move_uploaded_file( $_FILES["imagen2"]["tmp_name"], './incidentes/'.$name );
					 // crear valores de configuracion para cargar la libreria
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
				$this->load->model( 'incidencia' );
				$this->load->model( 'contactos' );
				$_POST['id_ingeniero_envia']=$this->login[0]['id_ingeniero'];
				$contacto= $this->contactos->cliente2($_POST['id_cliente']);
				$_POST['id_contacto']= $contacto[0]['id_contacto'];
				if( $this->incidencia->crear_incidente_ingeniero( $this->input->post() ) == true ){			
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);
					$this->session->set_flashdata( 'message', $message );	
					redirect( 'ingeniero/ver_incidentes_clientes/'.$this->login[0]['id_ingeniero'], 'refresh' );
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
					$this->session->set_flashdata( 'message', $message );
					redirect( 'ingeniero/ver_incidentes_clientes/'.$this->login[0]['id_ingeniero'], 'refresh' ); 
				}	
			}
			
		}
		
		// Load model
		$this->load->model( array( 'categorias', 'areas', 'usuarios','causas','cliente','estados') );
		$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
		
		
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
				'<script type="text/javascript" src="'.base_url().'scripts/ingeniero/validate.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/timepicker.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#detalle").summernote({
							height: "300",
					        toolbar: [
					  		    ["style", ["bold", "italic","underline","clear"]],
					  		    ["para", ["ul","ol"]]
					        ]
						});
						$("#fecha").datetimepicker();
					});
				</script>'
			),
			'usuario'=>$usuario,
			'categorias' => $this->categorias->all(),
			'areas' => $this->areas->all(),
			'causas' => $this->causas->all(),
			'clientes' => $this->cliente->all(),
			'condicion' => $this->estados->all2(),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'ingeniero/incidentes/crear_nuevo'
			
	    );
		
		$this->load->view( 'includes/include_ingeniero', $this->view );
		
			
	}
	
	public function perfil_ingeniero( $id = null ){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 2 ){
						
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
			
			redirect( '/', 'refresh' ) ;
		}
		
		// Cargar modelo de datos
		$this->load->model( 'ingenieros' );
		
		$this->data = $this->ingenieros->id( $id );
		
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'El registro no existe.' 
			);
			
			redirect( '/', 'refresh' ) ;
		}
		
		
		
		if( !empty( $_POST ) ){
			
			// Configurar Reglas de validación
			$this->form_validation->set_rules('celular', 'Teléfono', 'trim|xss_clean|required|callback__phone');
			$this->form_validation->set_rules('correo', 'Nit', 'trim|valid_email|required');
			$this->form_validation->set_rules('contrasena_original', 'Contraseña Original', 'trim|xss_clean');
			$this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|xss_clean|matches[re_contrasena]');
			$this->form_validation->set_rules('re_contrasena', 'Repetir Contraseña', 'trim|xss_clean');

			
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
			$this->form_validation->set_message('callback__phone', 'El Campo %s no es un teléfono valido...');
			$this->form_validation->set_message('valid_email', 'El Campo %s no es un correo valido...');
			$this->form_validation->set_message('matches','Las contraseñas no son iguales');
			
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
					'contra'=>form_error('contrasena'),
			        'cel'=>form_error('celular'),
			        'correo'=>form_error('correo'),
			        'original'=>form_error('contrasena_original'),
			        'recontra'=>form_error('re_contrasena')
					);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('ingeniero/perfil_ingeniero/'.$id);
			
			}else{
				// if($_FILES['foto']['name']!=''){	
				// 	$file = explode( '.', $_FILES['foto']['name'] );
				// 	if($file[1] != 'gif' and $file[1] != 'jpg'	and	$file[1] != 'png' and $file[1] != 'gif'){
						
				// 		$message = array(
				// 			'type' => 'failure',
				// 			'text' => 'El archivo que intenta subir no tiene una extención valida'	
				// 		);
							
				// 		$this->session->set_flashdata( 'message', $message );		
				// 		redirect( '/ingeniero/perfil_ingeniero/'.$id, 'refresh' );	
				// 	}
					
				// 	if( !is_dir( './usuarios' ) ){
				// 		$message = array(
				// 			'type' => 'failure',
				// 			'text' => 'No existe el directorio ingeniero..'	
				// 		);
							
				// 		$this->session->set_flashdata( 'message', $message );		
				// 		redirect( '/ingeniero/perfil_ingeniero/'.$id, 'refresh' );	
				// 	}
					
				// 	if( !empty( $this->data[0]['img'] ) ){
				// 		if( is_file( './ususarios/'.$this->data[0]['img'] ) )
				// 			unlink( './usuarios/'.$this->data[0]['img'] );
				// 	}
					
				// 	$_FILES['foto']['name']=$this->login[0]['Usuario'].'.'.$file[1];
				// 	$name = str_replace( ' ', '-', $_FILES['foto']['name'] );
				// 	$name = str_replace( '/', '-', $name );
				// 	$name = strtolower( $name );
				// 	move_uploaded_file( $_FILES["foto"]["tmp_name"], './usuarios/'.$name );
				// 	 // crear valores de configuracion para cargar la libreria
				// 	 $config['image_library'] = 'GD2';   // libreria a utilizar
				// 	 $config['source_image'] = './usuarios/'.$name;  // imagen fuente, aqui se debe colocar la ruta completa del archivo en el servidor tomando como referencia la raíz del sitio (ejemplo ./uploads/)
				// 	 $config['width'] =  85;          // ancho de la imagen a generar
				// 	 $config['height'] = 60;          // alto de la imagen a generar
				// 	 $config['maintain_ratio'] = TRUE;
				// 	 $config['create_thumb'] = FALSE;     // especificar que se quiere generar un thumbnail
				// 	$this->load->library('image_lib', $config); 
				// 	 $this->image_lib->resize();         // crear thumbnail		
				// 	 $_POST['img'] = $name;
					
				// }	
			

				$this->load->model('usuarios');
				if($this->usuarios->contrasena_ingeniero($this->login[0]['id_ingeniero'],$this->input->post('contrasena_original'))!=true){
					$message = array(
								'type' => 'failure',
								'text' => 'La contraseña anterior no es valida intentelo de nuevo' 
					);
											
					$this->session->set_flashdata('message', $message );	
										
						
					redirect( '/ingeniero/perfil_ingeniero/'.$id);
				}
				 
				if( $this->ingenieros->editar( $id, $this->input->post() ) == true ){
				
					$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
					);

					$this->session->set_flashdata( 'message', $message );	
					redirect( '/ingeniero/perfil_ingeniero/'.$id);
											
				}else{
				
					$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
					);
					$this->session->set_flashdata( 'message', $message );
					redirect( '/ingeniero/perfil_ingeniero/'.$id); 
				}
				exit;
			}						
			exit;
		}
		// Load Model
		$this->load->model( array( 'usuarios' ) );
		$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
		
		$this->view=array(
			
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				),
			'scripts'=>array(

				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
			),
			'usuario'=>$usuario,
			'data' => $this->data,
			'login' => $this->login,
			'section' => 'nuevo',
			'content' => 'ingeniero/perfil_ingeniero'
			
	    );
		
		$this->load->view( 'includes/include_ingeniero', $this->view );		
			
	}
	
	
/*
==============================	
	 Reportes
============================== */		
	public function reportes(){
		
		// Permisos
		if( $this->login[0]['id_perfil'] != 2 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
						
			redirect( '/admin/welcome/', 'refresh' );
		
		}
					
		// Cargar modelo de datos
		$this->load->model( array('incidencia', 'usuarios') );
		
		$this->data = $this->incidencia->ingenierotodas( $this->login[0]['id_ingeniero'] );
						
		if( empty( $this->data ) ){ 
			
			$message = array(
				'type' => 'warning',
				'text' => 'No hay incidentes.' 
			);
			
			redirect( '/ingeniero', 'refresh' ) ;
		}
		
		$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
		
		$this->view=array(
			
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools.css" type="text/css" />',
				'<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
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
				'<script type="text/javascript" src="'.base_url().'scripts/imprimir.js"></script>',
				
			),
			'usuario'=>$usuario,
			'data' => $this->data,
			'login' => $this->login,
			'section' => 'ver',
			'content' => 'ingeniero/incidentes/reportes'
			
	    );
		
		$this->load->view( 'includes/include_ingeniero',$this->view );	
		
	
		
	}
	
	public function reporte_print($incidencia = null,$type ='xls'){
		
		$this->load->model(array('incidencia'));
		$this->load->model( 'notas' );
		$this->load->model( 'contactos' );

		// Load Library
		$this->load->library( array('fpdf', 'exp')); 
		if( !empty( $incidencia ) ){
			$this->data = $this->incidencia->id($incidencia);
			$this->date = $this->notas->incidencia($incidencia);
			$contacto= $this->contactos->cliente2($this->data[0]['id_cliente']);
			$file = $this->exp->onlyExport($this->data);			
		}
		
		if(!empty( $_POST)){
			$this->data = $this->incidencia->id($incidencia);	
			$file = $this->exp->fullExport($this->data);	
			$type = $this->input->post('type');
		}
		// Impresion en excel 
		if( $type  == 'xls' ) {
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=TalentsNote.xls" );
			echo $file;
		}
		// Impresion en pdf 
		if( $type  == 'pdf' ) {
			
			$this->fpdf->AddPage('L','A4');
			$this->fpdf->AliasNbPages();
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(20,10,'Codigo',1,0,'C');
			$this->fpdf->Cell(20,10,'Estado',1,0,'C');
			$this->fpdf->Cell(40,10,'Cliente',1,0,'C');
			$this->fpdf->Cell(20,10,'Prioridad',1,0,'C');
			$this->fpdf->Cell(40,10,'Asunto',1,0,'C');
			$this->fpdf->Cell(40,10,'Detalle',1,0,'C');
			$this->fpdf->Cell(40,10,'Empresa',1,0,'C');
			$this->fpdf->Cell(30,10,'Fecha',1,0,'C');
			$this->fpdf->Cell(30,10,'Fecha de cierre',1,0,'C');
			$this->fpdf->Ln();
			if(!empty($this->data)){
				$this->fpdf->SetWidths(array(20,20,40,20,40,40,40,30,30));
				$this->fpdf->Row(array($this->data[0]['id_incidencia'],$this->data[0]['estado'],utf8_decode($contacto[0]['nombre']),
							utf8_decode($this->data[0]['condicion']),
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
			$this->fpdf->Cell(80,10,'Fecha de nota',1,0,'C');
			$this->fpdf->Cell(100,10,'Nota',1,0,'C');
			$this->fpdf->Cell(100,10,'Usuario',1,0,'C');
			$this->fpdf->Ln();
			if(!empty($this->date) ){
				$this->fpdf->SetWidths(array(80,100,100));
				foreach ($this->date as $fila){
                	$this->fpdf->Row(array($fila['fecha'],strip_tags(utf8_decode($fila['notas'])),$fila['contacto'].$fila['ingeniero']));               
            	}
			}else{
				$this->fpdf->SetWidths(array(280));
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
			$this->data = $this->incidencia->id4($incidencia);
			$file = $this->exp2->onlyExport( $this->data );	
		}
		
		// Impresion en excel 
		if( $type  == 'xls' ) {
		
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=TalentsNote.xls" );
			echo $file;
			
		}

		// Impresion en pdf 
		if( $type  == 'pdf' ) {
			$this->fpdf->FPDF('L','mm','Legal');
			$this->fpdf->AddPage('L','Legal');
			$this->fpdf->AliasNbPages();
			$this->fpdf->SetFont('Arial','B',11);
			$this->fpdf->SetWidths(array(20,20,50,20,30,40,40,25,25,70));
			$this->fpdf->Row(array('Codigo','Estado','Ingeniero','Prioridad','Categoria','Detalle','Asunto del Caso','Fecha','Fecha Final','Notas del Caso(Solucion)'));
			if(!empty($this->data) ){
				$this->fpdf->SetWidths(array(20,20,50,20,30,40,40,25,25,70));
				$total=count($this->data);
				for ($i=0; $i <$total ; $i++) 
				{
	   				$this->fpdf->Row(array($this->data[$i]['id_incidencia'],$this->data[$i]['nombre_estado'],utf8_decode($this->data[$i]['nombre']),utf8_decode($this->data[$i]['descripcion']),
	   								utf8_decode($this->data[$i]['opcion']),strip_tags(utf8_decode($this->data[$i]['detalle'])),strip_tags(utf8_decode($this->data[$i]['asunto'])),
	   								$this->data[$i]['fecha'],$this->data[$i]['fecha_final'],strip_tags(utf8_decode($this->data[$i]['notas']))));
				}
			}else{
				$this->fpdf->SetWidths(array(350));
				$this->fpdf->Row(array("NO HAY DATOS EN LA TABLA"));
			}
			$this->fpdf->output();
		}	
	}

/*
===================================
	Ajax request
=================================== */	

public function areas(){
		
		if( empty( $_POST ) ) return false;
		
		// Load model 
		$this->load->model( 'ingenieros' );
		
		$this->data = $this->ingenieros->areas( $this->input->post( 'id_area' ) );
		
		if( empty( $this->data ) ) return false;
		
		$options='<option value="">Seleccione...</option>';
		
		foreach( $this->data as $value ){
			$options .= '<option value="'.$value['id_ingeniero'].'">'.$value['nombre'].'</option>';
		}
		
		echo $options;
		
		unset( $options, $this->data );
		
		
	}

public function causas(){

	$this->load->model( 'causas' );
	
	$this->data= $this->causas->all();
	
	$options='<option value="">Seleccione...</option>';
	
	foreach( $this->data as $value ){
			$options .= '<option value="'.$value['id_causa'].'" >'.$value['nombre_causa'].'</option>';
	}
	
	echo $options;
		
		unset( $options, $this->data );
		
}	
	
/*
==============================	
	 Validaciones
============================== */
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