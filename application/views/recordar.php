<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>
	
<body class="focused-form">      
	<div class="container" id="forgotpassword-form">
		<div style="text-align: center;  display: block;  margin-top: 120px; margin-bottom:30px;"><img src="<?php echo base_url()?>images/logo_login.png" width="100" height="100">
  			<h2 style="color:#337AB7; font-size:40px; ">Talents Notes</h2></div>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2>Recordar Contraseña</h2>
					</div>
					<?php $message = $this->session->flashdata( 'message' ); ?>
					<?php if( !empty( $message ) ): ?>
		                    <?php if($message['text']) echo '<div class="alert alert-danger" role="alert">'.$message['text'].'</div>';?>						
					<?php endif; ?>
				     <?php $errores = $this->session->flashdata('errores');?>
		                <?php  if($errores): ?>
		                        <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
		                <?php endif; ?>
					<div class="panel-body">
						<form action="" class="form-horizontal">
							<div class="form-group mb-n">
		                        <div class="col-xs-12">
		                        	<p>Ingrese su correo para restaurar su contraseña</p>
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="ti ti-user"></i>
										</span>
										<input type="text" class="form-control" placeholder="Email">
									</div>
		                        </div>
							</div>
						</form>
					</div>
					<div class="panel-footer">
						<div class="clearfix">
							<a href="<?php echo base_url()?>usuario/login" class="btn btn-default pull-left">Regresar</a>
							<a href="<?php echo base_url()?>usuario/recuperar" class="btn btn-primary pull-right">Enviar</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>