<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trigger extends CI_Model {


// Table usage	
	private $table = 't_trigger';
        
// Save data	
	private $data = array();
	
		
    public function __construct(){  parent::__construct(); }
    
    
    public function crear( $id, $minutos){
           
  
           $data = array(
                'id_incidencia' =>$id,
                'minutos' =>$minutos
            );	
            
            // Crear registro	
            if( $this->db->insert( $this->table, $data )  )
                return true;
             else
                return false;  
          
    }
    
    public function consultar_incidente($id= null){
        
        $this->db->select('t_trigger.id_incidencia,t_trigger.minutos');
        $this->db->from($this->table);
        $this->db->where('id_incidencia', $id); 
        $query=$this->db->get();
        if($query->num_rows != 0){
            
           foreach ( $query->result() as $row ){
				
                $this->data[] = array( 
                
                        'minutos' => $row->minutos						
                );  
	    }
            
            return $this->data;
        }else
            return 0;
    }
    
    public function eliminar( $id = null ){
		
		// Validar id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		// Eliminar registro					
	    if( $this->db->delete( $this->table, array( 'id_incidencia' => $id ) ) )
        	return true;
            else
        	return false;
        
		
    }
}
?>