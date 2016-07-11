<?php error_reporting(E_ALL); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ans extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_ans';
	
		
    public function __construct(){  parent::__construct(); }
    
    
    public function buscar_clientes(){
		
	$this->db->select('t_incidencia.id_cliente');
	$this->db->from('t_incidencia');
	$this->db->group_by('id_cliente'); 
	 // para que no se repitan los registros
	$query=$this->db->get();
	if($query->num_rows != 0){
		
		foreach($query->result() as $row){
			$this->organizar_incidentes($row->id_cliente);
			 
		}
	}
    }
    
    
    
    public function organizar_incidentes($cliente = null){
		
	
	date_default_timezone_set("America/Bogota");

	$actual= time();
	$fecha_actual=date( 'Y-m-d H:i:s', $actual );
	//$mes=date( 'Y-m', $actual );
	$mes='2014-1';
	
	$this->db->select('t_incidencia.id_incidencia,t_incidencia.id_estado,t_incidencia.id_condicion,t_incidencia.fecha,
	t_incidencia.fecha_final,t_incidencia.fecha_prioridad,t_incidencia.id_cliente');
	$this->db->from('t_incidencia');
	$this->db->where('id_cliente', $cliente);
	$this->db->like('t_incidencia.fecha',$mes, 'after'); 
	$query=$this->db->get();
	if($query->num_rows != 0){
		
	    foreach($query->result() as $row){
		    
		    
		    switch($row->id_estado){
			    
			    case 1:
				    $arreglo1=array(
					    'id_incidencia'=>$row->id_incidencia,
					    'id_condicion'=>$row->id_condicion,
					    'fecha_incial'=>$row->fecha,
					    'fecha_fin'=>$fecha_actual,
					    'id_cliente'=>$row->id_cliente	
				    );
				    
				    $this->cambiar_condicion1($arreglo1);
			    break;
		    
			    case 2:
				    $arreglo2=array(
					    'id_incidencia'=>$row->id_incidencia,
					    'id_condicion'=>$row->id_condicion,
					    'fecha_incial'=>$row->fecha,
					    'fecha_fin'=>$row->fecha_final,
					    'id_cliente'=>$row->id_cliente
				    );
				    
				    $this->cambiar_condicion2($arreglo2);
			    break;
			    
			    case 3:
			    case 4:
				    $arreglo3=array(
					    'id_incidencia'=>$row->id_incidencia,
					    'id_condicion'=>$row->id_condicion,
					    'fecha_incial'=>$row->fecha,
					    'fecha_prioridad'=>$row->fecha_prioridad,
					    'fecha_fin'=>$row->fecha_final,
					    'id_cliente'=>$row->id_cliente	
				    );
				    $this->cambiar_condicion3($arreglo3);
			    break;
			    
		    }
		    
	    }
	}
    }
    
    
    public function cambiar_condicion1($arreglo=array()){
		
	$this->load->model('mensual');
	
	
	$this->load->library('fechas');
	
	$prueba=$this->fechas->verificar($arreglo['fecha_incial'],$arreglo['fecha_fin']);
	
	
	if($prueba['dias'] !=0){
		
		
		$this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']);
		
		
	}else{
		
		$this->load->model(  'tiempoprioridads'  );
		
		$tiempo = $this->tiempoprioridads->cliente_hora($arreglo['id_cliente']);
		
		$contador=0;
		
		foreach ($tiempo as $v1) {
			foreach ($v1 as $v2) {
				    
				$sort[$contador]=$v2;
				
				$contador++;	    
			}
		}
		
		arsort($sort);

		foreach ($sort as $clave=> $valor ) {
		     
		     $arreglo[]=array(
			 'tiempo'=>$valor		    
			);
			 
		}
		
		
		$fecha_muy_alta=$arreglo[3]['tiempo']* 60;
		$fecha_alta=$arreglo[2]['tiempo']*60;
		$fecha_media=$arreglo[1]['tiempo']*60;
		$fecha_baja=$arreglo[0]['tiempo']*60;
		
		$relacionar=($prueba['horas']*60)+$prueba['minutos'];
		
		
		switch($arreglo['id_condicion']):
		
		    case 4: //muy alta
			    
			    if($relacionar > $fecha_muy_alta){
				    
				    $prueba['dias']=0;
				    
			    
				    if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true)
				       break;
				       
			    }else{
				    
				    if($this->mensual->cumple($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']))
				    break;
				    
			    }	    
	    
		    case 1: //alta
			    if($relacionar > $fecha_alta){
				    
				    $prueba['dias']=0;
				    
				    
				    if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
				       break;
				       
			    }else{
				    
				    if($this->mensual->cumple($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']))
				    break;
				    
			    }
		    case 2: //media
			    if($relacionar > $fecha_media){
				    
				    $prueba['dias']=0;
				    
				    
				    if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
				       break;
					    
			    }else{
				    
				    if($this->mensual->cumple($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']))
				    break;
				    
			    }
				    
		    case 3: //baja
			    if($relacionar > $fecha_baja){
				    
				    $prueba['dias']=0;
				    
				    
				   if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
				    break;
				    
			    }else{
				    
				    if($this->mensual->cumple($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']))
				    break;
				    
			    }
	    endswitch;
	    
	    return true;		
	}

    }
    
    
    public function cambiar_condicion2($arreglo=array()){
		
		
	$this->load->library('fechas');
	
	$prueba=$this->fechas->verificar($arreglo['fecha_incial'],$arreglo['fecha_fin']);
	
	$this->load->model('mensual');
	
	if($prueba['dias'] !=0){
		
		
	    $this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']);
		
		
	}else{
		
	    $this->load->model(  'tiempoprioridads'  );
	    
	    $tiempo = $this->tiempoprioridads->cliente_hora($arreglo['id_cliente']);
	    
	    
	    $contador=0;
	    
	    
	    foreach ($tiempo as $v1) {
		    
		    foreach ($v1 as $v2) {
				
			    $sort[$contador]=$v2;
			    
			    $contador++;	    
		    }
	    }
	    
	    if($sort == null){
		    
		    echo $arreglo['id_cliente'];
		    
	    }
	    
	    arsort($sort);

	    foreach ($sort as $clave=> $valor ) {
		 
		 $arreglo[]=array(
		     'tiempo'=>$valor		    
		    );
		     
	    }
	    
	    
	    $fecha_muy_alta=$arreglo[3]['tiempo']* 60;
	    $fecha_alta=$arreglo[2]['tiempo']*60;
	    $fecha_media=$arreglo[1]['tiempo']*60;
	    $fecha_baja=$arreglo[0]['tiempo']*60;
	    
	    $relacionar=($prueba['horas']*60)+$prueba['minutos'];
	    
	    
	    switch($arreglo['id_condicion']):
	    
	    
		case 4: //muy alta
			
			if($relacionar > $fecha_muy_alta){
				
				$prueba['dias']=0;
				
				
				if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias']=0,$prueba['horas'],$prueba['minutos']) == true )
				   break;
				   
			}else{
				
				if($this->mensual->cumple($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']) == true )
				   break;
			}
			   
				
		case 1: //alta
			if($relacionar > $fecha_alta){
				
				$prueba['dias']=0;
				
				if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
				   break;
				   
			}else{
				
				if($this->mensual->cumple($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']) == true )
				   break;
			}
		case 2: //media
			if($relacionar > $fecha_media){
				
				$prueba['dias']=0;
				
				
				if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
				   break;
				   
			}else{
				
				if($this->mensual->cumple($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']) == true )
				   break;
			}
				
		case 3: //baja
			if($relacionar > $fecha_baja){
				
				$prueba['dias']=0;
				
				if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
				   break;
				   
			}else{
				
				if($this->mensual->cumple($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']) == true )
				   break;
			}
	    endswitch;
	    
	    return true;		
		
	}
	    
	    
    }
    
    
    public function cambiar_condicion3($arreglo=array()){
		
	
	$this->load->library('fechas');

	$prueba=$this->fechas->verificar($arreglo['fecha_incial'],$arreglo['fecha_fin']);
	
	$this->load->model('mensual');
	
	if($prueba['dias'] !=0){
		
		
		$this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']);
		
		
	}else{
		
		$this->load->model(  'tiempoprioridads'  );
	
		$tiempo = $this->tiempoprioridads->cliente_hora($arreglo['id_cliente']);

		
		$contador=0;

		if (is_array($tiempo))
                {
		  foreach ($tiempo as $v1) {
			foreach ($v1 as $v2) {
				    
				$sort[$contador]=$v2;
				
				$contador++;	    
			}
		  }
                }
		
               
	        //arsort($sort);
                
                
              
		/*foreach ( $sort as $key => $val ) {
		     
		     $arreglo[]=array(
			 'tiempo'=>$valor		    
			);
			 
                      
		}*/
		
		
		$fecha_muy_alta=4* 60;
		$fecha_alta=10*60;
		$fecha_media=16*60;
		$fecha_baja=24*60;
		
		$relacionar=($prueba['horas']*60)+$prueba['minutos'];
		
		
		switch($arreglo['id_condicion']):
		
			case 4: //muy alta
				
				if($relacionar > $fecha_muy_alta){
					
					$arreglo['id_incidencia']=0;
					
					
					if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
					   break;
					   
				}else{
					
					if($this->mensual->pausado($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']) == true )
					   break;
				}
				   
					
			case 1: //alta
				if($relacionar > $fecha_alta){
					
					$arreglo['id_incidencia']=0;
					
					
					if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
					   break;
					   
				}else{
					
					if($this->mensual->pausado($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']) == true )
					   break;
				}
			case 2: //media
				if($relacionar > $fecha_media){
					
					$arreglo['id_incidencia']=0;
					
					
					if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
					   break;
					   
				}else{
					
					if($this->mensual->pausado($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']) == true )
					   break;
				}
					
			case 3: //baja
				if($relacionar > $fecha_baja){
					
					$arreglo['id_incidencia']=0;
					
					
					if($this->mensual->no_cumple($arreglo['id_incidencia'],$prueba['dias'],$prueba['horas'],$prueba['minutos']) == true )
					   break;
					   
				}else{
					
					if($this->mensual->pausado($arreglo['id_incidencia'],$prueba['horas'],$prueba['minutos']) == true )
					   break;
				}
		endswitch;
		
		return true;		
		
	}
		
			
    }
	
	
}