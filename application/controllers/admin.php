<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller{
	
	public $data  = array();
	public $view  = array();
	public $login = array();
	public function __construct(){
		
		parent::__construct();
	
		$this->login = $this->session->userdata('login');
		
		if( empty( $this->login ) ) redirect( '/usuario/login', 'refresh' );
				
	}
	
	public function index(){
		
		$this->load->model('usuarios');
		switch ($this->login[0]['id_perfil']){

			case 1:
				$content = 'login/welcome_admin';
			
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
							'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/inicioadmin.js"></script>',
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
						'content'=> $content,
						'section' => 'inicio',
						'login'=>$this->login
					
					);
										
					$this->load->view('includes/include', $this->view );
			break;	
		     
			case 2:
					$this->load->model( array( 'ingenieros' ) );
					$ingeniero=$this->ingenieros->id_ingeniero($this->login[0]['id_ingeniero']);
					$usuario= $this->usuarios->entrar_ingeniero($this->login[0]['id_ingeniero']);
					$content = 'login/welcome_ingeniero';	
					
					$this->view=array(
						
						'title'=>'Talents Notes',
						'css'=>array(
							'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
			                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
			                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
			                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
			                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.min.css" type="text/css"/>',
			                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',),
						'scripts'=>array(
							'<script type="text/javascript" src="'.base_url().'scripts/datatable.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/inicioadmin.js"></script>',
							
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
						'ingeniero'=>$ingeniero,
						'content'=> $content,
						'section' => 'inicio',
						'login'=>$this->login
					
					);
										
					$this->load->view( 'includes/include_ingeniero', $this->view );
				break;
				
			case 3:
			
				if( $this->login[0]['estado'] != 1 ){

					$message = array(
							'type' => 'failure',
							'text' => 'Los datos son incorrectos intentalo de nuevo.' 
					);
										
					$this->session->set_flashdata( 'message', $message );	
					
					redirect( '/usuario/login', 'refresh' ); 
				    }
			
					$this->load->model(array('usuarios', 'contactos', 'cliente'));
					
					$usuario= $this->usuarios->entrar_cliente($this->login[0]['id_contacto']);
					$contacto= $this->contactos->cliente($this->login[0]['id_contacto']);
					$cliente=  $this->cliente->id($contacto[0]['id_cliente']);

					$content = 'login/welcome_cliente';
								
					$this->view=array(
					
						'title'=>'Talents Notes',
						'css'=>array(
							'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
			                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
			                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
			                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
			                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.min.css" type="text/css"/>',
			                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',),
						'scripts'=>array(
							'<script type="text/javascript" src="'.base_url().'scripts/datatable.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
							'<script type="text/javascript" src="'.base_url().'scripts/inicioadmin.js"></script>',
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
					'cliente'=>$cliente,
					'content'=> $content,
					'section' => 'inicio',
					'login'=>$this->login
				
					);
									
				$this->load->view( 'includes/include_cliente', $this->view );
			break;
			
	    }//end switch
	}

}