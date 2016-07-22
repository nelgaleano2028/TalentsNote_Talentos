<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incidencia extends CI_Model {

	// Id	
		private $id = null;
	// Save data	
		private $data = array();
	// Table usage	
		private $table = 't_incidencia';
		private $table2 = 't_incidencia2';
		
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
		
		unset($this->data['categorias'] );
		
		
		$this->data['id_estado'] = 1;
		date_default_timezone_set("America/Bogota");
		$this->data['fecha'] = date( 'Y-m-d H:i:s', time() );
		$this->data['fecha_prioridad']= date( 'Y-m-d H:i:s', time() );
		// Load model
		$this->load->model('ingenieros');
		$ingeniero = $this->ingenieros->ingeniero_buscar($values['id_area']);
		if($ingeniero != 0){

			$this->data['id_ingeniero'] = $ingeniero;		
						
			// Crear registro	
			if($this->db->insert($this->table,$this->data)){
				if($this->correo_nuevo($this->db->insert_id()) == true)
				return true;
				else
				return false;
			}else
			    return false;	
		}else
		    false;	
	}
	
	public function crear_nivel_incidenci_admin( $values = array(),$tabla){
				
		$values['id_estado'] = 1;
		date_default_timezone_set("America/Bogota");
		$values['fecha'] = date( 'Y-m-d H:i:s', time() );
		$values['fecha_prioridad']= date( 'Y-m-d H:i:s', time());

		if($this->db->insert($tabla,$values)){
			return true;
		}else{
		    return false;	
		}
			
	}

	public function crear_incidente_ingeniero($values = array()){
		
		
		// Validar información
		if( empty( $values ) ) return false;
		
		$ingeniero_envia=$values['id_ingeniero_envia'];
		$ingeniero_recibe=$values['id_ingeniero'];
		
		// Configurar información a guardar
		foreach($values as $key => $value)									
			$this->data[$key] = $value ; 		
		
		unset($this->data['categorias'] );
		unset($this->data['id_ingeniero_envia']);
		
		$this->data['id_estado'] = 1;
		date_default_timezone_set("America/Bogota");
		$this->data['fecha'] = date( 'Y-m-d H-i-s', time() );
		$this->data['fecha_prioridad']= date( 'Y-m-d H-i-s', time() );
					
		// Crear registro	
		if( $this->db->insert( $this->table, $this->data )  ){
			
			if($this->envia_ingenieros($this->db->insert_id(),$ingeniero_envia, $ingeniero_recibe) == true){
				
				return true;	
			}else{
				return false;
			}
			
		}else
		   
		    return false;	
				
	}
	
	
	public function envia_ingenieros($incidencia, $ingeniero1, $ingeniero2){
		
		unset( $this->data ); $this->data = array();
		
		$this->data= array(
			'id_incidencia'=>$incidencia,
			'ingeniero_envia'=>$ingeniero1,
			'ingeniero_recibe'=>$ingeniero2,
			'fecha_recibio'=> date( 'Y-m-d H-i-s', time() )	
		);
		
		if($this->db->insert('t_ingeniero_envia', $this->data )== true){
			
			if($this->enviar_correos_ingenieros($incidencia, $ingeniero1, $ingeniero2) == true)
			    return true;
			else
			    return false;
		}
	        else{
			return false;	
	        }
	}
	
	public function enviar_correos_ingenieros($incidente= null, $ingeniero1){
		
		// Validacion id
		if( empty( $incidente ) or !is_numeric( $incidente ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->load->model('ingenieros');
		
		$ingeniero_envia=$this->ingenieros->id($ingeniero1);
		
		
		// Consulta
		$this->db->select("t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.detalle,
		t_incidencia.fecha,t_incidencia.imagen,t_estado.nombre_estado,t_cliente.nombre_cliente,
                t_condicion.descripcion,t_causa.nombre_causa,t_ingeniero.correo,t_ingeniero.nombre");
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->join('t_causa', 't_causa.id_causa = t_incidencia.causa');
		$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
		$this->db->where('id_incidencia', $incidente); 
		  
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				 $this->load->library('My_PHPMailer');
				$mail = new mailer();
				//$mail->Host = "vladimir.bello@talentsw.com";
				// $mail->From = "vladimir.bello@talentsw.com"; 
				$mail->FromName = "Administrador Talentos y Tecnologia";
				$mail->Subject = $row->asunto;
				$mail->AddAddress($ingeniero_envia[0]['correo'],'ingeniero envia');
				$mail->AddAddress($row->correo,'ingeniero recibe');
				// $mail->AddAddress("vladimir.bello@talentsw.com","Administracion AFQ sas");
				$body = '<table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table">
						       <tbody><tr>
							       <td align="center" bgcolor="#c7c7c7">
								       <table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
									       <tbody><tr><td class="w640" width="640" height="20"></td></tr>
									       
									       <tr>
										       <td class="w640" width="640"><table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#000000">
						       <tbody><tr>
							       <td class="w15" width="15"></td>
							       <td class="w325" width="350" valign="middle" align="left">&nbsp;</td>
							       <td class="w30" width="30"></td>
							       <td class="w255" width="255" valign="middle" align="right"><table cellpadding="0" cellspacing="0" border="0">
								 <tbody><tr>	
						       </tr>
					       </tbody></table></td>
							       <td class="w15" width="15"></td>
						       </tr>
					       </tbody></table>
											       
										       </td>
									       </tr>
									       <tr>
									       <td id="header" class="w640" width="640" align="center" bgcolor="#000000">
						       
						       <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
							       <tbody><tr><td class="w30" width="30"></td><td class="w580" width="580" height="30"><h1 style="color: #47c8db !important; font: bold 32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"><singleline label="Title">Administrador</singleline></h1></td><td class="w30" width="30"></td></tr>
							       <tr>
								       <td class="w30" width="30"></td>
								       <td class="w580" width="580">
									       <div align="center" id="headline">
										       <p>
											       <strong><singleline style="color: #47c8db !important; font:  32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"label="Title">Detalle del Incidente</singleline></strong>
										       </p>
									       </div>
								       </td>
								       <td class="w30" width="30"></td>
							       </tr>
						       </tbody></table>
						       
						       
					       </td>
									       </tr>
									       
									       <tr><td class="w640" width="640" height="30" bgcolor="#ffffff"></td></tr>
									       <tr id="simple-content-row"><td class="w640" width="640" bgcolor="#ffffff">
						       <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
							       <tbody><tr>
								       <td class="w30" width="30"></td>
								       <td class="w580" width="580">
									 <table cellpadding="0" cellspacing="0" border="0" width="600">
												       <tr>
													  <td><strong>Codigo:</strong> </td>
													  <td>'.$row->id_incidencia.'</td>
												       </tr>
												       <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
													<tr>
													  <td><strong>Estado:</strong> </td>
													  <td>'.$row->nombre_estado.'</td>
												       </tr>
												       <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
					       
													<tr>
													  <td><strong>Prioridad:</strong> </td>
													  <td>'.$row->descripcion.'</td>
												       </tr>
												       <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
					       
													<tr>
													  <td><strong>Causa:</strong></td>
													  <td>'.$row->nombre_causa.'</td>
												       </tr>
												       <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
					       
												       <tr>
													  <td><strong>Asunto:</strong> </td>
													  <td>'.$row->asunto.'</td>
												       </tr>
												       <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
					       
												       <tr>
													  <td> <strong>Detalle: </strong></td>
													  <td>'.$row->detalle.'</td>
												       </tr>
												       <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
					       
												       <tr>
													  <td><strong>Empresa:</strong> </td>
													  <td>'.$row->nombre_cliente.'</td>
												       </tr>
												       <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
					       
													<tr>
													  <td><strong>Fecha Inicial:</strong> </td>
													  <td>'.$row->fecha.'</td>
												       </tr>
												       
												       <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
												       
												       <tr>
													  <td><strong>Ingeniero Envia el incidente:</strong> </td>
													  <td>'.$ingeniero_envia[0]['nombre'].'</td>
													 
												       </tr>
												       
												        <tr>
													  <td>&nbsp;</td>
													  
												       </tr>
												       
												       <tr>
													  <td><strong>Ingeniero recibe el incidente:</strong> </td>
													  <td> '.$row->nombre.'</td>
												       </tr>
												       
												       </table> 
													       
								       </td>
								       <td class="w30" width="30"></td>
							       </tr>
						       </tbody></table>
					       </td></tr>
									       <tr><td class="w640" width="640" height="15" bgcolor="#ffffff"></td></tr>
								       </tbody></table>
							       </td>
						       </tr>
					       </tbody></table>';
				$mail->IsHTML(true); // El correo se envía como HTML
				$mail->Body = $body;
				$mail->AltBody = "Talents notes";
				$mail->AddAttachment("./incidentes/".$row->imagen, $row->imagen );
				$exito = $mail->Send();
				
				if($exito){
					echo '<script>alert("Se envio el correo"); </script>';
				}else{
					echo '<script>alert("No se envio un carajo ..|.."); </script>';
				}
									
			}
			
			return true;
				
		}else{
			return false;	
		}	
		
		
	}
	
	public function correo_nuevo( $incidente= null){
	
		// Validacion id
		if( empty( $incidente ) or !is_numeric( $incidente ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select("t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.detalle,
		t_incidencia.fecha,t_incidencia.imagen,t_estado.nombre_estado,t_cliente.nombre_cliente,
                t_condicion.descripcion,t_causa.nombre_causa,t_ingeniero.correo,t_ingeniero.nombre,
		t_contacto.correo as correo_contacto");
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->join('t_causa', 't_causa.id_causa = t_incidencia.causa');
		$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
		$this->db->join('t_contacto', 't_contacto.id_contacto = t_incidencia.id_contacto');
		
		$this->db->where('id_incidencia', $incidente); 
		  
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				 $this->load->library('My_PHPMailer');
						 $mail = new mailer();
						//$mail->Host = "vladimir.bello@talentsw.com";
						 $mail->FromName = "Administrador Talentos y Tecnologia";
						 $mail->Subject = $row->asunto;
						 $mail->AddAddress($row->correo,'ingeniero');
						 $mail->AddAddress($row->correo_contacto,'cliente');
						 // $mail->AddAddress("vladimir.bello@talentsw.com","Administracion AFQ sas");
						 $body = '<table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table">
									<tbody><tr>
										<td align="center" bgcolor="#c7c7c7">
											<table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
												<tbody><tr><td class="w640" width="640" height="20"></td></tr>
												
												<tr>
													<td class="w640" width="640"><table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#000000">
									<tbody><tr>
										<td class="w15" width="15"></td>
										<td class="w325" width="350" valign="middle" align="left">&nbsp;</td>
										<td class="w30" width="30"></td>
										<td class="w255" width="255" valign="middle" align="right"><table cellpadding="0" cellspacing="0" border="0">
										  <tbody><tr>	
									</tr>
								</tbody></table></td>
										<td class="w15" width="15"></td>
									</tr>
								</tbody></table>
														
													</td>
												</tr>
												<tr>
												<td id="header" class="w640" width="640" align="center" bgcolor="#000000">
									
									<table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
										<tbody><tr><td class="w30" width="30"></td><td class="w580" width="580" height="30"><h1 style="color: #47c8db !important; font: bold 32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"><singleline label="Title">Administrador</singleline></h1></td><td class="w30" width="30"></td></tr>
										<tr>
											<td class="w30" width="30"></td>
											<td class="w580" width="580">
												<div align="center" id="headline">
													<p>
														<strong><singleline style="color: #47c8db !important; font:  32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"label="Title">Detalle del Incidente</singleline></strong>
													</p>
												</div>
											</td>
											<td class="w30" width="30"></td>
										</tr>
									</tbody></table>
									
									
								</td>
												</tr>
												
												<tr><td class="w640" width="640" height="30" bgcolor="#ffffff"></td></tr>
												<tr id="simple-content-row"><td class="w640" width="640" bgcolor="#ffffff">
									<table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
										<tbody><tr>
											<td class="w30" width="30"></td>
											<td class="w580" width="580">
											  <table cellpadding="0" cellspacing="0" border="0" width="600">
															<tr>
															   <td><strong>Codigo:</strong> </td>
															   <td>'.$row->id_incidencia.'</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															 <tr>
															   <td><strong>Estado:</strong> </td>
															   <td>'.$row->nombre_estado.'</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
								
															 <tr>
															   <td><strong>Prioridad:</strong> </td>
															   <td>'.$row->descripcion.'</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
								
															 <tr>
															   <td><strong>Causa:</strong></td>
															   <td>'.$row->nombre_causa.'</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
								
															<tr>
															   <td><strong>Asunto:</strong> </td>
															   <td>'.$row->asunto.'</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
								
															<tr>
															   <td> <strong>Detalle: </strong></td>
															   <td>'.$row->detalle.'</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
								
															<tr>
															   <td><strong>Empresa:</strong> </td>
															   <td>'.$row->nombre_cliente.'</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
								
															 <tr>
															   <td><strong>Fecha Inicial:</strong> </td>
															   <td>'.$row->fecha.'</td>
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td><strong>Ingeniero:</strong> </td>
															   <td>'.$row->nombre.'</td>
															</tr>
															
															</table> 
																
											</td>
											<td class="w30" width="30"></td>
										</tr>
									</tbody></table>
								</td></tr>
												<tr><td class="w640" width="640" height="15" bgcolor="#ffffff"></td></tr>
											</tbody></table>
										</td>
									</tr>
								</tbody></table>';
						 $mail->IsHTML(true); // El correo se envía como HTML
						 $mail->Body = $body;
						 $mail->AltBody = "Talents notes";
						 $mail->AddAttachment("./incidentes/".$row->imagen, $row->imagen );
						 $exito = $mail->Send();
						if($exito){
							echo '<script>alert("Se envio el correo"); </script>';
						}else{
							echo '<script>alert("No se envio un carajo ..|.."); </script>';
						}	
									
			}
			
			return true;
				
		}else{
			return false;	
		}	
	}
	
	
	public function editar( $id = null, $values = array() ){
				
		// Validar id e información
		if( empty( $id ) or !is_numeric( $id ) or empty( $values ) ) return false;

		// Editar registros					
	    if( $this->db->update( $this->table, $values, array( 'id_incidencia' => $id ) ) )
			return true;
		else
        	return false;
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
	
	/*
	====================================
		Funciones Para obtener datos
	==================================== */	
	public function all(){
		
		unset( $this->data ); $this->data = array();
				
		// Consulta
		$this->db->select( '*' )->from($this->table)->order_by( 'id_incidencia', 'desc' );
		$query = $this->db->get();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			// load model
			$this->load->model( array( 'areas', 'subcategorias', 'categorias', 'ingenieros', 'cliente','estados' ) );
			
			foreach ( $query->result() as $row ){
				
				$area = $this->areas->id( $row->id_area );
				$subcategoria = $this->subcategorias->id( $row->id_subcategoria );
				$categoria = $this->categorias->id( $subcategoria[0]['relacion'] );
				$ingeniero = $this->ingenieros->incidencia( $row->id_ingeniero );
				$cliente = $this->cliente->id( $row->id_cliente );
				$estado = $this->estados->id($row->id_estado);
				$condicion = $this->estados->id2($row->id_condicion);
							
				$this->data[] = array( 
					
					'id_incidencia' => $row->id_incidencia,
					'id_categoria' => $categoria[0]['id'],
					'id_subcategoria' => $row->id_subcategoria,
					'id_condicion' => $row->id_condicion,
					'id_estado' => $row->id_estado,
					'id_area' => $row->id_area,
					'area' => $area[0]['nombre_area'],
					'ingeniero' => $ingeniero[0]['nombre'],
					'asunto' => $row->asunto,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'detalle' => $row->detalle,
					'cliente' => $cliente[0]['nombre_cliente'],
					'prioridad'=> $row->id_condicion,
					'nombre_estado'=>$estado[0]['nombre_estado'],					
					'nombre_condicion'=>$condicion[0]['descripcion']				
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function cliente($id = null){
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.fecha,t_incidencia.id_estado,
		t_incidencia.id_cliente,t_incidencia.id_condicion,t_estado.nombre_estado,t_condicion.descripcion,
		t_ingeniero.nombre');
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
		$this->db->where('id_cliente', $id); 
		$query=$this->db->get();
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				
				$this->data[]= array(
					
					'id_incidencia' => $row->id_incidencia,
					'estado'=>$row->nombre_estado,
					'fecha' => $row->fecha,
					'asunto' => $row->asunto,
					'prioridad'=>$row->descripcion,
					'ingeniero'=> $row->nombre,
					'id_condicion'=>$row->id_condicion,
					'id_estado'=>$row->id_estado,
					'id_cliente'=>$row->id_cliente,
				);
	
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
	
	}
	
	public function buscar_tiempoempresa($id= null){
		
		
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia.id_cliente,t_incidencia.id_condicion,t_incidencia.fecha_prioridad');
		$this->db->from($this->table);
		$this->db->where('id_incidencia', $id); 
		$query=$this->db->get();
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
	
				$this->load->model('tiempoprioridads');
				
				$tiempo = $this->tiempoprioridads->cliente_pausar(  $row->id_cliente, $row->id_condicion );
					
				
				$this->data[]= array(
					
					'condicion'=>$row->id_condicion,
					'fecha_prioridad'=>$row->fecha_prioridad,
					'tiempo'=>$tiempo
				);
				
				$this->data;		
			}
			
			return $this->data;
			
			
		}else{
			return 0;	
		}		
	}
	
	
	public function buscar_clientes(){
		
		$this->db->select('t_incidencia.id_cliente');
		$this->db->from($this->table);
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
		$mes=date( 'Y-m', $actual );
		
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.id_estado,t_incidencia.id_condicion,t_incidencia.fecha,
		t_incidencia.fecha_final,t_incidencia.fecha_prioridad,t_incidencia.id_cliente');
		$this->db->from($this->table);
		$this->db->where('id_cliente', $cliente);
		$this->db->where('id_estado', 1);
		$this->db->like('t_incidencia.fecha',$mes, 'after'); 
		$query=$this->db->get();
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
	
				$arreglo=array(
					'id_incidencia'=>$row->id_incidencia,
					'id_condicion'=>$row->id_condicion,
					'fecha_incial'=>$row->fecha,
					'fecha_fin'=>$fecha_actual,
					'id_cliente'=>$row->id_cliente	
				);
				
				$this->cambiar_condicion($arreglo);
							
			}
		}
	}
	
	public function cambiar_condicion($arreglo=array()){
		
		$this->load->model('mensual');
		
		
		$this->load->library('fechas');
		
		$prueba=$this->fechas->verificar($arreglo['fecha_incial'],$arreglo['fecha_fin']);
		
		if($prueba['dias'] !=0){
			
			$values=array(
			    'id_condicion'=>4,
			    'fecha_prioridad'=>date('Y-m-d H:i:s', time())
			);
			
			if($this->db->update( $this->table, $values, array( 'id_incidencia' => $arreglo['id_incidencia'] ))== true)
			return true;			
		}else{
			
			$this->load->model('tiempoprioridads');
			
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
						
						$values=array(
						   'fecha_prioridad'=>date( 'Y-m-d H:i:s', time() )
						);
						
						if($this->db->update( $this->table, $values, array( 'id_incidencia' => $arreglo['id_incidencia'] ))== true)
						   break;
						   
					}else	
					    break;
						
				case 1: //alta
					if($relacionar > $fecha_alta){
						
						$values=array(
						   'id_condicion'=>4,
						   'fecha_prioridad'=>date( 'Y-m-d H:i:s', time() )
						);
						
						if($this->db->update( $this->table, $values, array( 'id_incidencia' => $arreglo['id_incidencia'] ))== true)
						   break;
						   
					}else
					      break;
					     
				case 2: //media
					if($relacionar>$fecha_media){
						
						$values=array(
						   'id_condicion'=>1,
						   'fecha_prioridad'=>date( 'Y-m-d H:i:s', time() )
						);
						
						if($this->db->update( $this->table, $values, array( 'id_incidencia' => $arreglo['id_incidencia'] ))== true)
						   break;
							
					}else
					      break;
						
				case 3: //baja
					if($relacionar > $fecha_baja){

						$values=array(
						   'id_condicion'=>2,
						   'fecha_prioridad'=>date( 'Y-m-d H:i:s', time() )
						);
						
					       if($this->db->update( $this->table, $values, array( 'id_incidencia' => $arreglo['id_incidencia'] ))== true)
						break;
					       	
					}else
					      break;
			endswitch;
			
			return true;		
		}
	
	}
	
	public function cliente_contacto($id = null){
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.fecha,
		t_incidencia.fecha_final,t_estado.nombre_estado,t_cliente.nombre_cliente,		  
		t_condicion.descripcion, t_incidencia.id_cliente, t_incidencia.imagen');
		$this->db->from('t_incidencia');
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->where('t_incidencia.id_cliente', $id); 
		$query=$this->db->get();
		
		if( $query->num_rows != 0 ){
			
			
			foreach ( $query->result() as $row ){
				
							
				$this->data[] = array( 
					
					'id_incidencia' => $row->id_incidencia,
					'estado' => $row->nombre_estado,
					'prioridad'=>$row->descripcion,
					'asunto'=>$row->asunto,
					'empresa'=>$row->nombre_cliente,
					'fecha'=>$row->fecha,
					'fecha_final'=>$row->fecha_final,
					'id_cliente'=>$row->id_cliente,
					'imagen'=>$row->imagen
					
										
				);
			}
			
			return $this->data;	
			
		}else
			return false;
		
	}
	
	public function id( $id = null ){
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_incidencia' => $id ) );
		
				
		// Obtener datos
		if( $query->num_rows != 0 ){
		
		
			
			// load model
			$this->load->model( array( 'subcategorias','causas', 'categorias', 'cliente', 'ingenieros', 'contactos', 'estados') );
			
			foreach ( $query->result() as $row ){

				$subcategoria = $this->subcategorias->id( $row->id_subcategoria );
				$autor = $this->cliente->id( $row->id_cliente );
				$categoria = $this->categorias->id( $subcategoria[0]['relacion'] );
				$ingeniero = $this->ingenieros->id( $row->id_ingeniero );
				$contactos = $this->contactos->cliente($row->id_cliente);
				$estado = $this->estados->id( $row->id_estado );
				$causa = $this->causas->id($row->causa);
				$condicion = $this->estados->id2( $row->id_condicion );
				$this->data[] = array( 
					
					'id_incidencia' => $row->id_incidencia,
					'id_categoria' => $categoria[0]['id'],
					'id_subcategoria' => $row->id_subcategoria,
					'id_condicion' => $row->id_condicion,
					'id_estado' => $row->id_estado,
					'estado' => $estado[0]['nombre_estado'],
					'condicion' => $condicion[0]['descripcion'],
					'id_cliente' => $row->id_cliente,
					'id_area' => $row->id_area,
					'id_ingeniero' => $row->id_ingeniero,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'asunto' => $row->asunto,
					'subcategoria' => $subcategoria[0]['opcion'],
					'causa' => $row->causa,
					'nombre_causa' => $causa[0]['nombre_causa'],
					'cliente' => $autor[0]['nombre_cliente'],
					'ingeniero' => $ingeniero[0]['nombre'],
					'detalle' => $row->detalle,
					'contacto' => $contactos
										
				);

			}
			
			return $this->data;	
				
		}else
			return false;
			
	}
	
	
	public function id2( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,
						t_incidencia.id_cliente,t_incidencia.id_ingeniero,
						t_incidencia.fecha,t_incidencia.detalle,t_incidencia.imagen,
						t_estado.id_estado,t_estado.nombre_estado,t_cliente.nombre_cliente,
						t_subcategoria.opcion,t_condicion.id_condicion,t_incidencia.id_subcategoria,
						t_condicion.descripcion, t_causa.id_causa,t_causa.nombre_causa,
						t_incidencia.id_area,t_incidencia.id_contacto,t_incidencia.fecha_final,
						t_incidencia.fecha_prioridad');
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado','left');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente','left');
		$this->db->join('t_subcategoria', 't_subcategoria.id = t_incidencia.id_subcategoria','left');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion','left');
		$this->db->join('t_causa', 't_causa.id_causa = t_incidencia.causa');
		$this->db->where('id_incidencia', $id); 
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
					'id_incidencia' => $row->id_incidencia,
					'id_estado'=>$row->id_estado,
					'estado'=>$row->nombre_estado,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'fecha_prioridad' => $row->fecha_prioridad,
					'asunto' => $row->asunto,
					'subcategoria' => $row->opcion,
					'id_prioridad'=> $row->id_condicion,
					'prioridad'=>$row->descripcion,
					'id_causa'=>$row->id_causa,
					'causa' => $row->nombre_causa,
					'cliente' => $row->nombre_cliente,
					'detalle' => $row->detalle,
					'id_cliente' => $row->id_cliente,
					'id_ingeniero' => $row->id_ingeniero,
					'id_subcategoria' => $row->id_subcategoria,
					'id_area' => $row->id_area,
					'id_contacto' => $row->id_contacto,
					'imagen'=> $row->imagen
				);
			}
			
			return $this->data;
				
		}else{
			return false;	
		}	
			
	}
	
	
	public function id3( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select('t_incidencia.id_incidencia, t_incidencia.id_estado, t_incidencia.id_cliente, 
			t_incidencia.id_ingeniero, t_ingeniero.nombre, t_incidencia.id_condicion,
			 t_condicion.descripcion,t_incidencia.id_subcategoria, t_subcategoria.opcion, 
			 t_incidencia.id_area, t_area.nombre_area,t_incidencia.id_contacto, 
			 t_incidencia.asunto, t_incidencia.detalle, t_incidencia.fecha,t_incidencia.fecha_final,
			  t_estado.nombre_estado, t_notas.notas, (SELECT COUNT(*) FROM t_incidencia where id_cliente = 27)AS total ');
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado','LEFT');
		$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero','LEFT');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion','LEFT');
		$this->db->join('t_subcategoria', 't_subcategoria.id = t_incidencia.id_subcategoria','LEFT');
		$this->db->join('t_area', 't_area.id_area = t_incidencia.id_area','LEFT');
		$this->db->join('t_notas', 't_notas.id_incidencia = t_incidencia.id_incidencia','LEFT');
		$this->db->where('id_cliente', $id); 
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
					'id_incidencia' => $row->id_incidencia,
					'id_estado' => $row->id_estado,
					'nombre_estado' => $row->nombre_estado,
					'id_cliente' => $row->id_cliente,
					'id_ingeniero' => $row->id_ingeniero,
					'nombre' => $row->nombre,
					'id_condicion' => $row->id_condicion,
					'descripcion' => $row->descripcion,
					'id_subcategoria' => $row->id_subcategoria,
					'opcion' => $row->opcion,
					'id_area' => $row->id_area,
					'nombre_area' => $row->nombre_area,
					'id_contacto' => $row->id_contacto,
					'asunto' => $row->asunto,
					'detalle' => $row->detalle,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'notas' => $row->notas,
					'total' => $row->total
										
				);
			}
			
			return $this->data;
				
		}else{
			return false;	
		}	
			
	}

	public function id4( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select('t_incidencia.id_incidencia, t_incidencia.id_estado, t_incidencia.id_cliente, 
			t_incidencia.id_ingeniero, t_ingeniero.nombre, t_incidencia.id_condicion,
			 t_condicion.descripcion,t_incidencia.id_subcategoria, t_subcategoria.opcion, 
			 t_incidencia.id_area, t_area.nombre_area,t_incidencia.id_contacto, 
			 t_incidencia.asunto, t_incidencia.detalle, t_incidencia.fecha,t_incidencia.fecha_final,
			  t_estado.nombre_estado, t_notas.notas, (SELECT COUNT(*) FROM t_incidencia where id_cliente = 27)AS total ');
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado','LEFT');
		$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero','LEFT');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion','LEFT');
		$this->db->join('t_subcategoria', 't_subcategoria.id = t_incidencia.id_subcategoria','LEFT');
		$this->db->join('t_area', 't_area.id_area = t_incidencia.id_area','LEFT');
		$this->db->join('t_notas', 't_notas.id_incidencia = t_incidencia.id_incidencia','LEFT');
		$this->db->where('t_incidencia.id_ingeniero',$id); 
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
					'id_incidencia' => $row->id_incidencia,
					'id_estado' => $row->id_estado,
					'nombre_estado' => $row->nombre_estado,
					'id_cliente' => $row->id_cliente,
					'id_ingeniero' => $row->id_ingeniero,
					'nombre' => $row->nombre,
					'id_condicion' => $row->id_condicion,
					'descripcion' => $row->descripcion,
					'id_subcategoria' => $row->id_subcategoria,
					'opcion' => $row->opcion,
					'id_area' => $row->id_area,
					'nombre_area' => $row->nombre_area,
					'id_contacto' => $row->id_contacto,
					'asunto' => $row->asunto,
					'detalle' => $row->detalle,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'notas' => $row->notas,
					'total' => $row->total
										
				);
			}
			
			return $this->data;
				
		}else{
			return false;	
		}	
			
	}

	
	public function id_ingeniero( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select('t_incidencia.id_ingeniero');
		$this->db->from($this->table);
		$this->db->where('id_incidencia', $id); 
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
					'id_ingeniero' => $row->id_ingeniero,
					
				);
			}
			
			return $this->data;
				
		}else{
			return false;	
		}	
			
	}
	
	public function vistas( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select('*');
		$this->db->from('t_vistas');
		$this->db->where('id_incidencia', $id); 
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
					'click' => $row->click,
					
				);
			}
			
			return $this->data;
				
		}else{
			return false;	
		}	
			
	}

	public function crear_vistas($values=array()){

		if($this->db->insert('t_vistas',$values)){
			return true;
		}else{
		    return false;	
		}
			
	}

	public function incidentes_admin( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.id_area,t_incidencia.asunto,t_incidencia.fecha,t_incidencia.detalle,
		t_estado.id_estado,t_estado.nombre_estado,t_cliente.nombre_cliente,t_subcategoria.opcion,t_condicion.id_condicion,
		t_condicion.descripcion,t_causa.id_causa,t_causa.nombre_causa,t_ingeniero.id_ingeniero as ingeniero,
		t_ingeniero.nombre,(select Usuario from t_usuario where id_ingeniero = ingeniero) as usuario');
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->join('t_subcategoria', 't_subcategoria.id = t_incidencia.id_subcategoria');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->join('t_causa', 't_causa.id_causa = t_incidencia.causa');
		$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
		$this->db->where('id_incidencia', $id); 
		
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
					'id_incidencia' => $row->id_incidencia,
					'id_estado'=>$row->id_estado,
					'id_area'=>$row->id_area,
					'estado'=>$row->nombre_estado,
					'fecha' => $row->fecha,
					'asunto' => $row->asunto,
					'subcategoria' => $row->opcion,
					'id_prioridad'=> $row->id_condicion,
					'prioridad'=>$row->descripcion,
					'id_causa'=>$row->id_causa,
					'causa' => $row->nombre_causa,
					'cliente' => $row->nombre_cliente,
					'detalle' => $row->detalle,
					'ingeniero'=> $row->ingeniero,
					'nombre_ingeniero'=> $row->nombre,
					'usuario'=> $row->usuario
				);
			}
			
			return $this->data;
				
		}else{
			return false;	
		}	
			
	}
	
	public function correo($id = null){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$this->db->select("t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.fecha,t_incidencia.fecha_final,
		t_incidencia.imagen,t_estado.nombre_estado,t_cliente.nombre_cliente,t_condicion.descripcion,
	    t_causa.nombre_causa,t_ingeniero.correo as correo_ingeniero,t_ingeniero.nombre,t_contacto.correo as correo_contacto,
		(select notas from t_notas where id_incidencia = ".$id."  order by id_notas desc limit 1) as notas");
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->join('t_causa', 't_causa.id_causa = t_incidencia.causa');
		$this->db->join('t_ingeniero', 't_ingeniero.id_ingeniero = t_incidencia.id_ingeniero');
		$this->db->join('t_contacto', 't_contacto.id_cliente = t_incidencia.id_cliente');
		$this->db->where('id_incidencia', $id); 
		  
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
					'id_incidencia' => $row->id_incidencia,
					'estado'=>$row->nombre_estado,
					'fecha' => $row->fecha,
					'fecha_final'=>$row->fecha_final,
					'asunto' => $row->asunto,
					'prioridad'=>$row->descripcion,
					'causa' => $row->nombre_causa,
					'cliente' => $row->nombre_cliente,
					'correo_ingeniero'=> $row->correo_ingeniero,
					'ingeniero'=> $row->nombre,
					'correo_contacto'=> $row->correo_contacto,
					'imagen'=>$row->imagen,
					'notas'=>$row->notas
				);
			}
			
			return $this->data;
				
		}else{
			return false;	
		}	
			
	}
	
	public function imagen( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_incidencia' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			
			foreach ( $query->result() as $row ){
			
				
				$this->data[] = array( 
					
					'imagen' => $row->imagen,
					
										
				);
				
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
    public function update_imagen( $id = null ){
		
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); 
		
	    $imagen_update=array(
			'imagen'=>'no_disponible.png'
		);	
	
		// Editar registros					
	    if( $this->db->update( $this->table, $imagen_update, array( 'id_incidencia' => $id ) ) )
        	return true;
        else
        	return false;
		
	}
	
	public function imprimir_id( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_incidencia' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			// load model
			$this->load->model( array( 'subcategorias', 'categorias', 'cliente', 'ingenieros', 'contactos' ) );
			
			foreach ( $query->result() as $row ){
			
				$subcategoria = $this->subcategorias->id( $row->id_subcategoria );
				
				$cliente = $this->cliente->id( $row->id_cliente );
			
				$categoria = $this->categorias->id( $subcategoria[0]['relacion'] );
				
				$ingeniero = $this->ingenieros->id( $row->id_ingeniero );
				
				$contactos = $this->contactos->cliente( $row->id_cliente );
				
				$contacto= $this->contactos->contacto_incidente( $row->id_contacto );
				
				
				$estado=($row->id_estado == 1)?'abierto':'cerrado';
				
				 switch($row->id_condicion): 
				 
					 case 1:
						$prioridad= 'Alta';
					 break;
					 case 2:
						$prioridad= 'Media';
					 break;
					 case 3:
						$prioridad= 'Baja';
					 break;
					 case 4:
						$prioridad= 'Muy Alta';
					 break;
				 
				 
				 endswitch;
				 
				 $fecha=substr($row->fecha, 0, -9);
				 $fecha_final=substr($row->fecha_final, 0, -9);
				 
				
				$this->data[] = array( 
					
					'id_incidencia' => $row->id_incidencia,
					'categoria' => $categoria[0]['opcion'],
					'subcategoria' => $subcategoria[0]['opcion'],
					'prioridad' => $prioridad,
					'estado' => $estado,
					'fecha' => $fecha,
					'fecha_final' => $fecha_final,
					'asunto' => $row->asunto,
					'cliente' => $cliente[0]['nombre_cliente'],
					'ingeniero' => $ingeniero[0]['nombre'],
					'detalle' => $row->detalle,
					'contacto' => $contacto[0]['nombre']
										
				);
				
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function ingeniero( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.fecha,t_incidencia.id_ingeniero,
		t_incidencia.id_estado,t_incidencia.id_cliente,t_incidencia.id_condicion,t_estado.nombre_estado,
		t_cliente.nombre_cliente,t_condicion.id_condicion,t_condicion.descripcion');
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->where('t_incidencia.id_ingeniero', $id); 
		$this->db->where('t_incidencia.id_estado <>',  '2');
		$query=$this->db->get();

		$this->load->model(array('estados'));

		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$condicion = $this->estados->id2($row->id_condicion);

				$this->data[]= array(
				
					'id_incidencia' => $row->id_incidencia,
					'id_condicion' => $row->id_condicion,
					'id_ingeniero' => $row->id_ingeniero,
					'estado'=> $row->nombre_estado,
					'cliente' => $row->nombre_cliente,
					'asunto' => $row->asunto,
					'fecha' => $row->fecha,
					'condicion' =>$condicion[0]['descripcion']
				);
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
		
		
	}
	
	public function ingeniero2( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia2.id_incidencia,t_incidencia2.asunto,t_incidencia2.fecha,t_incidencia2.id_ingeniero,
		t_incidencia2.id_estado,t_incidencia2.id_cliente,t_incidencia2.id_condicion,t_estado.nombre_estado,
		t_cliente.nombre_cliente,t_condicion.id_condicion,t_condicion.descripcion');
		$this->db->from($this->table2);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia2.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia2.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia2.id_condicion');
		$this->db->where('t_incidencia2.id_ingeniero', $id); 
		$this->db->where('t_incidencia2.id_estado <>',  '2');
		$query=$this->db->get();
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
				
					'id_incidencia' => $row->id_incidencia,
					'id_condicion' => $row->id_condicion,
					'id_ingeniero' => $row->id_ingeniero,
					'estado'=> $row->nombre_estado,
					'cliente' => $row->nombre_cliente,
					'asunto' => $row->asunto,
					'fecha' => $row->fecha,
				);
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
		
		
	}
	
	public function ingeniero3( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia3.id_incidencia,t_incidencia3.asunto,t_incidencia3.fecha,t_incidencia3.id_ingeniero,
		t_incidencia3.id_estado,t_incidencia3.id_cliente,t_incidencia3.id_condicion,t_estado.nombre_estado,
		t_cliente.nombre_cliente,t_condicion.id_condicion,t_condicion.descripcion');
		$this->db->from('t_incidencia3');
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia3.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia3.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia3.id_condicion');
		$this->db->where('t_incidencia3.id_ingeniero', $id); 
		$this->db->where('t_incidencia3.id_estado <>',  '2');
		$query=$this->db->get();
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				$this->data[]= array(
				
					'id_incidencia' => $row->id_incidencia,
					'id_condicion' => $row->id_condicion,
					'id_ingeniero' => $row->id_ingeniero,
					'estado'=> $row->nombre_estado,
					'cliente' => $row->nombre_cliente,
					'asunto' => $row->asunto,
					'fecha' => $row->fecha,
				);
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
		
		
	}

	public function ingeniero_resueltos( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.fecha,t_incidencia.fecha_final,t_incidencia.id_ingeniero,
		t_estado.nombre_estado,t_cliente.id_cliente,t_cliente.nombre_cliente,t_condicion.id_condicion,
		t_condicion.descripcion');
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->where('t_incidencia.id_ingeniero', $id); 
		$this->db->where('t_incidencia.id_estado =',  '2');
		$query=$this->db->get();

		$this->load->model('tiempoprioridads');
		$this->load->model('estados');

		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				
				$tiempo = $this->tiempoprioridads->cliente(  $row->id_cliente, $row->id_condicion );
				$condicion = $this->estados->id2($row->id_condicion);
				$this->data[]= array(
				
					'id_incidencia' => $row->id_incidencia,
					'id_condicion' => $row->id_condicion,
					'id_ingeniero' => $row->id_ingeniero,
					'estado'=> $row->nombre_estado,
					'cliente' => $row->nombre_cliente,
					'asunto' => $row->asunto,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'tiempo' => $tiempo,
					'condicion' =>$condicion[0]['descripcion']
				);
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
		
		
	}
	
	public function ingeniero_resueltos2( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia2.id_incidencia,t_incidencia2.asunto,t_incidencia2.fecha,t_incidencia2.fecha_final,t_incidencia2.id_ingeniero,
		t_estado.nombre_estado,t_cliente.id_cliente,t_cliente.nombre_cliente,t_condicion.id_condicion,
		t_condicion.descripcion');
		$this->db->from($this->table2);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia2.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia2.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia2.id_condicion');
		$this->db->where('t_incidencia2.id_ingeniero', $id); 
		$this->db->where('t_incidencia2.id_estado =',  '2');
		$query=$this->db->get();

		$this->load->model('tiempoprioridads');
		$this->load->model('estados');

		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				
				$tiempo = $this->tiempoprioridads->cliente(  $row->id_cliente, $row->id_condicion );
				$condicion = $this->estados->id2($row->id_condicion);
				$this->data[]= array(
				
					'id_incidencia' => $row->id_incidencia,
					'id_condicion' => $row->id_condicion,
					'id_ingeniero' => $row->id_ingeniero,
					'estado'=> $row->nombre_estado,
					'cliente' => $row->nombre_cliente,
					'asunto' => $row->asunto,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'tiempo' => $tiempo,
					'condicion' =>$condicion[0]['descripcion']
				);
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
		
		
	}
	
	public function ingeniero_resueltos3( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia3.id_incidencia,t_incidencia3.asunto,t_incidencia3.fecha,t_incidencia3.fecha_final,t_incidencia3.id_ingeniero,
		t_estado.nombre_estado,t_cliente.id_cliente,t_cliente.nombre_cliente,t_condicion.id_condicion,
		t_condicion.descripcion');
		$this->db->from($this->table2);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia3.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia3.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia3.id_condicion');
		$this->db->where('t_incidencia3.id_ingeniero', $id); 
		$this->db->where('t_incidencia3.id_estado =',  '2');
		$query=$this->db->get();

		$this->load->model('tiempoprioridads');
		$this->load->model('estados');

		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				
				$tiempo = $this->tiempoprioridads->cliente(  $row->id_cliente, $row->id_condicion );
				$condicion = $this->estados->id2($row->id_condicion);
				$this->data[]= array(
				
					'id_incidencia' => $row->id_incidencia,
					'id_condicion' => $row->id_condicion,
					'id_ingeniero' => $row->id_ingeniero,
					'estado'=> $row->nombre_estado,
					'cliente' => $row->nombre_cliente,
					'asunto' => $row->asunto,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'tiempo' => $tiempo,
					'condicion' =>$condicion[0]['descripcion']
				);
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
		
		
	}

	public function resuelto( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.fecha,t_incidencia.fecha_final,
		t_incidencia.detalle,t_estado.nombre_estado,t_cliente.nombre_cliente,t_subcategoria.opcion,
                t_condicion.descripcion,t_causa.nombre_causa');
		$this->db->from($this->table);
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->join('t_subcategoria', 't_subcategoria.id = t_incidencia.id_subcategoria');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->join('t_causa', 't_causa.id_causa = t_incidencia.causa');
		$this->db->where('t_incidencia.id_incidencia', $id); 
		$query=$this->db->get();
		if($query->num_rows != 0){
			
			foreach($query->result() as $row){
				
				
				$this->data[]= array(
				
					'id_incidencia' => $row->id_incidencia,
					'estado' => $row->nombre_estado,
					'asunto' => $row->asunto,
					'fecha'=>$row->fecha,
					'fecha_final'=>$row->fecha_final,
					'cliente' => $row->nombre_cliente,
					'subcategoria'=>$row->opcion,
					'prioridad'=>$row->descripcion,
					'causa'=>$row->nombre_causa,
					'detalle'=>$row->detalle
				);
			}
			
			return $this->data;
			
			
		}else{
			return false;	
		}	
		
		
	}
	
	public function ingenierotodas( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		$this->db->select('t_incidencia.id_incidencia,t_incidencia.asunto,t_incidencia.fecha,
		t_incidencia.fecha_final,t_estado.nombre_estado,t_cliente.nombre_cliente,t_usuario.Usuario,		  
		t_condicion.descripcion');
		$this->db->from('t_incidencia');
		$this->db->join('t_estado', 't_estado.id_estado = t_incidencia.id_estado');
		$this->db->join('t_cliente', 't_cliente.id_cliente = t_incidencia.id_cliente');
		$this->db->join('t_condicion', 't_condicion.id_condicion = t_incidencia.id_condicion');
		$this->db->join('t_usuario', 't_usuario.id_contacto = t_incidencia.id_contacto');
		$this->db->where('t_incidencia.id_ingeniero', $id); 
		$query=$this->db->get();				
		
		// Obtener datos
		if( $query->num_rows != 0 ){
						
			foreach ( $query->result() as $row ){
				
				
			    $this->data[] = array( 
					
					'id_incidencia' => $row->id_incidencia,
					'estado' => $row->nombre_estado,
					'cliente' => $row->nombre_cliente,
					'prioridad'=>$row->descripcion,
					'asunto'=>$row->asunto,
					'contacto'=>$row->Usuario,
					'fecha'=>$row->fecha,
					'fecha_final'=>$row->fecha_final
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function clientetodas( $id = null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select( '*' )->from( $this->table )->where( array( 'id_ingeniero' => $id ) )->order_by( 'id_incidencia', 'desc' );
						
		// Consulta
		$query = $this->db->get();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			// Load Model
			$this->load->model( array( 'cliente', 'contactos' ) );	
						
			foreach ( $query->result() as $row ){
				
				$contactos = $this->contactos->cliente( $row->id_cliente );
				
				$cliente = $this->cliente->id( $row->id_cliente );
				
			    $this->data[] = array( 
					
					'id_incidencia' => $row->id_incidencia,
					'id_condicion' => $row->id_condicion,
					'id_ingeniero' => $row->id_ingeniero,
					'id_estado' => $row->id_estado,
					'id_area' => $row->id_area,
					'cliente' => $cliente[0]['nombre_cliente'],
					'asunto' => $row->asunto,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'contacto' => $contactos
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	public function realizadas( $cliente = null, $ingeniero = null, $fecha = null ){
		
		// Validacion id
		if( empty( $cliente ) or empty( $ingeniero ) or empty( $fecha ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$fecha = explode( '/', $fecha );
		$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
		
		// Consulta
		$query = $this->db->query( 
		
			'
				SELECT count(*) as numero 
				FROM '.$this->table.'
				WHERE id_ingeniero=\''.strip_tags( $ingeniero ).'\' 
				AND id_cliente= \''.strip_tags( $cliente ).'\' 
				AND id_estado=2 
				AND DATE(fecha) = \''.strip_tags( $fecha ).'\'
			
			' 
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
			
							
				$this->data[] = array( 
					
					'numero' => $row->numero,
															
				);
		  
			}
			
			return $this->data;	
				
		}else{
		
			$this->data[0]['numero'] = 0;
			return $this->data;
		}
		
		
		
	}
	
	public function no_realizadas( $cliente = null, $ingeniero = null, $fecha = null ){
		
		// Validacion id
		if( empty( $cliente ) or empty( $ingeniero ) or empty( $fecha ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$fecha = explode( '/', $fecha );
		$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
		
		// Consulta
		$query = $this->db->query( 
		
			'
				SELECT count(*) as numero 
				FROM '.$this->table.'
				WHERE id_ingeniero=\''.strip_tags( $ingeniero ).'\' 
				AND id_cliente= \''.strip_tags( $cliente ).'\' 
				AND id_estado=1
				AND DATE(fecha) = \''.strip_tags( $fecha ).'\'
			
			' 
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
			
							
				$this->data[] = array( 
					
					'numero' => $row->numero,
															
				);
		  
			}
			
			return $this->data;	
				
		}else{
		
			$this->data[0]['numero'] = 0;
			return $this->data;
		}
		
	}
	
	
	public function realizadas_ingeniero_fecha( $ingeniero = null, $fecha1 = null, $fecha2 = null ){
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->query( 
		
			'
				SELECT count(*) as numero 
				FROM '.$this->table.'
				WHERE id_ingeniero=\''.strip_tags( $ingeniero ).'\' 
				AND id_estado=2 
				AND
				DATE(fecha)
				BETWEEN
				\''.strip_tags( $fecha2 ).'\'
				AND
			    \''.strip_tags( $fecha1 ).'\'

			' 
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			
			
			foreach ( $query->result() as $row ){
			
							
				$this->data[] = array( 
					
					'numero' => $row->numero,
															
				);
		  
			}
			
			return $this->data;	
				
		}else{
		
			$this->data['numero'] = 0;
			return $this->data;
		}
		
		
		
	}
	
	public function no_realizadas_ingeniero_fecha( $ingeniero = null, $fecha1 = null, $fecha2 = null ){
		
		// Validacion id
		if( empty( $ingeniero ) or empty( $fecha1 ) or empty ($fecha2) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$fecha1 = explode( '/', $fecha1 );
		$fecha1 = $fecha1[2].'-'.$fecha1[1].'-'.$fecha1[0];
		$fecha2 = explode( '/', $fecha2 );
		$fecha2 = $fecha2[2].'-'.$fecha2[1].'-'.$fecha2[0];
		
		// Consulta
		$query = $this->db->query( 
		
			'
				
				SELECT count(*) as numero 
				FROM '.$this->table.'
				WHERE id_ingeniero=\''.strip_tags( $ingeniero ).'\' 
				AND id_estado=1 
				AND
				DATE(fecha)
				BETWEEN
				\''.strip_tags( $fecha1 ).'\'
				AND
			    \''.strip_tags( $fecha2 ).'\'
			
			' 
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
			
							
				$this->data[] = array( 
					
					'numero' => $row->numero,
															
				);
		  
			}
			
			return $this->data;	
				
		}else{
		
			$this->data[0]['numero'] = 0;
			return $this->data;
		}
		
	}
	
	public function casos( $estado = null, $fecha = null, $cliente=null ){
	
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->query( 
		
			'
				SELECT count(*) as numero 
				FROM '.$this->table.'
				WHERE id_estado=\''.strip_tags( $estado ).'\' 
				AND id_cliente=\''.strip_tags( $cliente ).'\'
				AND
				DATE(fecha)
				LIKE
				\''.strip_tags( $fecha ).'%\'

			' 
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			foreach ( $query->result() as $row ){
				$this->data[] = array( 
					'numero' => $row->numero,
				);
			}
			return $this->data;	
		}else{
			$this->data['numero'] = 0;
			return $this->data;
		}
	}
	
	public function rango_fecha( $ingeniero = null, $de = null, $a = null ){
		
		// Validacion id
		if( empty( $ingeniero ) or empty( $de ) or empty( $a ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$de = explode( '/', $de );
		$de = $de[2].'-'.$de[1].'-'.$de[0];
		
		$a = explode( '/', $a );
		$a = $a[2].'-'.$a[1].'-'.$a[0];
		// Consulta
		$query = $this->db->query( 
		
			'
				SELECT * 
				FROM '.$this->table.'
				WHERE id_ingeniero=\''.strip_tags( $ingeniero ).'\' 
				AND DATE(fecha) BETWEEN \''.strip_tags( $de ).'\' AND \''.strip_tags( $a ).'\'
			
			' 
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			// load model
			$this->load->model( array( 'subcategorias', 'categorias', 'cliente', 'ingenieros', 'contactos' ) );
			
			foreach ( $query->result() as $row ){
			
				$subcategoria = $this->subcategorias->id( $row->id_subcategoria );
				
				$cliente = $this->cliente->id( $row->id_cliente );
			
				$categoria = $this->categorias->id( $subcategoria[0]['relacion'] );
				
				$ingeniero = $this->ingenieros->id( $row->id_ingeniero );
				
				$contactos = $this->contactos->cliente( $row->id_cliente );
				
				$estado=($row->id_estado == 1)?'abierto':'cerrado';
				
				 switch($row->id_condicion): 
				 
					 case 1:
						$prioridad= 'Alta';
					 break;
					 case 2:
						$prioridad= 'Media';
					 break;
					 case 3:
						$prioridad= 'Baja';
					 break;
				 
				 
				 endswitch;
				 
				 $fecha=substr($row->fecha, 0, -9);
				 $fecha_final=substr($row->fecha_final, 0, -9);
				
				$this->data[] = array( 
					
					'id_incidencia' => $row->id_incidencia,
					'categoria' => $categoria[0]['opcion'],
					'subcategoria' => $subcategoria[0]['opcion'],
					'prioridad' => $prioridad,
					'estado' => $estado,
					'fecha' => $fecha,
					'fecha_final' => $fecha_final,
					'asunto' => $row->asunto,
					'cliente' => $cliente[0]['nombre_cliente'],
					'ingeniero' => $ingeniero[0]['nombre'],
					'detalle' => $row->detalle,
					'contacto' => $contactos[0]['nombre']
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}	
	
	
	public function rango_fecha_cliente( $contacto = null, $de = null, $a = null ){
		
		// Validacion id
		if( empty( $contacto ) or empty( $de ) or empty( $a ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		$de = explode( '/', $de );
		$de = $de[2].'-'.$de[1].'-'.$de[0];
		
		$a = explode( '/', $a );
		$a = $a[2].'-'.$a[1].'-'.$a[0];
		// Consulta
		$query = $this->db->query( 
		
			'
				SELECT * 
				FROM '.$this->table.'
				WHERE id_contacto=\''.strip_tags( $contacto ).'\' 
				AND DATE(fecha) BETWEEN \''.strip_tags( $de ).'\' AND \''.strip_tags( $a ).'\'
			
			' 
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			// load model
			$this->load->model( array( 'subcategorias', 'categorias', 'cliente', 'ingenieros', 'contactos' ) );
			
			foreach ( $query->result() as $row ){
			
				$subcategoria = $this->subcategorias->id( $row->id_subcategoria );
				
				$cliente = $this->cliente->id( $row->id_cliente );
			
				$categoria = $this->categorias->id( $subcategoria[0]['relacion'] );
				
				$ingeniero = $this->ingenieros->id( $row->id_ingeniero );
				
				$contactos = $this->contactos->cliente( $row->id_cliente );
				
				$estado=($row->id_estado == 1)?'abierto':'cerrado';
				
				 switch($row->id_condicion): 
				 
					case 1:
						$prioridad= 'Alta';
					break;
					 case 2:
						$prioridad= 'Media';
					break;
					 case 3:
						$prioridad= 'Baja';
					break;
				 	case 4:
						$prioridad= 'Muy Alta';
					break;
				 
				 endswitch;
				 
				 $fecha=substr($row->fecha, 0, -9);
				 $fecha_final=substr($row->fecha_final, 0, -9);
				
				$this->data[] = array( 
					
					'id_incidencia' => $row->id_incidencia,
					'categoria' => $categoria[0]['opcion'],
					'subcategoria' => $subcategoria[0]['opcion'],
					'prioridad' => $prioridad,
					'estado' => $estado,
					'fecha' => $fecha,
					'fecha_final' => $fecha_final,
					'asunto' => $row->asunto,
					'cliente' => $cliente[0]['nombre_cliente'],
					'ingeniero' => $ingeniero[0]['nombre'],
					'detalle' => $row->detalle,
					'contacto' => $contactos[0]['nombre']
										
				);
		  
			}
			return $this->data;	
		}else
			return false;
		
	}
	
	public function traer_ids($fecha, $cliente, $ans){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->query( 
		
			'SELECT COUNT(*) AS numero
				
				FROM t_incidencia, t_ans
				
				WHERE
				t_incidencia.id_cliente=\''.strip_tags( $cliente ).'\'
				AND
				t_incidencia.id_incidencia=t_ans.id_incidencia
				AND 
				t_incidencia.fecha like \''.strip_tags( $fecha ).'%\'
				AND
				t_ans.ans like \''.strip_tags( $ans ).'%\'

			' 
			
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			foreach ( $query->result() as $row ){
				$this->data[] = array( 
					'numero' => $row->numero,											
				);
			}
			return $this->data;	
		}else{
			$this->data['numero'] = 0;
			return $this->data;
		}
	
	}	
	
	public function traer_mes($fecha, $cliente, $ans){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->query( 
		
			'SELECT COUNT(*) AS numero
				
				FROM t_incidencia, t_ans
				
				WHERE
				t_incidencia.id_cliente=\''.strip_tags( $cliente ).'\'
				AND
				t_incidencia.id_incidencia=t_ans.id_incidencia
				AND 
				t_incidencia.fecha like \''.strip_tags( $fecha ).'%\'
				AND
				t_ans.ans like \''.strip_tags( $ans ).'%\'

			' 
			
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			
			
			foreach ( $query->result() as $row ){
				$this->data[] = array( 
					'numero' => $row->numero,										
				);
			}
			return $this->data;	
		}else{
			$this->data['numero'] = 0;
			return $this->data;
		}
	
	}
	
	public function traer_ingeniero($fecha, $ingeniero, $ans){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->query( 
		
			'SELECT COUNT(*) AS numero
				
				FROM t_incidencia, t_ans
				
				WHERE
				t_incidencia.id_ingeniero=\''.strip_tags( $ingeniero ).'\'
				AND
				t_incidencia.id_incidencia=t_ans.id_incidencia
				AND 
				t_incidencia.fecha like \''.strip_tags( $fecha ).'%\'
				AND
				t_ans.ans like \''.strip_tags( $ans ).'%\'

			' 
			
			
		);
				
		// Obtener datos
		if( $query->num_rows != 0 ){
			foreach ( $query->result() as $row ){
				$this->data[] = array( 
					'numero' => $row->numero,
				);
		  
			}
			
			return $this->data;	
				
		}else{
		
			$this->data['numero'] = 0;
			return $this->data;
		}
	
	}

	public function get_inges($id_inge){
        $id_inge1="";
		if($id_inge == 0){
			$this->db->select('id_ingeniero');
			$this->db->from('t_ingeniero');
			$consulta = $this->db->get();
			foreach($consulta->result() as $filas)
            {
                $id_inge1 .= $filas->id_ingeniero.','; 
            }
            $id_inge1=substr($id_inge1,0,-1);
        	$id_inge1.="";

        	return $id_inge1;
		}else{
        	return $id_inge;

		}

	}

	public function get_empresas($empresa){
		$empresa1="";
		if($empresa == 0){
			$this->db->select('id_cliente');
			$this->db->from('t_cliente');
			$consulta = $this->db->get();
			foreach($consulta->result() as $filas)
            {
                $empresa1 .= $filas->id_cliente.','; 
            }
            $empresa1=substr($empresa1,0,-1);
        	$empresa1.="";

        	return $empresa1;
		}else{
        	return $empresa;

		}
	}
	public function reporte_atencion($mes,$emp,$id_inge){
		$this->load->model( array( 'incidencia' ) );
		
		$empresa=$this->get_empresas($emp);
		$id_ingeniero=$this->get_inges($id_inge);
		$consulta = $this->db->query('SELECT COUNT(id_incidencia) as totalincidentes 
									from t_incidencia WHERE id_cliente IN('.$empresa.')
									and fecha LIKE "'.$mes.'%" and id_ingeniero 
									IN ('.$id_ingeniero.')');
		if($consulta->num_rows()>0)
		{
		   $row = $consulta->row(); 
		   return $row->totalincidentes;
		}else{
			return 0;
		}

	}	


	public function reporte_atencionc($mes,$emp,$id_inge){
		$this->load->model( array( 'incidencia' ) );
		
		$empresa=$this->get_empresas($emp);
		$id_ingeniero=$this->get_inges($id_inge);
		$consulta = $this->db->query('SELECT sum(SUBSTRING(fechaclick,11,9)) as fechaclick, 
									SUBSTRING(horas,11,9) as horas 
									FROM t_vistas WHERE empresa IN ('.$empresa.') 
									AND fechaclick LIKE "'.$mes.'%"
									and id_ingeniero IN ('.$id_ingeniero.')');
		if($consulta->num_rows()>0)
		{
		   $row = $consulta->row(); 
		   return $row->fechaclick;
		}else{
			return 0;
		}

	}
	
	public function reporte_atencionhoras($mes,$emp,$id_inge){		
		$empresa=$this->get_empresas($emp);
		$id_ingeniero=$this->get_inges($id_inge);
		$consulta = $this->db->query('SELECT SUBSTRING(fechaclick,11,9) as fechaclick, 
									click, sum(SUBSTRING(horas,11 , 9)) as horas 
									FROM t_vistas WHERE empresa IN ('.$empresa.') 
									AND fechaclick LIKE "'.$mes.'%" and 
									id_ingeniero IN ('.$id_ingeniero.') ');
		if($consulta->num_rows()>0)
		{
		   $row = $consulta->row(); 
		   return $row->horas;
		}else{
			return 0;
		}

	}

	public function reporte_read($empresa){
		$consulta = $this->db->query('SELECT tinci.id_incidencia, tinci.id_estado,
									tinci.id_cliente, tinci.id_ingeniero,
									tinci.id_condicion, tinci.id_subcategoria,
									tinci.id_area, tinci.id_contacto,
									tinci.asunto, tinci.detalle,
									SUBSTRING(tinci.fecha, 6,2) AS fecha,
									tinci.fecha_final, tinci.fecha_prioridad,
									tinci.causa, tinci.imagen 
									FROM t_incidencia tinci 
									WHERE id_cliente = '.$empresa);
		foreach($consulta->result() as $filas)
        {
            $fecha = $filas->fecha; 
            $id_cliente = $filas->id_cliente; 
        }

        return $fecha;
	}

	public function reporte_solucion($mes,$emp,$id_inge){
		$empresa=$this->incidencia->get_empresas($emp);
		$id_ingeniero=$this->get_inges($id_inge);
		$consulta = $this->db->query('SELECT sum(SUBSTRING(fecha, 11, 9))AS fecha1 
									FROM t_incidencia WHERE id_cliente IN ('.$empresa.') 
									and fecha LIKE "'.$mes.'%" and id_ingeniero IN ('.$id_ingeniero.')');
		if($consulta->num_rows()>0)
		{
		   $row = $consulta->row(); 
		   return $row->fecha1;
		}else{
			return 0;
		}
	}	

	public function reporte_solucion_final($mes,$emp,$id_inge){

		$empresa=$this->get_empresas($emp);
		$id_ingeniero=$this->get_inges($id_inge);
		$consulta = $this->db->query('SELECT sum(SUBSTRING(fecha_final, 11, 9))AS fecha_final
									 FROM t_incidencia WHERE id_cliente IN ('.$empresa.') 
									 and fecha LIKE "'.$mes.'%" and 
									 id_ingeniero IN ('.$id_ingeniero.')');
		if($consulta->num_rows()>0)
		{
		   $row = $consulta->row(); 
		   return $row->fecha_final;
		}else{
			return 0;
		}
	}

	public function reporte_cantidad_casos($mes,$mesVal,$emp){
		$empresa=$this->get_empresas($emp);
		$id_ingeniero=$this->get_inges(0);

		if($mesVal == 0){
			$separarMeses = explode(", ", $mes);
			$enero1 = $separarMeses[0];
			$febrero1 = $separarMeses[1];
			$marzo1 = $separarMeses[2];
			$abril1 = $separarMeses[3];
			$mayo1 = $separarMeses[4];
			$junio1 = $separarMeses[5];
			$julio1 = $separarMeses[6];
			$agosto1 = $separarMeses[7];
			$septiembre1 = $separarMeses[8];
			$octubre1 = $separarMeses[9];
			$noviembre1 = $separarMeses[10];
			$diciembre1 = $separarMeses[11];
			$eneroE = str_replace("'", "", $enero1);
			$febreroE = str_replace("'", "", $febrero1);
			$marzoE = str_replace("'", "", $marzo1);
			$abrilE = str_replace("'", "", $abril1);
			$mayoE = str_replace("'", "", $mayo1);
			$junioE = str_replace("'", "", $junio1);
			$julioE = str_replace("'", "", $julio1);
			$agostoE = str_replace("'", "", $agosto1);
			$septiembreE = str_replace("'", "", $septiembre1);
			$octubreE = str_replace("'", "", $octubre1);
			$noviembreE = str_replace("'", "", $noviembre1);
			$diciembreE = str_replace("'", "", $diciembre1);


			$consulta= $this->db->query("select COUNT(id_incidencia)as enero, 
							(select COUNT(id_incidencia) from t_incidencia 
							WHERE id_cliente IN (".$empresa.") and 
							fecha LIKE '".$febreroE."%' and 
							id_ingeniero IN (".$id_ingeniero."))as febrero,
							(select COUNT(id_incidencia) from 
							t_incidencia WHERE id_cliente IN (".$empresa.")
							and fecha LIKE '".$marzoE."%' and id_ingeniero 
							IN (".$id_ingeniero."))as marzo,
							(select COUNT(id_incidencia) 
							from t_incidencia WHERE id_cliente IN 
							(".$empresa.") and fecha LIKE '".$abrilE."%' 
							and id_ingeniero IN (".$id_ingeniero."))as abril,
							(select COUNT(id_incidencia) from t_incidencia
							WHERE id_cliente IN (".$empresa.") and fecha 
							LIKE '".$mayoE."%' and id_ingeniero IN
							(".$id_ingeniero."))as mayo,
							(select COUNT(id_incidencia) from
							t_incidencia WHERE id_cliente IN 
							(".$empresa.") and fecha LIKE '".$junioE."%' and 
							id_ingeniero IN (".$id_ingeniero."))as junio, 
							(select COUNT(id_incidencia) from t_incidencia 
							WHERE id_cliente IN (".$empresa.") and fecha 
							LIKE '".$julioE."%' and id_ingeniero 
							IN (".$id_ingeniero."))as julio, 
							(select COUNT(id_incidencia) from t_incidencia WHERE 
							id_cliente IN (".$empresa.") and fecha 
							LIKE '".$agostoE."%' and id_ingeniero 
							IN (".$id_ingeniero."))as agosto, 
							(select COUNT(id_incidencia) from t_incidencia 
							WHERE id_cliente IN (".$empresa.") and fecha
							LIKE '".$septiembreE."%' and id_ingeniero 
							IN (".$id_ingeniero."))as septiembre, 
							(select COUNT(id_incidencia) from t_incidencia 
							WHERE id_cliente IN (".$empresa.") and fecha 
							LIKE '".$octubreE."%' and id_ingeniero 
							IN (".$id_ingeniero."))as octubre, 
							(select COUNT(id_incidencia) from 
							t_incidencia WHERE id_cliente IN 
							(".$empresa.") and fecha LIKE '".$noviembreE."%' 
							and id_ingeniero IN (".$id_ingeniero."))as 
							noviembre, (select COUNT(id_incidencia) from 
							t_incidencia WHERE id_cliente IN (".$empresa.") 
							and fecha LIKE '".$diciembreE."%' and 
							id_ingeniero IN (".$id_ingeniero."))as 
							diciembre from t_incidencia WHERE id_cliente 
							IN (".$empresa.") and fecha LIKE '".$eneroE."%' 
							and id_ingeniero IN (".$id_ingeniero.") ");
		}else{
			$consulta = $this->db->query("select COUNT(id_incidencia)as totalincidentes 
								from t_incidencia WHERE id_cliente IN (".$empresa.") 
								and fecha LIKE '".$mes."%' and 
								id_ingeniero IN(".$id_ingeniero.") ");
		}

		foreach($consulta->result_array() as $row)
		{	
			if(isset($row['totalincidentes'])) {
				return $row['totalincidentes'];			
			}else{
				$meses= $enero=$row['enero'].",".
				$febrero=$row['febrero'].",".
				$marzo=$row['marzo'].",".
				$abril=$row['abril'].",".
				$mayo=$row['mayo'].",".
				$junio=$row['junio'].",".
				$julio=$row['julio'].",".
				$agosto=$row['agosto'].",".
				$septiembre=$row['septiembre'].",".
				$octubre=$row['octubre'].",".
				$noviembre=$row['noviembre'].",".
				$diciembre=$row['diciembre'];
			}
		}
			return $meses;
	}

	public function reporte_cantidad_casos_ing($mes,$mesVal,$emp,$inge){

		$empresa=$this->get_empresas($emp);
		$id_ingeniero=$this->get_inges($inge);
		
		if($mesVal == 0){
			$separarMeses = explode(", ", $mes);	 
			$enero1 = $separarMeses[0];
			$febrero1 = $separarMeses[1];
			$marzo1 = $separarMeses[2];
			$abril1 = $separarMeses[3];
			$mayo1 = $separarMeses[4];
			$junio1 = $separarMeses[5];
			$julio1 = $separarMeses[6];
			$agosto1 = $separarMeses[7];
			$septiembre1 = $separarMeses[8];
			$octubre1 = $separarMeses[9];
			$noviembre1 = $separarMeses[10];
			$diciembre1 = $separarMeses[11];

			$eneroE = str_replace("'", "", $enero1);
			$febreroE = str_replace("'", "", $febrero1);
			$marzoE = str_replace("'", "", $marzo1);
			$abrilE = str_replace("'", "", $abril1);
			$mayoE = str_replace("'", "", $mayo1);
			$junioE = str_replace("'", "", $junio1);
			$julioE = str_replace("'", "", $julio1);
			$agostoE = str_replace("'", "", $agosto1);
			$septiembreE = str_replace("'", "", $septiembre1);
			$octubreE = str_replace("'", "", $octubre1);
			$noviembreE = str_replace("'", "", $noviembre1);
			$diciembreE = str_replace("'", "", $diciembre1);

			$consulta =$this->db->query("select COUNT(id_incidencia)as enero,
								(select COUNT(id_incidencia) 
								from t_incidencia WHERE id_cliente 
								IN (".$empresa.") and fecha 
								LIKE '".$febreroE."%' and 
								id_ingeniero IN (".$id_ingeniero."))as 
								febrero, (select COUNT(id_incidencia) from 
								t_incidencia WHERE id_cliente 
								IN (".$empresa.") and fecha 
								LIKE '".$marzoE."%' and id_ingeniero 
								IN (".$id_ingeniero."))as marzo, 
								(select COUNT(id_incidencia) 
								from t_incidencia WHERE 
								id_cliente IN (".$empresa.") 
								and fecha LIKE '".$abrilE."%' 
								and id_ingeniero IN (".$id_ingeniero."))as abril,
								(select COUNT(id_incidencia) 
								from t_incidencia WHERE id_cliente
								IN (".$empresa.") and fecha 
								LIKE '".$mayoE."%' and 
								id_ingeniero IN (".$id_ingeniero."))as mayo, 
								(select COUNT(id_incidencia) from t_incidencia 
								WHERE id_cliente IN (".$empresa.") and 
								fecha LIKE '".$junioE."%' and id_ingeniero 
								IN (".$id_ingeniero."))as junio, 
								(select COUNT(id_incidencia) 
								from t_incidencia WHERE id_cliente
								IN (".$empresa.") and fecha 
								LIKE '".$julioE."%' and id_ingeniero 
								IN (".$id_ingeniero."))as julio, 
								(select COUNT(id_incidencia) from 
								t_incidencia WHERE id_cliente 
								IN (".$empresa.") and fecha 
								LIKE '".$agostoE."%' and id_ingeniero 
								IN (".$id_ingeniero."))as agosto,
								(select COUNT(id_incidencia) 
								from t_incidencia WHERE id_cliente 
								IN (".$empresa.") and fecha 
								LIKE '".$septiembreE."%' and 
								id_ingeniero IN (".$id_ingeniero."))as 
								septiembre, (select COUNT(id_incidencia) from 
								t_incidencia WHERE id_cliente IN (".$empresa.") and 
								fecha LIKE '".$octubreE."%' and id_ingeniero 
								IN (".$id_ingeniero."))as octubre,
								(select COUNT(id_incidencia) from t_incidencia 
								WHERE id_cliente IN (".$empresa.") and 
								fecha LIKE '".$noviembreE."%' and 
								id_ingeniero IN (".$id_ingeniero."))as 
								noviembre, (select COUNT(id_incidencia) 
								from t_incidencia WHERE id_cliente 
								IN (".$empresa.") and fecha 
								LIKE '".$diciembreE."%' and 
								id_ingeniero IN (".$id_ingeniero."))as 
								diciembre from t_incidencia WHERE id_cliente 
								IN (".$empresa.") and fecha LIKE '".$eneroE."%' and 
								id_ingeniero IN (".$id_ingeniero.") ");
	 
		}else{

			$consulta =$this->db->query("select COUNT(id_incidencia)as totalincidentes
								from t_incidencia WHERE id_cliente 
								IN (".$empresa.") and fecha LIKE '".$mes."%' and
								id_ingeniero IN (".$id_ingeniero.") ");
		}

		foreach($consulta->result_array() as $row)
		{	
			if(isset($row['totalincidentes'])) {
				return $row['totalincidentes'];			
			}else{
				$meses= $enero=$row['enero'].",".
				$febrero=$row['febrero'].",".
				$marzo=$row['marzo'].",".
				$abril=$row['abril'].",".
				$mayo=$row['mayo'].",".
				$junio=$row['junio'].",".
				$julio=$row['julio'].",".
				$agosto=$row['agosto'].",".
				$septiembre=$row['septiembre'].",".
				$octubre=$row['octubre'].",".
				$noviembre=$row['noviembre'].",".
				$diciembre=$row['diciembre'];
			}
		}
			return $meses;
	}

	public function incidencia1($id=NULL){
		
		$query = $this->db->get_where($this->table, array( 'id_incidencia' => $id ) );

		// Obtener datos
		if( $query->num_rows != 0 ){
			foreach ( $query->result() as $row ){
				$this->datos = array(
					'id_incidencia' => $row->id_incidencia,
					'id_estado' => $row->id_estado,
					'id_cliente' => $row->id_cliente,
					'id_ingeniero' => $row->id_ingeniero,
					'id_condicion' => $row->id_condicion,
					'id_subcategoria' => $row->id_subcategoria,
					'id_area' => $row->id_area,
					'id_contacto'=>$row->id_contacto,
					'asunto' => $row->asunto,
					'detalle' => $row->detalle,
					'fecha' => $row->fecha,
					'fecha_final' => $row->fecha_final,
					'fecha_prioridad' => $row->fecha_prioridad,
					'causa' => $row->causa,
					'imagen' => $row->imagen
				);
			}
			return $this->datos;
		}
	}
		
}
?>