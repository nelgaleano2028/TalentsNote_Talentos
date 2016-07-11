<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demonio extends CI_Controller{
    
	public function __construct(){ parent::__construct();}
        
        
        public function cambiar_estado(){
		
            
            $this->load->model( array( 'incidencia' ));
		
			$this->incidencia->buscar_clientes();   
        }

	public function generar_ans(){
		
		 $this->load->model( array( 'ans' ));
		
		$this->ans->buscar_clientes(); 
	}
	
}