<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactos extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_contacto';
	
		
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
	
	
	public function editar_admin( $id = null, $values = array() )
	{
				
		// Editar registros					
	    if( $this->db->update( $this->table, $values, array( 'id_contacto' => $id ) ) )
        	return true;
        else
        	return false;
	}
	
	
	public function editar( $id = null, $values = array() ){
		
		unset($values['contrasena_original'], $values['re_contrasena']);
		
		
		// Validar id e información
		if( empty( $id ) or !is_numeric( $id ) or empty( $values ) ) return false;
		
		$contrasena=$values['contrasena'];
		
		if(isset($values['img'])){
			
			$values=array(
			'telefono'=>$values['telefono'],
			'correo'=>$values['correo'],
			'img'=>$values['img']
			
			);
		}else{
			
			$values=array(
			'telefono'=>$values['telefono'],
			'correo'=>$values['correo'],
			);
			
		}
		
		$salt=$this->_create_salt();
		
		$contrasena=sha1($contrasena.$salt);
				
		$contrasena=array(
		 	'contraseña'=> $contrasena,
			'salt'=>$salt
		 );
		
		if($contrasena['contraseña'] == ''){
			
			
			if($this->db->update( $this->table, $values, array( 'id_contacto' => $id ) ))
			return true;
			else
				return false;

		}else{
			
			// Editar registros	
			$this->db->update( $this->table, $values, array( 'id_contacto' => $id ) );
		
			 if( $this->db->update( 't_usuario', $contrasena, array( 'id_contacto' => $id ) ) )
			return true;
			else
				return false;
			
		}		
        
		
	}
	
	protected function _create_salt()
	{
		$this->load->helper('string');
		return sha1(random_string('alnum', 32));
	}
	
	public function eliminar( $id = null ){
		
		// Validar id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		// Eliminar registro					
	    if( $this->db->delete( $this->table, array( 'id_contacto' => $id ) ) )
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
		$query = $this->db->get_where( $this->table, array( 'id_contacto' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_contacto' => $row->id_contacto,
					'id_cliente' => $row->id_cliente,
					'nombre' => $row->nombre,
					'apellido' => $row->apellido,
					'correo' => $row->correo,
					'telefono' => $row->telefono,
					'img' => $row->img
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function usuario( ){
		
		// Consulta
		$query = $this->db->get( $this->table );
		
		unset( $this->data ); $this->data = array();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_contacto' => $row->id_contacto,					
					'nombre' => $row->nombre					
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function contacto_incidente($id=null ){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_contacto' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_contacto' => $row->id_contacto,
					'nombre' => $row->nombre.' '.$row->apellido,
					'correo'=> $row->correo			
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function cliente2( $contacto = null ){
		
		
		
		if( empty( $contacto ) or !is_numeric( $contacto ) ) return false; 
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_cliente' => $contacto ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_contacto' => $row->id_contacto,
					'nombre' => $row->nombre.' '.$row->apellido,
					'id_cliente'=> $row->id_cliente			
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}

	public function cliente( $contacto = null ){
		
		
		
		if( empty( $contacto ) or !is_numeric( $contacto ) ) return false; 
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_contacto' => $contacto ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_contacto' => $row->id_contacto,
					'nombre' => $row->nombre.' '.$row->apellido,
					'id_cliente'=> $row->id_cliente			
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function all(){
		
		unset( $this->data ); $this->data = array();
		
		$this->load->model('cliente');
		// Consulta
		$query = $this->db->get( $this->table );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$cliente=$this->cliente->id($row->id_cliente);
				
				$this->data[] = array( 
					
					'id_contacto' => $row->id_contacto,
					'cliente' => $cliente[0]['nombre_cliente'],
					'nombre'=>$row->nombre,
					'apellido'=>$row->apellido,
					'correo'=>$row->correo,
					'telefono'=>$row->telefono
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function libreta_direcciones(){
		
		$this->db->select('t_contacto.nombre,t_contacto.apellido,t_contacto.correo,t_contacto.telefono,
		t_cliente.nombre_cliente,t_usuario.Usuario');
		$this->db->from('t_contacto');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_contacto.id_cliente');
		$this->db->join('t_usuario', 't_usuario.id_contacto=t_contacto.id_contacto');
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
				
					'nombre'=>$row->nombre,
					'apellido'=>$row->apellido,
					'correo'=>$row->correo,
					'telefono'=>$row->telefono,
					'empresa'=>$row->nombre_cliente,
					'usuario'=>$row->Usuario,
				
				
				);
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
	}
	
		
		
}
?>