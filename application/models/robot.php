<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Robot extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_incidencia';
	
		
    public function __construct(){  parent::__construct(); }
    
    
    
    public function cambiar_hora_ini(){
		
		$this->db->select('*');
		$this->db->from('t_incidencia');
		 // para que no se repitan los registros
		$query=$this->db->get();
		if($query->num_rows != 0){
			foreach($query->result() as $row){    
                $arreglo=array(
                         'id_incidencia'=>$row->id_incidencia,
                         'fecha_inicial'=>$row->fecha
                );
    			
                $this->buscar_incidencia($arreglo);
			}
		}
    }
    
    public function buscar_incidencia($arreglo=array()){
        
        echo $arreglo['fecha_incial'];exit;
        
        date_default_timezone_set("America/Bogota");

        $horas_laborales=array(8,9,10,11,12,13,14,15,16,17,18);
        
        $fecha=$arreglo['fecha_inicial'];
        $hora_c=strtotime($fecha);
        $hora_c=date("H",$hora_c);
        
        
        
        $fecha_tope=explode(" ",$fecha);
        $fecha_tope=$fecha_tope[0].' 8:00:00';
        
        
        
        if(!in_array($hora_c, $horas_laborales)){
            $fecha= $fecha_tope;
        }

        $fecha_hora=explode(" ",$fecha);
        $fecha_contar=strtotime($fecha);
        $fecha_contar=date('j', $fecha_contar);
        $arreglo_fecha=explode("-", $fecha);
        $i=$fecha_contar;
        $dia_festivo= strtotime($fecha);
        $dia_festivo=date( 'w', $dia_festivo);
        $dia_festivo= (int)$dia_festivo;
        $this->db->select('*');
        $this->db->from('t_festivos');
        $this->db->like('t_festivos.fecha_festivo',$fecha, 'after'); 
        $query=$this->db->get();

        if($query->num_rows != 0):
            $dia_festivo=0;
        endif;
            
        while($dia_festivo == 6 || $dia_festivo == 0 ):
        
            $dia_extra="".$arreglo_fecha[0]."-".$arreglo_fecha[1]."-".++$i;
            $dia_extra=strtotime($dia_extra);
            $dia_extra=date('Y-m-d '.$fecha_hora[1],$dia_extra);
            
            $this->db->select('*');
        	$this->db->from('t_festivos');
        	$this->db->like('t_festivos.fecha_festivo', $dia_extra, 'after'); 
        	$query=$this->db->get();
                if($query->num_rows != 0):
                    $dia_festivo=0;
                else:
                    
                    $dia_festivo= strtotime($dia_extra);
                    $dia_festivo=date( 'w', $dia_festivo);
                    
                    $dia_festivo= (int)$dia_festivo;
                
                endif;
            endwhile;
            
            if($dia_extra != NUL){
                
                $insertar=array(
                    'id_incidencia'=>$arreglo['id_incidencia'],
                    'fecha_inicial_original'=>$arreglo['fecha_inicial'],
                    'fecha_inicial'=>$dia_extra
                            
                    );
            
            
            
                if( $this->db->insert( 't_pruebas', $insertar )  )
                 return true;
                else
                 return false;
                
                
            }else{
                
                $insertar=array(
                    'id_incidencia'=>$arreglo['id_incidencia'],
                    'fecha_inicial_original'=>$arreglo['fecha_inicial'],
                    'fecha_inicial'=>$fecha
                    
                    );
            
                if( $this->db->insert( 't_pruebas', $insertar )  )
                 return true;
                else
                 return false;
                
                
            }
                    
          
    }
    
    
}