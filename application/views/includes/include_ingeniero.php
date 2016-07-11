<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Config array vars and call template 
 */	
	$header = array( 'scripts' => $scripts, 'css' => $css , 'title' => $title );
	$this->load->view( 'includes/header_ingeniero', $header );
	$this->load->view( $content, array( 'login'=> $login ));
	$this->load->view( 'includes/footer', array( 'login'=> $login ) );

?>