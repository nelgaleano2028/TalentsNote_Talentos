<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfiles extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_perfil';
	
		
    public function __construct(){  parent::__construct(); }
	

/*
====================================
	Funciones CRUD
==================================== */	
	public function crear( $values = array() ){
		
		if( empty( $values ) ) return false;
		
		foreach( $values as $key => $value )									
				$this->data[$key] = $value ; 		
		
			
	    if( $this->db->insert( $this->table, $this->data )  )
        	return true;
        else
        	return false;
        
		
	}
	
	public function editar( $id = null, $values = array() ){
		
		if( empty( $id ) or !is_numeric( $id ) or empty( $values ) ) return false;
							
	    if( $this->db->update( $this->table, $values, array( 'id_perfil' => $id ) ) )
        	return true;
        else
        	return false;
        
		
	}
	
	public function eliminar( $id = null ){
		
		if( empty( $id ) or !is_numeric( $id ) ) return false;
							
	    if( $this->db->delete( $this->table, array( 'id_perfil' => $id ) ) )
        	return true;
        else
        	return false;
        
		
	}
	
/*
====================================
	Funciones Para obtener datos
==================================== */	
	public function id( $id = null ){
		
		if( empty( $id ) ) return false;
		unset( $this->data ); $this->data = array();
		
		$query = $this->db->get_where( $this->table, array( 'id_perfil' => $id ) );
		
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_perfil' => $row->id_perfil,
					'nombre_perfil' => $row->nombre_perfil
					
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function usuario( $id = null ){
		
		
		$query = $this->db->get( $this->table );
		
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_perfil' => $row->id_perfil,
					'nombre_perfil' => $row->nombre_perfil
					
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}

}
?>