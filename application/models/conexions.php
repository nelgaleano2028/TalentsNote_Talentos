<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conexions extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_conexion';
	
		
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
	    if( $this->db->update( $this->table, $values, array( 'id_conexion' => $id ) ) )
        	return true;
        else
        	return false;
        
		
	}
	
	public function eliminar( $id = null ){
		
		// Validar id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		// Eliminar registro					
	    if( $this->db->delete( $this->table, array( 'id_conexion' => $id ) ) )
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
		$query = $this->db->get_where( $this->table, array( 'id_conexion' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_conexion' => $row->id_conexion,
					'id_tipo_conexion' => $row->id_tipo_conexion,
					'detalles' => $row->detalles
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function all(){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->query( 
			
			' SELECT '.$this->table.'.*, t_tipo_conexion.tipo_conexiones
			  FROM '.$this->table.'
			  JOIN 	t_tipo_conexion ON t_tipo_conexion.id_tipo_conexion = '.$this->table.'.id_tipo_conexion
				
			' );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_conexion' => $row->id_conexion,
					'tipo_conexiones' => $row->tipo_conexiones,
					'detalles' => $row->detalles
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function tipo_conexion(){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get( 't_tipo_conexion' );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_tipo_conexion' => $row->id_tipo_conexion,
					'tipo_conexiones' => $row->tipo_conexiones
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
					
}
?>