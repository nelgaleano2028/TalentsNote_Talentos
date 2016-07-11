<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exp2{
	
	private $header = '
	
		<table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
		  
			  <tr style="background-color:#ABABAB;">
				  <td>Codigo</td>
				  <td>Estado</td>
				  <td>Ingeniero</td>
				  <td>Descripcion del Caso</td>
				  <td>Categoria</td>
				  <td>Detalle</td>
				  <td>Asunto del Caso</td
				  <td>fecha</td>
				  <td>fecha final</td>
				  <td>Notas del Caso (Solucion)</td>
						  
			  </tr>
		 	
	';	
	
	private $body = '';
	
	public function onlyExport( $data = array() ){
		
		
		if( empty( $data ) ){ $this->body = '<tr><td colspan="8">No hay registros</td> </tr>'; return $this->header.$this->body; }
		
			$i=0;
			$total=count($data)+4;
			for($i; $i<=$total; $i++){
				 
				$this->body .='	
			
				<tr>
				 
				  <td class="center" style="background-color:#E5E5E5;">'. @$data[$i]['id_incidencia'] .'</td>
				  <td class="center">'. @$data[$i]['nombre_estado'] .'</td>
				  <td class="center" style="background-color:#E5E5E5;">'. utf8_decode(@$data[$i]['nombre']) .'</td>
				  <td class="center">'. @$data[$i]['descripcion'] .'</td>
				  <td class="center" style="background-color:#E5E5E5;">'.utf8_decode(@$data[$i]['opcion']).'</td>
				  <td class="center">'. @$data[$i]['asunto'] .'</td>
				  <td class="center" style="background-color:#E5E5E5;">'.utf8_decode(@$data[$i]['detalle']).'</td>
				  <td class="center">'. @$data[$i]['fecha'] .'</td>
				  <td class="center" style="background-color:#E5E5E5;">'.@$data[$i]['fecha_final'] .'</td>
				  <td class="center" >'.utf8_decode(@$data[$i]['notas']).'</td>
				  
			  </tr>'; 
				 
			 }
			 
		return $this->header.$this->body;
		 		
	}
}
?>