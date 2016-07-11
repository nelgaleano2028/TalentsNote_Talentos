<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Model {

// Id	
	private $id = null;

// Save data	
	private $data = array();

// Table usage	
	private $table = 't_usuario';
	
		
    public function __construct(){  parent::__construct(); }
	

/*
====================================
	Funciones CRUD
==================================== */	
	public function crear( $values = array() ){
		
		// Validar información
		if( empty( $values ) ) return false;
		
		$values['salt'] = $this->_create_salt();
		
		$values['contraseña']=sha1($values['contraseña'].$values['salt']);
		
		
		// Configurar información a guardar
		foreach( $values as $key => $value )									
				$this->data[$key] = $value ; 		
		
		
		// Crear registro	
	    if( $this->db->insert( $this->table, $this->data )  )
        	return true;
            else
        	return false;
        
		
	}
	
	protected function _create_salt()
	{
		$this->load->helper('string');
		return sha1(random_string('alnum', 32));
	}
	
	public function editar( $id = null, $values = array() ){
		
		// Validar id e información
		if( empty( $id ) or !is_numeric( $id ) or empty( $values ) ) return false;
		$values['salt'] = $this->_create_salt();
		$values['contraseña']=sha1($values['contraseña'].$values['salt']);
		foreach( $values as $key => $value )									
				$this->data[$key] = $value ; 

		// Editar registros					
	    if( $this->db->update($this->table, $values,array( 'id_usuario' => $id ) ) )
        	return true;
        else
        	return false;
	}
	
	public function eliminar( $id = null ){
		
		// Validar id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		// Eliminar registro					
	    if( $this->db->delete( $this->table, array( 'id_usuario' => $id ) ) )
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
		$query = $this->db->get_where( $this->table, array( 'id_usuario' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_usuario' => $row->id_usuario,
					'id_contacto' => $row->id_contacto,
					'id_perfil' => $row->id_perfil,
					'id_ingeniero' => $row->id_ingeniero,
					'Usuario' => $row->Usuario,
					'contraseña' => $row->contraseña,						
					'estado' => $row->estado,						
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}

	public function id2($id=null,$campo){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( $campo => $id));
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_usuario' => $row->id_usuario,
					'id_contacto' => $row->id_contacto,
					'id_perfil' => $row->id_perfil,
					'id_ingeniero' => $row->id_ingeniero,
					'Usuario' => $row->Usuario,
					'contraseña' => $row->contraseña,						
					'estado' => $row->estado,						
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	
	public function contrasena_cliente( $id = null , $password){
	
	
	
		$this->db->select('salt');
		$this->db->from($this->table);
		$this->db->where('id_contacto', $id);
		$query=$this->db->get();
		// Obtener datos
		if( $query->num_rows != 0 ){
			foreach ( $query->result() as $row ){
				
				$pass=sha1($password.$row->salt);
				$this->db->select('contraseña');
		                $this->db->from($this->table);
		                $this->db->where('id_contacto', $id);
				$this->db->where('contraseña', $pass);
				$q=$this->db->get();
				
				if( $q->num_rows != 0 ){

					return true;
				}else{
					return false;
				}
			}
				
		}else
			return false;
		
	}
	
	
	public function contrasena_ingeniero( $id = null , $password){
	
		$this->db->select('salt');
		$this->db->from($this->table);
		$this->db->where('id_ingeniero', $id);
		$query=$this->db->get();
		// Obtener datos
		if( $query->num_rows != 0 ){
			foreach ( $query->result() as $row ){
				
				$pass=sha1($password.$row->salt);
				$this->db->select('contraseña');
		                $this->db->from($this->table);
		                $this->db->where('id_ingeniero', $id);
				$this->db->where('contraseña', $pass);
				$q=$this->db->get();
				
				if( $q->num_rows != 0 ){

					return true;
				}else{
					return false;
				}
			}
				
		}else
			return false;
		
	}
	
	public function contrasena_admin($password){
		
		$this->db->select('salt');
		$this->db->from($this->table);
		$this->db->where('id_usuario', 1);
		$query=$this->db->get();
		
		if( $query->num_rows != 0 ){
			foreach ( $query->result() as $row ){
				
				$pass=sha1($password.$row->salt);
				$this->db->select('contraseña');
		                $this->db->from($this->table);
		                $this->db->where('id_usuario', 1);
				$this->db->where('contraseña', $pass);
				$q=$this->db->get();
				
				if( $q->num_rows != 0 ){

					return true;
				}else{
					return false;
				}
			}
			
			return $this->data;	
				
		}else
			return false;
			
	}
	
	public function editar_admin( $values = array() ){
		
		unset($values['contrasena_original'], $values['re_contrasena']);
		$contrasena=$values['contrasena'];
		$salt=$this->_create_salt();
		$contrasena=sha1($contrasena.$salt);
		$contrasena=array(
		 	'contraseña'=> $contrasena,
			'salt'=>$salt
		);
		
		if( $this->db->update( 't_usuario', $contrasena, array( 'id_usuario' => 1 ) ) )
			return true;
		else
			return false;	
	}
	
	public function all(){
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get( $this->table );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			// Load Model
			$this->load->model( array( 'contactos', 'empresa','perfiles' ) );
			
			foreach ( $query->result() as $row ){
				$perfil = $this->perfiles->id($row->id_perfil);
				$contacto = $this->contactos->id( $row->id_contacto );

				$this->data[] = array( 
					'id_usuario' => $row->id_usuario,
					'contacto' => $contacto[0]['nombre'],
					'id_perfil' => $row->id_perfil,
					'perfil' => $perfil[0]['nombre_perfil'],
					'id_ingeniero' => $row->id_ingeniero,
					'Usuario' => $row->Usuario,
					'estado'=> $row->estado					
				);
			}
			return $this->data;	
		}else
			return false;
	}
	
	public function ver_usuario( $username= null){
		
		if( empty( $username ) ) return false;
		
		$this->db->select('Usuario,id_usuario,id_contacto,id_ingeniero');
		$this->db->from($this->table);
		$this->db->where('Usuario', $username);
		$query=$this->db->get();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$password=$this->_nueva_contrasena();
				$salt=$this->_create_salt();
			
				$cambiar= array(
				'contraseña'=>sha1($password.$salt),	
				'salt'=>$salt,
				
				);

		       if( $this->db->update( $this->table, $cambiar, array( 'id_usuario' => $row->id_usuario ))){
			
					if($row->id_contacto !='')
					{
						$this->_email_recordar_contact($row->id_contacto, $password, $row->Usuario );
						return true;
							  
					}elseif($row->id_ingeniero !=''){
						
						$this->_email_recordar_ing($row->id_ingeniero, $password, $row->Usuario);
						return true;
						
					}elseif($row->id_usuario == 1){
						
						$this->_email_recordar_admin($password);
						return true;
					}
		        }	
			}
		
		}else
		   return false;
		
	}
	
        protected function _email_recordar_contact($contacto = null, $password, $usuario){
				
		$this->db->select('correo, nombre, apellido');
		$this->db->from('t_contacto');
		$this->db->where('id_contacto', $contacto);
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			foreach($query->result() as $row){
				
				$this->load->library('My_PHPMailer');
				$mail = new PHPMailer();
						 $mail->Host = "localhost";
						 $mail->From = "vladimir.bello@talentsw.com"; 
						 $mail->FromName = "Administrador AFQsas";
						 $mail->Subject = 'Cambio de contrasena';
						 $mail->AddAddress($row->correo,$row->nombre.''.$row->apellido);
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
										<tbody><tr><td class="w30" width="30"></td><td class="w580" width="580" height="30"><h1 style="color: #47c8db !important; font: bold 32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"><singleline label="Title">Administrador AFQsas</singleline></h1></td><td class="w30" width="30"></td></tr>
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
										</tbody>
										</table>
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
															   <td><strong>Estimado Usuario: '.$usuario.'</strong> </td>
															   <td>&nbsp;</td>
															</tr>
											  
											                                <tr>
															   <td><strong>Conforme a tu solicitud, tu contrasena se ha restablecido. Tus nuevos detalles son los siguientes:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
											  
											                                 
															<tr>
															   <td><strong>Usuario:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>'.$usuario.'</td>
															   
															</tr>    
															<tr>
															   <td><strong>Nueva Contrasena:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>'.$password.'</td>
															   
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															 <tr>
															   <td><strong>Pulsa en el siguiente link para redireccionar a TALENTS NOTES 2.0</strong> </td>
															   <td></td>
															</tr>
															<tr>
															   <td><a href="$base_url()talentsnote2/">$base_url()talentsnote2/</a></td>
															   
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
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
						 $mail->send();	 
				
			}
		}
				
		
	}
	
	protected function _email_recordar_ing($ingeniero = null, $password, $usuario){
				
		$this->db->select('correo, nombre');
		$this->db->from('t_ingeniero');
		$this->db->where('id_ingeniero', $ingeniero);
		$query=$this->db->get();
		
		if($query->num_rows != 0){
			foreach($query->result() as $row){
				
				$this->load->library('My_PHPMailer');
				$mail = new PHPMailer();
						 $mail->Host = "localhost";
						 $mail->From = "vladimir.bello@talentsw.com"; 
						 $mail->FromName = "Administrador AFQsas";
						 $mail->Subject = 'Cambio de contrasena';
						 $mail->AddAddress($row->correo,$row->nombre);
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
										<tbody><tr><td class="w30" width="30"></td><td class="w580" width="580" height="30"><h1 style="color: #47c8db !important; font: bold 32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"><singleline label="Title">Administrador AFQsas</singleline></h1></td><td class="w30" width="30"></td></tr>
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
															   <td><strong>Estimado Usuario: '.$usuario.'</strong> </td>
															   <td>&nbsp;</td>
															</tr>
											  
											                                <tr>
															   <td><strong>Conforme a tu solicitud, tu contrasena se ha restablecido. Tus nuevos detalles son los siguientes:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
											  
											                                 
															<tr>
															   <td><strong>Usuario:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>'.$usuario.'</td>
															   
															</tr>    
															<tr>
															   <td><strong>Nueva Contrasena:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>'.$password.'</td>
															   
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															 <tr>
															   <td><strong>Pulsa en el siguiente link para redireccionar a TALENTS NOTES 2.0</strong> </td>
															   <td></td>
															</tr>
															<tr>
															   <td><a href="$base_url()talentsnote2/">$base_url()talentsnote2/</a></td>
															   
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
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
						 $mail->send();	 
				
			}
		}
				
		
	}
	
	protected function _email_recordar_admin($password){
						
				$this->load->library('My_PHPMailer');
				$mail = new PHPMailer();
						 $mail->Host = "localhost";
						 $mail->From = "vladimir.bello@talentsw.com"; 
						 $mail->FromName = "Administrador AFQsas";
						 $mail->Subject = 'Cambio de contrasena del administrador';
						 //$mail->AddAddress('vladimir.bello@talentsw.com','administrador');
						 $mail->AddAddress('quake2400@gmail.com','administrador');
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
										<tbody><tr><td class="w30" width="30"></td><td class="w580" width="580" height="30"><h1 style="color: #47c8db !important; font: bold 32px Helvetica, Arial, sans-serif; margin: 0; padding: 0; line-height: 40px;"><singleline label="Title">Administrador AFQsas</singleline></h1></td><td class="w30" width="30"></td></tr>
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
															   <td><strong>Estimado Usuario: administrador</strong> </td>
															   <td>&nbsp;</td>
															</tr>
											  
											                                <tr>
															   <td><strong>Conforme a tu solicitud, tu contrasena se ha restablecido. Tus nuevos detalles son los siguientes:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
											  
											                                 
															<tr>
															   <td><strong>Usuario:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>administrador</td>
															   
															</tr>    
															<tr>
															   <td><strong>Nueva Contrasena:</strong> </td>
															   <td>&nbsp;</td>
															</tr>
															<tr>
															   <td>'.$password.'</td>
															   
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															 <tr>
															   <td><strong>Pulsa en el siguiente link para redireccionar a TALENTS NOTES 2.0</strong> </td>
															   <td></td>
															</tr>
															<tr>
															   <td><a href="$base_url()talentsnote2/">$base_url()talentsnote2/</a></td>
															   
															</tr>
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
															</tr>
															
															<tr>
															   <td>&nbsp;</td>
															   
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
						 $mail->send();	 	
	}
	
	protected function _nueva_contrasena()
	{
		$this->load->helper('string');
		return random_string('alnum', 6);
	}
	
	public function login( $values = array() ){
		
		// Validacion id
		if( empty( $values ) ) return false;
		
		$pass=$this->eligir_pass($values['username']);
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'Usuario' => $values['username'], 'contraseña' => sha1($values['password'].$pass[0]['salt']) ) );

        unset($this->data); $this->data = array();
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			foreach ( $query->result() as $row ){
				
				$this->data[] = array( 
					
					'id_usuario' => $row->id_usuario,
					'id_contacto' => $row->id_contacto,
					'id_perfil' => $row->id_perfil,
					'id_ingeniero' => $row->id_ingeniero,
					'Usuario' => $row->Usuario,
					'estado'=> $row->estado
																
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
		
	}
	
	
	public function eligir_pass( $usuario ){
		
		
		unset( $this->data ); $this->data = array();
		
		$this->db->select("salt");
		$this->db->from($this->table);
		$this->db->where('Usuario', $usuario); 
		$result=$this->db->get();
		
		
		if($result->num_rows != 0){
			
		  foreach ( $result->result() as $row ){
			  	
				$this->data[]=array(
					'salt'=>$row->salt
				);
					
				
			  
		   }
			return $this->data;	
		}
		
	}
/*
====================================
	Funciones Para obtener datos
==================================== */	

	public function entrar_cliente( $id= null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_contacto' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			$this->load->model('contactos');
			
			foreach ( $query->result() as $row ){
				
				$contacto = $this->contactos->id( $row->id_contacto );
				
				$this->data[] = array( 
					'img'=>$contacto[0]['img'],
					'Usuario' => $row->Usuario					
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
	}
	
	public function entrar_ingeniero( $id=null ){
		
		// Validacion id
		if( empty( $id ) or !is_numeric( $id ) ) return false;
		
		unset( $this->data ); $this->data = array();
		
		// Consulta
		$query = $this->db->get_where( $this->table, array( 'id_ingeniero' => $id ) );
		
		// Obtener datos
		if( $query->num_rows != 0 ){
			
			$this->load->model('ingenieros');
			
			foreach ( $query->result() as $row ){
				
				$contacto = $this->ingenieros->id( $row->id_ingeniero );
				
				$this->data[] = array( 
					'img'=>$contacto[0]['img'],
					'Usuario' => $row->Usuario					
										
				);
		  
			}
			
			return $this->data;	
				
		}else
			return false;
	}
			
}
?>