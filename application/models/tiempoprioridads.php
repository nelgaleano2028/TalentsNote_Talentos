<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiempoprioridads extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_tiempoprioridad';
	
		
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
	    if( $this->db->update( $this->table, $values, array( 'id_tiempoprioridad' => $id ) ) )
        	return true;
        else
        	return false;
        
		
	}
	
	public function eliminar( $id = null ){
		
		// Validar id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		// Eliminar registro					
	    if( $this->db->delete( $this->table, array( 'id_tiempoprioridad' => $id ) ) )
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
		$query = $this->db->get_where( $this->table, array( 'id_tiempoprioridad' => $id ) );
		$this->load->model( array('estados' ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				$condicion = $this->estados->id2($row->id_condicion);
				$this->data[] = array( 
					
					'id_tiempoprioridad' => $row->id_tiempoprioridad,
					'id_condicion' => $row->id_condicion,
					'id_cliente' => $row->id_cliente,
					'horas' => $row->horas,
					'nombre_condicion'=>$condicion[0]['descripcion']
										
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
			
			//Load Model
			$this->load->model( 'cliente' );
			
			foreach ( $query->result() as $row ){
				
				$cliente  = $this->cliente->id( $row->id_cliente );
				
				if( $row->id_condicion == 1 ) $condicion = 'Alta';
				if( $row->id_condicion == 2 ) $condicion = 'Media';
				if( $row->id_condicion == 3 ) $condicion = 'Baja';
				if( $row->id_condicion == 4 ) $condicion = 'Muy Alta';
				
				$this->data[] = array( 
					
					'id_tiempoprioridad' => $row->id_tiempoprioridad,					
					'condicion' => $condicion,
					'cliente' => $cliente[0]['nombre_cliente'],
					'horas' => $row->horas
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function cliente( $cliente = null, $prioridad = null ){
		
		// Validacion id
		if( empty( $cliente ) or !is_numeric( $cliente ) and empty( $prioridad ) or !is_numeric( $prioridad ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_cliente' => $cliente, 'id_condicion' => $prioridad ) );
		
		unset( $this->data ); $this->data = array();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
				
					'horas' => $row->horas
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function cliente_hora($cliente = null){
		
		// Validacion id
		if( empty( $cliente ) or !is_numeric( $cliente ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_cliente' => $cliente ) );
		
		unset( $this->data ); $this->data = array();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
				
					'horas' => $row->horas
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
		
	}
	
	
	public function cliente_pausar( $cliente = null, $condicion= null ){
		
		// Validacion id
		if( empty( $cliente ) or !is_numeric( $cliente ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_cliente' => $cliente, 'id_condicion' => $condicion ) );
		
		unset( $this->data ); $this->data = array();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
				
					'horas' => $row->horas						
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
	}
					
}
?>