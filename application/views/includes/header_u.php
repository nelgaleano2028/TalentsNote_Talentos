<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo doctype('html5'); ?>

<head>
	<?php echo meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>
	<meta http-equiv="Content-Language" content="es">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<title><?php echo $title ?></title>
    <link href="<?php echo base_url(); ?>images/logo_login.png" type="image/x-icon" rel="icon">
	
    <!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
    
    <link href='http://fonts.googleapis.com/css?family=Quattrocento' rel='stylesheet' type='text/css'>
    <link href='<?php echo base_url()?>style/mensajes.css?<?php echo date('Y-m-d H:i:s'); ?>' rel='stylesheet' type='text/css'>
   <link type='text/css' href="<?php echo base_url() ?>style/cssfamily.css" rel='stylesheet'>
	<link type="text/css" href="<?php echo base_url() ?>style/font-awesome.min.css" rel="stylesheet">       
	<link type="text/css" href="<?php echo base_url() ?>style/themify-icons/themify-icons.css" rel="stylesheet">                       
	<link type="text/css" href="<?php echo base_url() ?>style/weather-icons.min.css" rel="stylesheet">     
    <link rel="stylesheet" href="<?php echo base_url() ?>style/style-alternative.css?>" type="text/css" id?"theme" />
    <link rel="stylesheet" href="<?php echo base_url() ?>style/styles.css?>" type="text/css" media="screen" />
	<link type="text/css" href="<?php echo base_url() ?>style/prettify.css" rel="stylesheet">               
	<link type="text/css" href="<?php echo base_url() ?>style/blue.css" rel="stylesheet"> 
	<link type="text/css" href="<?php echo base_url() ?>style/bootstrap/bootstrap.css" rel="stylesheet"> 
    
           
	<!-- Print dinamical files css -->
	<?php 
	if( !empty( $css ) ):
		
		foreach( $css as $key => $value ):
				
			echo $value ;
		
		endforeach;
				
	endif;
	?>
	<!-- EndPrint dinamical files css -->
        
    
	
</head>

<body> 