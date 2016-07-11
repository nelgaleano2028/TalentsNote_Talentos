<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mensual extends CI_Model {


// Save data	
    private $data = array();
    
// Table usage	
    private $table = 't_ans';

		
    public function __construct(){  parent::__construct(); }
    
    
    
    public function no_cumple($incidencia,$dias,$horas,$minutos){
	
	unset( $this->data ); $this->data = array();
	
	 $this->data=array(
                        'id_incidencia'=>$incidencia,
                        'ans'=>'No cumple',
			'dias'=>$dias,
			'horas'=>$horas.':'.$minutos,
                    );
        
        
        $this->db->select('t_ans.id_incidencia');
        $this->db->from($this->table);
        $this->db->where('id_incidencia', $incidencia);
        $resultado=$this->db->get();
        if($resultado->num_rows != 0){
           
	     if( $this->db->update( $this->table, $this->data, array( 'id_incidencia' => $incidencia ) ) )
        	return true;
            else
                return false; 
                        
        }else{
	    
              
            if( $this->db->insert( $this->table, $this->data )  )
                return true;
            else
                return false;
        }
	
    }
    
    public function cumple($incidencia,$horas,$minutos){
	
	unset( $this->data ); $this->data = array();
	
	 $this->data=array(
                        'id_incidencia'=>$incidencia,
                        'ans'=>'Cumple',
			'dias'=>0,
			'horas'=>$horas.':'.$minutos,
                    );
        
        
        $this->db->select('t_ans.id_incidencia');
        $this->db->from($this->table);
        $this->db->where('id_incidencia', $incidencia);
        $resultado=$this->db->get();
        if($resultado->num_rows != 0){
           
	     if( $this->db->update( $this->table, $this->data, array( 'id_incidencia' => $incidencia ) ) )
        	return true;
            else
                return false; 
                        
        }else{
	    
              
            if( $this->db->insert( $this->table, $this->data )  )
                return true;
            else
                return false;
        }
	
	
    
					
    }
    
    
    public function pausado($incidencia,$horas,$minutos){
	
	unset( $this->data ); $this->data = array();
	
	 $this->data=array(
                        'id_incidencia'=>$incidencia,
                        'ans'=>'Pausado',
			'dias'=>0,
			'horas'=>$horas.':'.$minutos,
                    );
        
        
        $this->db->select('t_ans.id_incidencia');
        $this->db->from($this->table);
        $this->db->where('id_incidencia', $incidencia);
        $resultado=$this->db->get();
        if($resultado->num_rows != 0){
           
	     if( $this->db->update( $this->table, $this->data, array( 'id_incidencia' => $incidencia ) ) )
        	return true;
            else
                return false; 
                        
        }else{
	    
              
            if( $this->db->insert( $this->table, $this->data )  )
                return true;
            else
                return false;
        }
	
	
    
					
    }
    
    public function reporte($anio,$cliente){
	
	
	$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.detalle,t_estado.nombre_estado,
	t_incidencia.fecha,t_incidencia.fecha_final,t_ingeniero.nombre,t_ans.ans,t_ans.dias,t_ans.horas,t_cliente.nombre_cliente
	');
	$this->db->from('t_incidencia');
	$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
	$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
	$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
	$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
	$this->db->join('t_ans', 't_ans.id_incidencia = t_incidencia.id_incidencia');
        $this->db->where('t_incidencia.id_cliente',$cliente);
	$this->db->like('t_incidencia.fecha',$anio, 'after'); 
	$query=$this->db->get();
	if($query->num_rows != 0){
			
	    foreach($query->result() as $row){
    
		    $this->data[]=array(
				'id_incidencia'=>$row->id_incidencia,
				'cliente'=>$row->nombre_cliente,
				'asunto'=>$row->asunto,
				'detalle'=>$row->detalle,
				'estado'=>$row->nombre_estado,
				'fecha_ini'=>$row->fecha,
				'fecha_final'=>$row->fecha_final,
				'ingeniero'=>$row->nombre,
				'ans'=>$row->ans,
				'dias'=>$row->dias,
				'horas'=>$row->horas
			   );
	    }
	    
	    return $this->data;
	}
	
    }
    
    public function reporte_aempresa($anio,$mes,$cliente){
	
	$fecha=$anio.'-'.$mes;
	
	$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.detalle,t_estado.nombre_estado,
	t_incidencia.fecha,t_incidencia.fecha_final,t_ingeniero.nombre,t_ans.ans,t_ans.dias,t_ans.horas,t_cliente.nombre_cliente
	');
	$this->db->from('t_incidencia');
	$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
	$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
	$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
	$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
	$this->db->join('t_ans', 't_ans.id_incidencia = t_incidencia.id_incidencia');
	$this->db->where('t_incidencia.id_cliente',$cliente); 
	$this->db->like('t_incidencia.fecha',$fecha, 'after'); 
	$query=$this->db->get();
	if($query->num_rows != 0){
			
	    foreach($query->result() as $row){
    
		    $this->data[]=array(
				'id_incidencia'=>$row->id_incidencia,
				'cliente'=>$row->nombre_cliente,
				'asunto'=>$row->asunto,
				'detalle'=>$row->detalle,
				'estado'=>$row->nombre_estado,
				'fecha_ini'=>$row->fecha,
				'fecha_final'=>$row->fecha_final,
				'ingeniero'=>$row->nombre,
				'ans'=>$row->ans,
				'dias'=>$row->dias,
				'horas'=>$row->horas
			   );
	    }
	    
	    return $this->data;
	}
	
    }
    
    public function reporte_avencido($anio,$mes){
	
	$fecha=$anio.'-'.$mes;
	
	$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.detalle,t_estado.nombre_estado,
	t_incidencia.fecha,t_incidencia.fecha_final,t_ingeniero.nombre,t_ans.ans,t_ans.dias,t_ans.horas,t_cliente.nombre_cliente
	');
	$this->db->from('t_incidencia');
	$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
	$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
	$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
	$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
	$this->db->join('t_ans', 't_ans.id_incidencia = t_incidencia.id_incidencia');
	$this->db->like('t_ans.ans', 'No cumple'); 
	$this->db->like('t_incidencia.fecha',$fecha, 'after'); 
	$query=$this->db->get();
	if($query->num_rows != 0){
			
	    foreach($query->result() as $row){
    
		    $this->data[]=array(
				'id_incidencia'=>$row->id_incidencia,
				'cliente'=>$row->nombre_cliente,
				'asunto'=>$row->asunto,
				'detalle'=>$row->detalle,
				'estado'=>$row->nombre_estado,
				'fecha_ini'=>$row->fecha,
				'fecha_final'=>$row->fecha_final,
				'ingeniero'=>$row->nombre,
				'ans'=>$row->ans,
				'dias'=>$row->dias,
				'horas'=>$row->horas
			   );
	    }
	    
	    return $this->data;
	}
	
    }
    
    
    public function reporte_acumple($anio,$mes){
	
	$fecha=$anio.'-'.$mes;
	
	$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.detalle,t_estado.nombre_estado,
	t_incidencia.fecha,t_incidencia.fecha_final,t_ingeniero.nombre,t_ans.ans,t_ans.dias,t_ans.horas,t_cliente.nombre_cliente
	');
	$this->db->from('t_incidencia');
	$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
	$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
	$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
	$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
	$this->db->join('t_ans', 't_ans.id_incidencia = t_incidencia.id_incidencia');
	$this->db->like('t_ans.ans', 'Cumple','after'); 
	$this->db->like('t_incidencia.fecha',$fecha, 'after'); 
	$query=$this->db->get();
	if($query->num_rows != 0){
			
	    foreach($query->result() as $row){
    
		    $this->data[]=array(
				'id_incidencia'=>$row->id_incidencia,
				'cliente'=>$row->nombre_cliente,
				'asunto'=>$row->asunto,
				'detalle'=>$row->detalle,
				'estado'=>$row->nombre_estado,
				'fecha_ini'=>$row->fecha,
				'fecha_final'=>$row->fecha_final,
				'ingeniero'=>$row->nombre,
				'ans'=>$row->ans,
				'dias'=>$row->dias,
				'horas'=>$row->horas
			   );
	    }
	    
	    return $this->data;
	}
	
    }
    
    public function reporte_aingeniero($anio,$mes,$ingeniero){
	
	$fecha=$anio.'-'.$mes;
	
	$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.detalle,t_estado.nombre_estado,
	t_incidencia.fecha,t_incidencia.fecha_final,t_ingeniero.nombre,t_ans.ans,t_ans.dias,t_ans.horas,t_cliente.nombre_cliente
	');
	$this->db->from('t_incidencia');
	$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
	$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
	$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
	$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
	$this->db->join('t_ans', 't_ans.id_incidencia = t_incidencia.id_incidencia');
	$this->db->where('t_incidencia.id_ingeniero', $ingeniero); 
	$this->db->like('t_incidencia.fecha',$fecha, 'after'); 
	$query=$this->db->get();
	if($query->num_rows != 0){
			
	    foreach($query->result() as $row){
    
		    $this->data[]=array(
				'id_incidencia'=>$row->id_incidencia,
				'cliente'=>$row->nombre_cliente,
				'asunto'=>$row->asunto,
				'detalle'=>$row->detalle,
				'estado'=>$row->nombre_estado,
				'fecha_ini'=>$row->fecha,
				'fecha_final'=>$row->fecha_final,
				'ingeniero'=>$row->nombre,
				'ans'=>$row->ans,
				'dias'=>$row->dias,
				'horas'=>$row->horas
			   );
	    }
	    
	    return $this->data;
	}
	
    }
}
