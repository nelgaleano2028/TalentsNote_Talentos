<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	
	public $login = array();
	
// Getiing Funcitions	
	public function __construct(){ 	
		
		parent::__construct(); 	
		$this->login = $this->session->userdata('login' );
	}


	public function index(){
		
		if( empty( $this->login ) ){
			redirect( '/usuario/login', 'refresh' );
		}
		
		if( !empty( $this->login ) ){ redirect( '/admin/', 'refresh' );
		}
		
	}
	
}

?>