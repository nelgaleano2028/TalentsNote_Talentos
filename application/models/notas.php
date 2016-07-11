<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notas extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_notas';
	
		
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

	public function incidencia( $incidencia = null  ){
		
		if( empty( $incidencia ) or !is_numeric( $incidencia ) ) return false;
		
		unset( $this->data ); $this->data = array();
				
		// Consulta
		$this->db->select('notas, fecha, firmausuario, i.nombre as ingeniero, concat(c.nombre," ",c.apellido) as contacto',FALSE)
				->from($this->table)
				->join('t_usuario u', 't_notas.firmausuario=u.Usuario','left')
				->join('t_ingeniero i', 'u.id_ingeniero=i.id_ingeniero','left')
				->join('t_contacto c', 'u.id_contacto=c.id_contacto','left')
				->where( array( 'id_incidencia' => $incidencia ) )
				->order_by( 'id_notas', 'desc' );
		
		$query = $this->db->get(  );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				
				$this->data[] = array( 
					
					'notas' => $row->notas,
					'fecha' => $row->fecha,
					'usuario'=> $row->firmausuario,
					'contacto'=> $row->contacto,
					'ingeniero'=> $row->ingeniero
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
		
}
?>