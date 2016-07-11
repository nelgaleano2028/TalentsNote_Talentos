<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias extends CI_Model {

// Id	
	private $id = null;
// Save data	
	private $data = array();
// Table usage	
	private $table = 't_categoria';
    public function __construct(){  parent::__construct(); }
	
/*
====================================
	Funciones CRUD
==================================== */	
	public function crear( $values = array() ){
		
		// Validar informacion
		if( empty( $values ) ) return false;

              

               $query=$this->db->query('SELECT (max(id)+1) as max_id FROM t_categoria'); 
               $row = $query->row_array();
               $max_id = $row['max_id']; // para traer el ultimo id

               $values=array(
                     'id'=> $max_id,
                     'opcion'=> $values['opcion']
               );
 
		
		// Configurar informacion a guardar
		foreach( $values as $key=> $value )									
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
	    if( $this->db->update( $this->table, $values, array( 'id' => $id ) ) )
        	return true;
        else
        	return false;
        
		
	}
	
	public function eliminar( $id = null ){
		
		// Validar id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		// Eliminar registro					
	    if( $this->db->delete( $this->table, array( 'id' => $id ) ) )
        	return true;
        else
        	return false;
        
		
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
		$query = $this->db->get_where( $this->table, array( 'id' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id' => $row->id,
					'opcion' => $row->opcion
										
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
					
					'id' => $row->id,
					'opcion' => $row->opcion
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function sub(){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get( $this->table );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id' => $row->id,
					'opcion' => $row->opcion
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
				
}
?>