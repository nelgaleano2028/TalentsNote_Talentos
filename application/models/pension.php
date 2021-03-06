<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pension extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_pensiones';
	
		
    public function __construct(){  parent::__construct(); }
	

/*
====================================
	Funciones CRUD
==================================== */	
	public function crear( $values = array() ){
		
		// Validar información
		if( empty( $values ) ) return false;
		
		// Configurar información a guardar
		foreach( $values as $key => $value )									
				$this->data[$key] = $value ; 		
		
		
		// Crear registro	
	    if( $this->db->insert( $this->table, $this->data )  )
        	return true;
        else
        	return false;
        
		
	}
	
	public function editar( $id = null, $values = array() ){
		
		// Validar id e información
		if( empty( $id ) or !is_numeric( $id ) or empty( $values ) ) return false;
				
		// Editar registros					
	    if( $this->db->update( $this->table, $values, array( 'id_pensiones' => $id ) ) )
        	return true;
        else
        	return false;
        
		
	}
	
	public function eliminar( $id = null ){
		
		// Validar id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		$query = $this->db->get_where( 't_ingeniero', array( 'id_pensiones' => $id ) );
		
		if( $query->num_rows == 0 ){
			
			// Eliminar registro
			$this->db->delete( $this->table, array( 'id_pensiones' => $id ) );
			return true;
		}else{
			return false;
			
		}
		
	}
	
/*
====================================
	Funciones Para obtener datos
==================================== */	
	public function id( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_pensiones' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_pensiones' => $row->id_pensiones,
					'nombre_pensiones' => $row->nombre_pensiones
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function all(){
						
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get( $this->table );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_pensiones' => $row->id_pensiones,
					'nombre_pensiones' => $row->nombre_pensiones
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function ingeniero( ){
		
		unset( $this->data ); $this->data = array();
		// Consulta
		$query = $this->db->get( $this->table );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_pensiones' => $row->id_pensiones,
					'nombre_pensiones' => $row->nombre_pensiones
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
		
}
?>