<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingenieros extends CI_Model {
// Id	
	private $id = null;
// Save data	
	private $data = array();
// Table usage	
	private $table = 't_ingeniero';
// traer el ingeniero asignado
	private $ingeniero= array();
	private $id_ingeniero=array();
    public function __construct(){  parent::__construct(); }
/*
====================================
	Funciones CRUD
==================================== */	
	public function crear($values = array()){
		
		// Validar información
		if( empty( $values ) ) return false;
		
		// Configurar información a guardar
		foreach( $values as $key => $value )									
				$this->data[$key] = $value ; 		
		
		
		// Crear registro	
	    if($this->db->insert($this->table,$this->data))
        	return true;
        else
        	return false;
        
		
	}
	
	public function editar_admin( $id = null, $values = array() ){
		
		// Validar id e información
		if( empty( $id ) or !is_numeric( $id ) or empty( $values ) ) return false;
				
		// Editar registros					
	    if( $this->db->update( $this->table, $values, array( 'id_ingeniero' => $id ) ) )
        	return true;
        else
        	return false;
        
		
	}
	
	public function editar( $id = null, $values = array() ){
		
		unset($values['contrasena_original'], $values['re_contrasena']);
		
		$contrasena=$values['contrasena'];
		
		// Validar id e información
		if( empty( $id ) or !is_numeric( $id ) or empty( $values ) ) return false;
		
		if(isset($values['img'])){
			
			$values=array(
			'celular'=>$values['celular'],
			'correo'=>$values['correo'],
			'img'=>$values['img']
			
			);
		}else{
			
			$values=array(
			'celular'=>$values['celular'],
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
			
			
			if($this->db->update( $this->table, $values, array( 'id_ingeniero' => $id ) ))
			return true;
			else
				return false;

		}else{
			
			// Editar registros	
			$this->db->update( $this->table, $values, array( 'id_ingeniero' => $id ) );
		
			 if( $this->db->update( 't_usuario', $contrasena, array( 'id_ingeniero' => $id ) ) )
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
	
	
	public function editar_flujo($id = null)
	{
		
		// Validar id e información
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select( 'id_ingeniero, flujo' )->from( $this->table )->where( array( 'id_ingeniero' => $id ) ); 		
		// traer Consulta
		$query = $this->db->get();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
				
					'id_ingeniero' => $row->id_ingeniero,
					'flujo'=> $row->flujo
				
				);
		  
			}
		
			
			$cambiar=array(
				'id_ingeniero'=>$this->data[0]['id_ingeniero'],
				'flujo'=>$this->data[0]['flujo'] 
			);
			
			$this->db->update( $this->table , $cambiar, array( 'id_ingeniero'=>$cambiar['id_ingeniero'] ) );
			
			return $cambiar['id_ingeniero'];
				
		}
	}
	
	
	public function eliminar( $id = null ){
		
		// Validar id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		// Eliminar registro					
	    if( $this->db->delete( $this->table, array( 'id_ingeniero' => $id ) ) )
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
		$query = $this->db->get_where( $this->table, array( 'id_ingeniero' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_ingeniero' => $row->id_ingeniero,
					'id_cesantias' => $row->id_cesantias,
					'id_pensiones' => $row->id_pensiones,
					'id_eps' => $row->id_eps,
					'id_cargo' => $row->id_cargo,
					'id_area' => $row->id_area,
					'nombre' => $row->nombre,
					'cedula' => $row->cedula,
					'celular' => $row->celular,
					'correo' => $row->correo,
					'estado_laboral' => $row->estado_laboral,
					'img' => $row->img
					
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function id_ingeniero( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_ingeniero' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->load->model(array('cesantia', 'epsm', 'pension', 'cargo'));
				$cesantias=$this->cesantia->id($row->id_cesantias);
				$pesiones=$this->pension->id($row->id_pensiones);
				$eps=$this->epsm->id($row->id_eps);
				$cargo=$this->cargo->id($row->id_cargo);
				
				$this->data[] = array( 
					
					'id_ingeniero' => $row->id_ingeniero,
					'censantias' => $cesantias[0]['nombre_cesantias'],
					'pensiones' => $pesiones[0]['nombre_pensiones'],
					'eps' => $eps[0]['nombre_eps'],
					'cargo' => $cargo[0]['nombre_cargo'],
					'id_area' => $row->id_area,
					'nombre' => $row->nombre,
					'cedula' => $row->cedula,
					'celular' => $row->celular,
					'correo' => $row->correo,
					'estado_laboral' => $row->estado_laboral,
					'img' => $row->img
					
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	
	public function tooltip_ingenieros( ){
		
		
		// Consulta
		$query = $this->db->get( $this->table );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_ingeniero' => $row->id_ingeniero,
					'id_cesantias' => $row->id_cesantias,
					'id_pensiones' => $row->id_pensiones,
					'id_eps' => $row->id_eps,
					'id_cargo' => $row->id_cargo,
					'id_area' => $row->id_area,
					'nombre' => $row->nombre,
					'cedula' => $row->cedula,
					'celular' => $row->celular,
					'correo' => $row->correo,
					'estado_laboral' => $row->estado_laboral,
					'img' => $row->img
					
										
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
				
				// load Model
				$this->load->model( array( 'epsm', 'pension', 'cesantia' ) );
				
			foreach ( $query->result() as $row ){
				
				$eps = $this->epsm->id( $row->id_eps );
				
				$pension = $this->pension->id( $row->id_pensiones );
				
				$cesantia = $this->cesantia->id( $row->id_cesantias );
				
				$this->data[] = array( 
					
					'id_ingeniero' => $row->id_ingeniero,
					'cesantias' => $cesantia[0]['nombre_cesantias'],
					'pensiones' => $pension[0]['nombre_pensiones'],
					'eps' => $eps[0]['nombre_eps'],
					'nombre' => $row->nombre,
					'cedula' => $row->cedula,
					'celular' => $row->celular,
					'correo' => $row->correo,
					'estado_laboral' => $row->estado_laboral,
									
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function all2(){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get( $this->table );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
				
				// load Model
				
				$this->load->model(array( 'areas', 'cargo'));
				
				
				
			foreach ( $query->result() as $row ){
				
				$cargo=$this->cargo->id($row->id_cargo);
				$area=$this->areas->id($row->id_area);
				
				
				$this->data[] = array( 
					
					'id_ingeniero' => $row->id_ingeniero,
					'nombre' => $row->nombre,
					'area'=>$area[0]['nombre_area'],
					'cargo'=>$cargo[0]['nombre_cargo'],
					'estado_laboral' => $row->estado_laboral,
									
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function usuario(){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get( $this->table );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_ingeniero' => $row->id_ingeniero,
					'nombre' => $row->nombre				
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
			
	
	public function incidencia( $id = null ){
		
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select( 'nombre' )->from( $this->table )->where( array( 'id_ingeniero' => $id ) )->limit(1); 		
		// Consulta
		$query = $this->db->get();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			unset( $this->data ); $this->data = array();
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					

					'nombre' => $row->nombre
									
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function estado_laboral( $id=null ){
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select( 'estado_laboral' )
				->from($this->table)
				->where( array( 'id_ingeniero' => $id ) );
		// traer Consulta
		$query = $this->db->get();
		
		unset( $this->data ); $this->data = array();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
				
					'estado_laboral' => $row->estado_laboral,
				
				);
		  
			}
			
			return $this->data;	
				
		}
		
		
	}
	
	public function quitar_ingeniero( $id=null ){
		
		unset( $this->data ); $this->data = array();
		$this->db->select( 'id_ingeniero, flujo' )
				->from( $this->table )
				->where( array( 'id_ingeniero' => $id ) );
		// traer Consulta
		$query = $this->db->get();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
				
					'id_ingeniero' => $row->id_ingeniero,
					'flujo'=> $row->flujo
				
				);
		  
			}
			
			$cambiar=array(
				'id_ingeniero'=>$this->data[0]['id_ingeniero'],
				'flujo'=>$this->data[0]['flujo'] - 1
			);
			
			if($cambiar['flujo'] <= 0){
				
				$cambiar['flujo']=0;
				
				$this->db->update( $this->table , $cambiar, array( 'id_ingeniero'=>$cambiar['id_ingeniero'] ) );
				return true;
				
				
			}else{
			
				$this->db->update( $this->table , $cambiar, array( 'id_ingeniero'=>$cambiar['id_ingeniero'] ) );
				return true;
			}
						
		}
			
	}
	
	public function asignar( $id= null ){
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select( 'id_ingeniero, flujo' )
				->from($this->table)
				->where( array(  'id_ingeniero' => $id ) ); 		
		// traer Consulta
		$query = $this->db->get();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
				
					'id_ingeniero' => $row->id_ingeniero,
					'flujo'=> $row->flujo,
				
				);
			}
			
			$cambiar=array(
				'id_ingeniero'=>$this->data[0]['id_ingeniero'],
				'flujo'=>$this->data[0]['flujo'] + 1,
				
			);
			
            $ingeniero=$this->data[0]['id_ingeniero'];

			$this->db->update( $this->table , $cambiar, array( 'id_ingeniero'=>$cambiar['id_ingeniero'] ) );
			
			return $ingeniero;
					
				
		}
		
	}
	
	
	
	public function asignar_ingeniero( $area = null ){// begin method
		
		unset( $this->data ); $this->data = array();
		
		$query = $this->db->query('SELECT flujo,id_ingeniero,correo FROM t_ingeniero WHERE flujo=(SELECT MIN(flujo)
									FROM t_ingeniero WHERE id_area =\''.$area.'\' AND estado_laboral =1)
									AND id_area =\''.$area.'\' AND estado_laboral=1 ORDER BY id_ingeniero ASC limit 1');
		// Obtener datos
		if( $query->num_rows != 0 ){ // begin if
			
			foreach ( $query->result() as $row ){
						
				$this->data[] = array( 
					'minimo' => $row->flujo,
					'id_ingeniero'=>$row->id_ingeniero,
					'correo'=>$row->correo
															
				);
			}
			
			$flujo_update=array(
				'flujo'=>(int)$this->data[0]['minimo'] + 1
			);
			
			
			$this->db->update( $this->table , $flujo_update, array( 'id_ingeniero'=>$this->data[0]['id_ingeniero'] ));
			
			return $this->data;
			
			
		}// end if
		
	}// end method
	
	public function areas( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_area' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_ingeniero' => $row->id_ingeniero,
					'nombre' => $row->nombre,
					'id_area' => $row->id_area
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}

	public function ingeniero_buscar($id_area=null){
		$consulta=$this->db->query("SELECT id_ingeniero 
									FROM t_ingeniero 
									WHERE id_area='".$id_area."' AND estado_laboral=1
									ORDER BY rand(".time()." * " .time().") LIMIT 1");

		if($consulta->num_rows()>0)
		{
		   $row = $consulta->row(); 
		   return $row->id_ingeniero;
		}else{
			return 0;
		}

	}
			
}
?>