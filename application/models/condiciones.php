<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Condiciones extends CI_Controller{
	
// Id	
	private $id = null;
// Save data	
	private $data = array();
// Table usage	
	private $table = 't_condicion';		
    public function __construct(){  parent::__construct(); }
	
	
/*
====================================
	Funciones CRUD
==================================== */	


	public function datos(){
						
			// Consulta
			$query = $this->db->get( $this->table );
			
			// Obtener datos
			if( $query->num_rows != 0 ){
				
				foreach ( $query->result() as $row ){
					
					$this->data[] = array( 
						
						'id_condicion' => $row->id_condicion,
						'descripcion' => $row->descripcion
											
					);
			  
				}
				
				return $this->data;	
					
			}else
				return false;
			
   }
		
}