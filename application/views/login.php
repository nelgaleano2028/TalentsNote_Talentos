<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>
	
<body class="focused-form">      
<div class="container" id="login-form">
  <div style="text-align: center;  display: block;  margin-top: 120px; margin-bottom:30px;"><img src="<?php echo base_url()?>images/logo_login.png" width="100" height="100">
  <h2 style="color:#337AB7; font-size:40px; ">Talents Notes</h2></div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
	        <div class="panel-heading">
	           	<h2>Bienvenido</h2>
	        </div>
	        <?php $message = $this->session->flashdata( 'message' ); ?>
			<?php if( !empty( $message ) ): ?>
                    <?php if($message['text']) echo '<div class="alert alert-danger" role="alert">'.$message['text'].'</div>';?>						
			<?php endif; ?>
		     <?php $errores = $this->session->flashdata('errores');?>
                <?php  if($errores): ?>
                        <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                        <?php if($errores['clave']) echo '<div class="alert alert-danger" role="alert">'.$errores['clave'].'</div>';?>
                <?php endif; ?>
	        <div class="panel-body">  
	            <form  action="<?php echo base_url();?>usuario/login" class="form-horizontal" id="formlogin" method="post" accept-charset="utf-8">
	             	<div class="form-group mb-md">
	                    <div class="col-xs-12">
	                        <div class="input-group">             
			                    <span class="input-group-addon">
			                      <i class="ti ti-user"></i>
			                    </span>
	                    		<input type="text" class="form-control" name="username" id="username" placeholder="Username" required value="<?php echo set_value('usuario'); ?>">
	                  		</div>
	                    </div>
	                </div>

	                <div class="form-group mb-md">
	                    <div class="col-xs-12">
	                      	<div class="input-group">
			                    <span class="input-group-addon">
			                      <i class="ti ti-key"></i>
			                    </span>
			                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
	                  		</div>
	                    </div>
	                </div>

	                <div class="form-group mb-n">
		                <div class="col-xs-12">
			                <a href="<?php echo base_url()?>usuario/vistarecordar" class="pull-left">Recordar Contraseña</a>
			                <div class="checkbox-inline icheck pull-right p-n">
			                </div>
		                </div>
	                </div>
	        </div>
	          	<div class="panel-footer">
		            <div class="clearfix">
						<input type="submit" value="Ingresar" id="entrar" class="btn btn-primary pull-right" />
		            </div>
	          	</div>
        	</div>
        	</form>
      	</div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Recomendación</h4>
		    </div>
	      	<div class="modal-body">
	        	<p>Se recomienda el uso de Google Chrome, Mozilla Firefox e Internete Explorer de la versión 10 en adelante
	        	para una correcta visualización y funcionalidad. </p>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      	</div>
	    </div>
	</div>
</div>
