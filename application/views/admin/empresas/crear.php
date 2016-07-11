<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<!--content-main-->
<div id="content-main">      
        <div class="title-cliente"><span><strong>Crear Empresa</strong></span></div>
        <div class="content-on-blank">
        	
            <?php  $error= validation_errors(); ?>
            
            <?php  if( !empty( $error ) ): ?>
            	
                 <div class="nNote">
                        <div class="nWarning">
                           <p><strong>ADVERTENCIA: </strong><?php echo $error;?></p>
                        </div>
                 </div>
            	
            <?php endif; ?>
            
        	<form action="<?php echo base_url()?>empresas/crear" method="post" id="empresa">
            	<div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Empresa Administradora:</div>
                        <input type="text" name="nombre_empresa" id="nombre_empresa" class="required alphanumeric" value="<?php echo set_value('nombre_empresa')?>"/>
                    </div>
                </div>
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Nit:</div>
                        <input type="text" name="nit" id="nit" class="required nit" value="<?php echo set_value('nit')?>"/>
                    </div>
                </div>
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Telefono:</div>
                        <input type="text" name="telefono" id="telefono" class="required telefono" value="<?php echo set_value('telefono')?>"/>
                    </div>
                </div>
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Dirección:</div>
                        <input type="text" name="direccion" id="diereccion" class="required direccion" value="<?php echo set_value('direccion')?>" />
                    </div>
                </div>
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Website:</div>
                       <input type="text" name="website" id="web" class="required web" value="<?php echo set_value('website')?>"/>
                    </div>
                </div>
                
                <div class="fondo-form">
                    <div class="form-boton form-center">
                    	<input type="submit" class="form-insert"  value="Guardar"/>
                    </div> 
                </div>
       			<div class="clear"></div>
                <div class="top-form"></div>
            </form>
        </div>    
 </div>
<!--fin content-main-->

