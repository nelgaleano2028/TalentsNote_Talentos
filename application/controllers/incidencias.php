<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incidencias extends CI_Controller{
	
	public $view=array();	
	public $data=array();	
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
		
		// Load model
		$this->load->model( 'incidencia' );
		
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
				'<script type="text/javascript" src="'.base_url().'scripts/datatableincidentes.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>'
			),
			'login' => $this->login,
			'section' => 'ver',
			'content' => 'admin/incidencias/ver',
			'data' => $this->incidencia->all()
	    
		);
		
		$this->load->view( 'includes/include', $this->view );
				
	}
	
	public function crear( $id = null ){
		// Load Model
		$this->load->model( 'incidencia' );
		$this->data = $this->incidencia->incidentes_admin($id);;
		if($_POST){	
			// Configurar Reglas de validación
			$this->form_validation->set_rules('id_estado', 'Estado', 'trim|xss_clean');
			$this->form_validation->set_rules('id_condicion', 'Prioridad', 'trim|xss_clean');
			$this->form_validation->set_rules('id_area', 'Área', 'trim|xss_clean');
			
			// Configurar mensajes de error
			$this->form_validation->set_message('required', 'El Campo %s esta vacío...');
									
			if ( $this->form_validation->run() == FALSE ){
				$errores = array(
			        'estado'=>form_error('id_estado'),
			        'condicion'=>form_error('id_condicion'),
			        'area'=>form_error('id_area')
				);
					
				$this->session->set_flashdata('errores',$errores);	
				redirect('incidencias/crear/'.$id);
			
			}else{
				date_default_timezone_set("America/Bogota");
													
				$nota = array(
					'id_incidencia' => $id,
					'notas' => $this->input->post( 'notas' ),
					'firmausuario' => $this->login[0]['Usuario'],
					'fecha' => date( 'Y-m-d h:i:s/a', time())
				);
				
				$update_incidencia = array(
					'id_estado' => $this->input->post('id_estado'),
					'id_condicion' => $this->input->post('id_condicion'),
					'id_area' => $this->input->post('id_area'),
					'id_ingeniero' => $this->input->post('id_ingeniero')
				);
				//comprobar si el ingeniero seleccionado esta activo
				if($this->input->post('id_ingeniero')){
				    $this->load->model( 'ingenieros' );
					$estado_laboral= $this->ingenieros->estado_laboral( $this->input->post('id_ingeniero'));
					if($estado_laboral[0]['estado_laboral'] != 1 )
					{
						$message = array(
							'type' => 'failure',
							'text' => 'El ingeniero no esta activo.'	
						);
									
						$this->session->set_flashdata( 'message', $message );
						redirect('/ingeniero/incidente_crear/'.$nota['id_incidencia'],'refresh');
						
					}
				}

				$this->load->model( array( 'notas', 'incidencia','areas' ) );
				//si el incidente es cerrado
				if($this->input->post('id_estado') == '2'){
					$update_incidencia['fecha_final']= date('Y-m-d H:i:s', time());	
					if($this->incidencia->editar($id,$update_incidencia )==TRUE){
						if($this->input->post( 'notas' )!='<p><br></p>'){
							$this->notas->crear($nota);
						}
						$this->enviar_correo($id);									  
						$message = array(
							'type' => 'success',
							'text' => 'El registro se guardo correctamente.' 
						);
													  
						$this->session->set_flashdata( 'message', $message );	
						redirect( '/incidencias', 'refresh' );
					}else{
						$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
						);
									  
						$this->session->set_flashdata( 'message', $message );
						redirect( '/incidencias', 'refresh' );
					}	
					
					
		       	}else{
		       		$area_nombre=$this->areas->id($update_incidencia['id_area']);
					
					if($this->incidencia->editar($id,$update_incidencia )==TRUE){
						if($this->input->post( 'notas' )!='<p><br></p>'){
							$this->notas->crear($nota);
						}
						
						$this->enviar_correo($id);
					  	$message = array(
						  	'type' => 'success',
						  	'text' => 'El registro se guardo correctamente.' 
					  	);
												  
					  	$this->session->set_flashdata( 'message', $message );	
					  	redirect( '/incidencias', 'refresh' );
					}else{
						$message = array(
							'type' => 'failure',
							'text' => 'Ha ocurrido un error no se puede guardar el registro. Intentalo mas tarde.'	
						);
									  
						$this->session->set_flashdata( 'message', $message );
						redirect( '/incidencias', 'refresh' );
					}
					
		       	}	
			}
		}
		
		// Load Model
		$this->load->model( array( 'incidencia', 'areas', 'ingenieros','estados','notas' ) );
		
		$this->view = array(
			
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
			    '<link type="text/css" rel="stylesheet" href="'.base_url().'style/summernote/summernote.css" media="screen"/>',
			    '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>',
			    '<link rel="stylesheet" href="http://oss.maxcdn.com/summernote/0.5.1/summernote-bs3.css"/>'
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/datatableincidentes.js"></script>',
				
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/summernote/summernote.js"></script>',
				'<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/incidencia/file.js"></script>','<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
			),
			'login' => $this->login,
			'section' => 'ver',
			'content' => 'admin/incidencias/crear',
			'incidencia' => $this->data,
			'areas' =>$this->areas->all(),
			'estado'=>$this->estados->all(),
			'notas' => $this->notas->incidencia($id),
			'ingeniero' => $this->ingenieros->usuario(),
			'ingeniero_area' => $this->ingenieros->areas($this->data[0]['id_area'])
				    
		);
			
		$this->load->view('includes/include', $this->view );
		
	}
	
	public function enviar_correo( $incidencia = null){
		
		$this->load->model('incidencia');
		
		$enviar=$this->incidencia->correo($incidencia);

		 $this->load->library('My_PHPMailer');
		 $mail = new mailer();
		 //$mail->Host = "vladimir.bello@talentsw.com";
		 // $mail->From = "vladimir.bello@talentsw.com"; 
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
									<tbody>
								<tr>	
								</tr>
								</tbody>
							</table>
						</td>
						<td class="w15" width="15"></td>
						</tr>
							</tbody>
						</table>		
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
											
											<tr>
											   <td>&nbsp;</td>
											   
											</tr>
											
											<tr>
											   <td><strong>Administrador:</strong> </td>
											   <td>vladimir.bello@talentsw.com</td>
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
		 
		 $exito = $mail->Send();
		if($exito){
			echo '<script>alert("Se envio el correo"); </script>';
		}else{
			echo '<script>alert("No se envio un carajo ..|.."); </script>';
		}
		 	 
		return true;
		
	}	
}
?>