<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresa extends CI_Model
{
// Id
	private $id= null;
	
// save data
	private $data=array();
	
// table usage
	private $table= 't_empresa';
	
	public function __construct(){ parent::__construct();}
	
/*
====================================
	Funciones CRUD
==================================== */	

	public function crear( $values=array() )
	{
		if( empty( $values ) ) return false;
		
		foreach( $values as $key => $value )									
				$this->data[$key] = $value ; 		
		
			
	    if( $this->db->insert( $this->table, $this->data )  )
        	return true;
        else
        	return false;
	
	}
	
	public function eliminar(){}
	
	public function editar( $id= null, $values=array())
	{
		if( empty( $id ) or !is_numeric( $id ) or empty( $values ) ) return false;
		
		if($this->db->update($this->table, $values, array('id_empresa' => $id)))
			return true;
		else
			return false;
	}
/*
===================================================
	Funciones para obtener datos
===================================================*/

	public function id( $id = null )
	{
		if(empty($id))return false;
		
		unset( $this->data ); $this->data = array();
		
		$query = $this->db->get_where($this->table, array('id_empresa' => $id));
		
		if($query->num_rows !=0)
		{
			foreach($query->result() as $row)
			{
				$this->data[]=array(
					'id_empresa' => $row->id_empresa,
					'nombre_empresa' => $row->nombre_empresa,
					'nit' => $row->nit,
					'telefono' => $row->telefono,
					'direccion' => $row->direccion,
					'website' => $row->website	
				);
			}
			return $this->data;
		}
		else
		{
			return false;
		}
		
	}
	
	public function usuario( $id = null )
	{
		
		unset( $this->data ); $this->data = array();
		
		$query = $this->db->get( $this->table );
		
		if($query->num_rows !=0)
		{
			foreach($query->result() as $row)
			{
				$this->data[]=array(
				
					'id_empresa' => $row->id_empresa,
					'nombre_empresa' => $row->nombre_empresa
				
				);
			}
			return $this->data;
		}
		else
		{
			return false;
		}
		
	}
	
}
?>