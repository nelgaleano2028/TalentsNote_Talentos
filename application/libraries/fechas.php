<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Fechas{
    
    private $tiempo=array();   
    
    public function __construct(){
	$this->CI= & get_instance(); /*podemos acceder a consultas sql*/	
    }
    

    public function verificar( $fecha_vencida, $fecha_hoy){
        
        $arreglo_mes_anio=explode("-", $fecha_vencida);
        $arreglo_mes_anio2=explode("-", $fecha_hoy);
        
        $fecha_vencida1=strtotime($fecha_vencida);
        $fecha_vencidac=date('j', $fecha_vencida1);
        $fecha_vencidac= (int)$fecha_vencidac;  //trae solo el dia
        
        
        $fecha_hoy1=strtotime($fecha_hoy);
        $fecha_hoyc=date('j', $fecha_hoy1);
        $fecha_hoyc= (int)$fecha_hoyc;   //trae solo el dia
        
        $fecha_mes_v=date('n',$fecha_vencida1); // traes solo el mes
        $fecha_mes_h=date('n', $fecha_hoy1); // traes solo el mes
        
        $fecha_anio_ven=date('Y',$fecha_vencida1);
        $fecha_anio_ven=(int)$fecha_anio_ven;
        
        $fecha_anio_hoy=date('Y',$fecha_hoy1);
        $fecha_anio_hoy=(int)$fecha_anio_hoy;
        
        $acu_minutos =0;
        
        for($x=$fecha_anio_ven; $x<=$fecha_anio_hoy; $x++){
            
            if($x==$fecha_anio_ven and $x== $fecha_anio_hoy){ //el incidente se resuelve el mismo año
                
                for($j=$fecha_mes_v; $j<= $fecha_mes_h; $j++ ){
                        
                        
                    if($j==$fecha_mes_v and $j== $fecha_mes_h ){ //esto sucede porque hay casos que se resuelven el mismo mes
                            
                        for($i=$fecha_vencidac; $i <= $fecha_hoyc; $i++ ){ //inicio del for $i
        
                            $dia_extra="".$arreglo_mes_anio[0]."-".$arreglo_mes_anio[1]."-".$i;
                            $festivo=strtotime($dia_extra);
                            $festivo=date('Y-m-d',$festivo);
                            
                            $this->CI->db->select('fecha_festivo');
                            $this->CI->db->from('t_festivos');
                            $this->CI->db->like('fecha_festivo',$festivo, 'after');
                            $query=$this->CI->db->get();
                            if($query->num_rows()!= 0)
                                continue;
                            
                            $dia_extra= strtotime($dia_extra);
                            $dia_extra=date( 'w', $dia_extra);
                            $dia_extra= (int)$dia_extra;
                            
                            
                            
                            if($dia_extra == 6 ||  $dia_extra == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                            continue;
                            
                                    
                            if($i== $fecha_vencidac and $i== $fecha_hoyc){ // esto se debe porque hay incidentes que se resuelven el mismo dia o comparar el mismo dia
                            
                                $fecha_vencida_h=explode(" ",$fecha_vencida);
                                $fecha_vencida_h=explode(":",$fecha_vencida_h[1]);
                                
                                $fecha_hoy_h=explode(" ",$fecha_hoy);
                                $fecha_hoy_h=explode(":",$fecha_hoy_h[1]);
                                
                                $horas= abs($fecha_vencida_h[0] - $fecha_hoy_h[0]);
                                $minutos=abs($fecha_vencida_h[1] - $fecha_hoy_h[1]);
                                
                                
                                $acu_minutos =($horas* 60)+ $minutos;
                                            
                            }elseif($i==$fecha_vencidac and $i != $fecha_hoyc){ // para calcular el dia en que entro el incidente
                                    
                                $fecha_vencida_h=explode(" ",$fecha_vencida);
                                $fecha_vencida_h=explode(":",$fecha_vencida_h[1]);
                                $horas= abs($fecha_vencida_h[0] - 17); // restar el incidente desde la hora que entro hasta las 18:00:00 horas
                                $minutos=(int)$fecha_vencida_h[1];
                                
                                $acu_minutos = $acu_minutos + (($horas* 60) -  $minutos);
                                    
                                            
                            }elseif($i > $fecha_vencidac and  $i < $fecha_hoyc){
                                    
                                $acu_minutos = $acu_minutos + ( 9 * 60); // se suma 9 porque solo se trabajan 9 horas
                                            
                            }elseif($i == $fecha_hoyc){
                                    
                                $fecha_hoy_h=explode(" ",$fecha_hoy);
                                $fecha_hoy_h=explode(":",$fecha_hoy_h[1]);
                                $horas=abs($fecha_hoy_h[0] - 8); // ejemplo un incidente se cierre el dia de hoy a las 15 horas entonces se resta desde las 8:0::00 horas hasta 15 osea 8 -15 = 7 horas
                                                
                                $acu_minutos = $acu_minutos + (($horas * 60)+  $fecha_hoy_h[1]);	
                            }		
        
                        }// fin del for $i
                                    
                    }elseif($j==$fecha_mes_v and  $j != $fecha_mes_h){ // incidente debe contar el mes que entro
                    
                        $fecha_mes_vencido=date('t',$fecha_vencida1);
                        $fecha_mes_vencido=(int)$fecha_mes_vencido;
                
                        for($i=$fecha_vencidac; $i <= $fecha_mes_vencido; $i++ ){ //inicio del for $i
          
                            $dia_extra="".$arreglo_mes_anio[0]."-".$arreglo_mes_anio[1]."-".$i;
                            $festivo=strtotime($dia_extra);
                            $festivo=date('Y-m-d',$festivo);
                            
                            $this->CI->db->select('fecha_festivo');
                            $this->CI->db->from('t_festivos');
                            $this->CI->db->like('fecha_festivo',$festivo, 'after');
                            $query=$this->CI->db->get();
                            if($query->num_rows()!= 0)
                                continue;
                            
                            $dia_extra= strtotime($dia_extra);
                            $dia_extra=date( 'w', $dia_extra);
                            $dia_extra= (int)$dia_extra;
                            
                            if($dia_extra == 6 ||  $dia_extra == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                            continue;
                            
                                    
                            if($i==$fecha_vencidac){ // para calcular el dia en que entro el incidente
                                    
                                $fecha_vencida_h=explode(" ",$fecha_vencida);
                                $fecha_vencida_h=explode(":",$fecha_vencida_h[1]);
                                $horas= abs($fecha_vencida_h[0] - 17); // restar el incidente desde la hora que entro hasta las 17:00:00 horas. Son 17 porque se da una hora de almuerzo al inginiero de soporte
                                $fecha_vencida_h=(int)$fecha_vencida_h[1];
                      
                                $acu_minutos = $acu_minutos + (($horas* 60) - $fecha_vencida_h);
                                            
                            }elseif($i > $fecha_vencidac and  $i <= $fecha_hoyc){
                                    
                                $acu_minutos = $acu_minutos + (9 * 60); // se suma 9 porque son las horas de 8 am hasta las 6 pm       
                                            
                            }	
                        }// fin del for $i
                            
                    } elseif($j > $fecha_mes_v and  $j < $fecha_mes_h){
                            
                        $fecha_mes_c="".$arreglo_mes_anio[0]."-".$j."-01";
                        $fecha_mes_c=strtotime($fecha_mes_c);
                        $fecha_mes_c=date('t',$fecha_mes_c);
                        $fecha_mes_c=(int)$fecha_mes_c;
                       
                       for($l=1; $l <= $fecha_mes_c; $l++ ){
       
                            $dia_extra2="".$arreglo_mes_anio[0]."-".$j."-".$l;
                            $festivo2=strtotime($dia_extra2);
                            $festivo2=date('Y-m-d',$festivo2);
                            
                            $this->CI->db->select('fecha_festivo');
                            $this->CI->db->from('t_festivos');
                            $this->CI->db->like('fecha_festivo',$festivo2, 'after');
                            $query=$this->CI->db->get();
                            if($query->num_rows()!= 0)
                                continue;
                            
                            $dia_extra2= strtotime($dia_extra2);
                            $dia_extra2=date( 'w', $dia_extra2);
                            $dia_extra2= (int)$dia_extra2;
                            
                            if($dia_extra2 == 6 ||  $dia_extra2 == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                            continue;
                             
                            $acu_minutos = $acu_minutos + (9 * 60);
                               
                       }
                    
                    }elseif($j==$fecha_mes_h){
                            
                        for($k=1; $k <= $fecha_hoyc; $k++ ){
                                
                                
                            $dia_extra3="".$arreglo_mes_anio2[0]."-".$arreglo_mes_anio2[1]."-".$k;
                            $festivo3=strtotime($dia_extra3);
                            $festivo3=date('Y-m-d',$festivo3);
                            
                            $this->CI->db->select('fecha_festivo');
                            $this->CI->db->from('t_festivos');
                            $this->CI->db->like('fecha_festivo',$festivo3, 'after');
                            $query=$this->CI->db->get();
                            if($query->num_rows()!= 0)
                                continue;
                            
                            $dia_extra3= strtotime($dia_extra3);
                            $dia_extra3=date( 'w', $dia_extra3);
                            $dia_extra3= (int)$dia_extra3;
                                
                                
                           if($dia_extra3 == 6 ||  $dia_extra3 == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                                continue;
                                
                            if($k < $fecha_hoyc){
                                    
                                $acu_minutos = $acu_minutos + (9 * 60);
                                    
                            }elseif($k  == $fecha_hoyc ){
                                    
                                $fecha_hoy_h=explode(" ",$fecha_hoy);
                                $fecha_hoy_h=explode(":",$fecha_hoy_h[1]);
                                $horas=abs($fecha_hoy_h[0] - 8); // ejemplo un incidente se cierre el dia de hoy a las 15 horas entonces se resta desde las 8:00:00 horas hasta 15 osea 8 -15 = 7 horas
                                        
                                $acu_minutos = $acu_minutos + (($horas * 60)+  $fecha_hoy_h[1]);
                                    
                            }
                        }					
                    }
                }
                    
            }elseif($x == $fecha_anio_ven and $x!=$fecha_anio_hoy){// se debe contar el año que entro el incidente
            
                for($j=$fecha_mes_v; $j<=12 ; $j++ ){
                        
                    if($j==$fecha_mes_v ){ // incidente debe contar el mes que entro
                    
                    
                        $fecha_mes_vencido=date('t',$fecha_vencida1);
                        $fecha_mes_vencido=(int)$fecha_mes_vencido;
        
                        for($p=$fecha_vencidac; $p <= $fecha_mes_vencido; $p++ ){ //inicio del for $i
                        
                            $dia_extra4="".$arreglo_mes_anio[0]."-".$arreglo_mes_anio[1]."-".$p;
                            $festivo4=strtotime($dia_extra4);
                            $festivo4=date('Y-m-d',$festivo4);
                            
                            $this->CI->db->select('fecha_festivo');
                            $this->CI->db->from('t_festivos');
                            $this->CI->db->like('fecha_festivo',$festivo4, 'after');
                            $query=$this->CI->db->get();
                            if($query->num_rows()!= 0)
                                continue;
                            
                            $dia_extra4= strtotime($dia_extra4);
                            $dia_extra4=date( 'w', $dia_extra4);
                            $dia_extra4= (int)$dia_extra4;
                            
                            
                            if($dia_extra4 == 6 ||  $dia_extra4 == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                            continue;
                            
                                    
                            if($p==$fecha_vencidac){ // para calcular el dia en que entro el incidente
                                    
                                $fecha_vencida_h=explode(" ",$fecha_vencida);
                                $fecha_vencida_h=explode(":",$fecha_vencida_h[1]);
                                $horas= abs($fecha_vencida_h[0] - 17); // restar el incidente desde la hora que entro hasta las 17:00:00 horas. Son 17 porque se da una hora de almuerzo al inginiero de soporte
                                $fecha_vencida_h=(int)$fecha_vencida_h[1];
                      
                                $acu_minutos = $acu_minutos + (($horas* 60) - $fecha_vencida_h);
                                    
                                    
                                            
                            }elseif($p > $fecha_vencidac and  $p <=$fecha_mes_vencido){
                           
                                $acu_minutos = $acu_minutos + (9 * 60); // se suma 9 porque son las horas de 8 am hasta las 6 pm
                                          
                                  
                            }	
                                    
                        }// fin del for 
                               
                    }elseif($j > $fecha_mes_v and  $j <= 12){
                            
                        $fecha_mes_c="".$arreglo_mes_anio[0]."-".$j."-01";
                        $fecha_mes_c=strtotime($fecha_mes_c);
                        $fecha_mes_c=date('t',$fecha_mes_c);
                        $fecha_mes_c=(int)$fecha_mes_c;
                       
                        for($n=1; $n <= $fecha_mes_c; $n++ ){
                               
                            $dia_extra2="".$arreglo_mes_anio[0]."-".$j."-".$n;
                            $festivo=strtotime($dia_extra2);
                            $festivo=date('Y-m-d',$festivo);
                            
                            $this->CI->db->select('fecha_festivo');
                            $this->CI->db->from('t_festivos');
                            $this->CI->db->like('fecha_festivo',$festivo, 'after');
                            $query=$this->CI->db->get();
                            if($query->num_rows()!= 0)
                                continue;
                            
                            $dia_extra2= strtotime($dia_extra2);
                            $dia_extra2=date( 'w', $dia_extra2);
                            $dia_extra2= (int)$dia_extra2;
                            
                           
                            
                            if($dia_extra2 == 6 ||  $dia_extra2 == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                            continue;
                             
                            $acu_minutos = $acu_minutos + (9 * 60);
                          
                        }	
                    }    
                }
                    
            }elseif($x > $fecha_anio_ven and  $x < $fecha_anio_hoy){
                     
                for($m=1; $m<= 12; $m++ ){
                           
                    $fecha_mes_c="".$x."-".$m."-01";
                    $fecha_mes_c=strtotime($fecha_mes_c);
                    $fecha_mes_c=date('t',$fecha_mes_c);
                    $fecha_mes_c=(int)$fecha_mes_c;
                   
                   
                    for($z=1; $z <= $fecha_mes_c; $z++ ){
   
                        $dia_extra2="".$x."-".$m."-".$z;
                        $festivo=strtotime($dia_extra2);
                        $festivo=date('Y-m-d',$festivo);
                        
                        $this->CI->db->select('fecha_festivo');
                        $this->CI->db->from('t_festivos');
                        $this->CI->db->like('fecha_festivo',$festivo, 'after');
                        $query=$this->CI->db->get();
                        if($query->num_rows()!= 0)
                            continue;
                        
                        $dia_extra2= strtotime($dia_extra2);
                        $dia_extra2=date( 'w', $dia_extra2);
                        $dia_extra2= (int)$dia_extra2;
                     
                        if($dia_extra2 == 6 ||  $dia_extra2 == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                        continue;
                        
                        $acu_minutos = $acu_minutos + (9 * 60);
                           
                    }		
                        
                }
                    
            }elseif($x ==$fecha_anio_hoy){//año
            
                for($u=1;$u<=$fecha_mes_h;$u++){//mes
               
                    if($u < $fecha_mes_h){
                            
                        for($o=1; $o <= $fecha_mes_c; $o++ ){
      
                            $dia_extra4="".$x."-".$u."-".$o;
                            $festivo=strtotime($dia_extra4);
                            $festivo=date('Y-m-d',$festivo);
                            
                            $this->CI->db->select('fecha_festivo');
                            $this->CI->db->from('t_festivos');
                            $this->CI->db->like('fecha_festivo',$festivo, 'after');
                            $query=$this->CI->db->get();
                            if($query->num_rows()!= 0)
                                continue;
                            
                            $dia_extra4= strtotime($dia_extra4);
                            $dia_extra4=date( 'w', $dia_extra4);
                            $dia_extra4= (int)$dia_extra4;
                        
                            if($dia_extra4 == 6 ||  $dia_extra4 == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                            continue;
                            
                            $acu_minutos = $acu_minutos + (9 * 60);
 
                        }	    
                    }elseif($u== $fecha_mes_h){
                           
                        for($z=1; $z <= $fecha_hoyc; $z++ ){ //dia
                        
                            $dia_extra5="".$x."-".$u."-".$z;
                            $festivo=strtotime($dia_extra5);
                            $festivo=date('Y-m-d',$festivo);
                            
                            $this->CI->db->select('fecha_festivo');
                            $this->CI->db->from('t_festivos');
                            $this->CI->db->like('fecha_festivo',$festivo, 'after');
                            $query=$this->CI->db->get();
                            if($query->num_rows()!= 0)
                                continue;
                            
                            $dia_extra5= strtotime($dia_extra5);
                            $dia_extra5=date( 'w', $dia_extra5);
                            $dia_extra5= (int)$dia_extra5;
                                  
                                  
                            if($dia_extra5 == 6 ||  $dia_extra5 == 0) // tambien los dias festivos que tiene que consultar en la base de datos
                                continue;
                                  
                            if($z < $fecha_hoyc){
                                    
                                $acu_minutos = $acu_minutos + (9 * 60);
                                    
                            }elseif($z  == $fecha_hoyc ){
                                    
                                $fecha_hoy_h=explode(" ",$fecha_hoy);
                                $fecha_hoy_h=explode(":",$fecha_hoy_h[1]);
                                $horas=abs($fecha_hoy_h[0] - 8); // ejemplo un incidente se cierre el dia de hoy a las 15 horas entonces se resta desde las 8:00:00 horas hasta 15 osea 8 -15 = 7 horas
                                                    
                                $acu = (($horas * 60)+  $fecha_hoy_h[1]);
                            
                            }
                        }//fin del for dia  
                    }     
                }         
            }	
        }
        
        $acu_dias=0;
        $acu_horas=0;
        
        if($acu_minutos > 1440){ // como el acumulador esta en minutos entonces 1440 minutos son 24 horas
            
            while($acu_minutos > 60): 
            
                $acu_minutos= $acu_minutos - 60;
                $acu_horas++;
                    
            endwhile;
            
            while($acu_horas > 24):
    
                $acu_horas= $acu_horas - 24;
                $acu_dias++;
                    
            endwhile;
                    
        }else{
                    
            while($acu_minutos  > 60):
            
                $acu_minutos= $acu_minutos  - 60;
                $acu_horas++;
                    
            endwhile;
            
        }
        
        return  $tiempo[]=array(
                    'dias'=>$acu_dias,
                    'horas'=>$acu_horas,
                    'minutos'=>$acu_minutos           
                );   
    }   
}