<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exp{
	
	private $header = '
	
		<table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
		  	<tr style="background-color:#ABABAB;">
			  	<td>Codigo</td>
			  	<td>Estado</td>
			  	<td>Cliente</td> 
			  	<td>Prioridad</td>
			  	<td>Asunto</td>
			  	<td>Detalle</td>
			  	<td>Empresa</td>
			  	<td>Fecha</td>
			  	<td>Fecha Final</td>		  
		  	</tr>';	
	
	private $body = '';
	private $body2 = '';
	
	private $footer = '';
	
	public function onlyExport( $data = array(),$date=array()){
		
		if( empty( $data ) ){ $this->body = '<tr><td colspan="8">No hay registros</td> </tr>'; return $this->header.$this->body.$this->footer; }
		
		$this->body .='	
			
				<tr >
				  <td>'.$data[0]['id_incidencia'] .'</td>
				  <td>'; 
						  switch( $data[0]['id_estado'] ):
							  
							  case 1:
								  $this->body .= 'Abierto';
							  break;
							  
							  case 2:
								  $this->body .= 'Cerrado';
							  break;
							  
						  endswitch;
				  $this->body .=' </td>
				  <td>'; 
					  
					  if( !empty( $data[0]['contacto'] ) ): foreach( $data[0]['contacto'] as $contacto ):
					  
						  $this->body .= utf8_decode($contacto['nombre']).'<br>'; 
					  
					  endforeach; endif; 
					  
				  
				  $this->body .=' </td>
				  <td class="center">';
						  switch( $data[0]['id_condicion'] ):
							  
							  case 1:
																													  
								  $this->body .= 'Alta';
									  
							  break;
							  
							  case 2:
																	  
								  $this->body .= 'Media';
									  
							  break;
							  
							  case 3:
								  
								  $this->body .= 'Baja';
									  
							  break;
							  
							   case 4:
								  
								  $this->body .= 'Muy alta';
									  
							  break;
							  
						  endswitch;
						  
					   $this->body .= '</td>
				  <td class="center">'. utf8_decode($data[0]['asunto']) .'</td>
				  <td class="center">'. utf8_decode($data[0]['detalle']) .'</td>
				  <td class="center">'. utf8_decode($data[0]['cliente']).'</td>
				  <td class="center">'.$data[0]['fecha'].'</td>
				  <td class="center">'.$data[0]['fecha_final'].'</td>
					
			  </tr>
		  </table>
		  <br>';
		  $this->body2.='
				 	<table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
					  	<tr>
						  	<td>Fecha</td>
						  	<td>Nota</td>
						  	<td>Usuario</td> 
					  	</tr>';
		if(!empty($date) ){
			foreach ($date as $fila){
				$this->body2.='
					  	<tr>
						  	<td>'.utf8_decode($fila['fecha']).'</td>
						  	<td>'.strip_tags(utf8_decode($fila['notas'])).'</td>
						  	<td>'.$fila['contacto'].$fila['ingeniero'].'</td> 
					  	</tr>';	
			}
		  	
		}else{
			$this->body2.= '<tr><td colspan="3">No hay registros</td> </tr> </table>'; 
		}

		return $this->header.$this->body.'<br>'.$this->body2;
		 		
	}
	
	public function fullExport($data = array(), $date=array()){
		
		if( empty( $data ) ){ $this->body = '<tr><td colspan="8">No hay registros</td> </tr>'; return $this->header.$this->body.$this->footer; }
		
		foreach( $data as $value ){
		
				$this->body .='	
					
					<tr >
					  <td>'.$value['id_incidencia'] .'</td>
					  <td>'; 
							  switch( $value['id_estado'] ):
								  case 1:
									  $this->body .= 'Abierto';
								  break;
								  
								  case 2:
									  $this->body .= 'Cerrado';
								  break;
								  
							  endswitch;
					  $this->body .=' </td>
					  <td>'; 
						  
						  if( !empty( $value['contacto'] ) ): foreach( $value['contacto'] as $contacto ):
						  
							  $this->body .= $contacto['nombre'].'<br>'; 
						  
						  endforeach; endif; 
						  
					  
					  $this->body .=' </td>
					  <td class="center">';
																							  
							  
							  switch( $value['id_condicion'] ):
								  
								  case 1:
																														  
									  $this->body .= 'Alta';
										  
								  break;
								  
								  case 2:
																		  
									  $this->body .= 'Media';
										  
								  break;
								  
								  case 3:
									  
									  $this->body .= 'Baja';
										  
								  break;
								  case 4:
									  
									  $this->body .= 'Muy Alta';
										  
								  break;
								  
							  endswitch;
							  
						   $this->body .= '</td>
					  <td class="center">'. utf8_decode($value['asunto']) .'</td>
					  <td class="center">'.utf8_decode($value['cliente']).'</td>
					  <td class="center">'. $value['fecha'] .'</td>
					  <td class="center">'. $value['fecha_final'] .'</td>
						
				  </tr>';
		
		}
				 
		return $this->header.$this->body.$this->footer;
		 		
	}


}
?>