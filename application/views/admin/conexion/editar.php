<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<!--content-main-->
<div id="content-main">    
        <div class="title-cliente"><span><strong>Editar Conexión</strong></span></div>
        <div class="content-on-blank">
        	
            <?php  $error= validation_errors(); ?>
            
            <?php  if( !empty( $error ) ): ?>
            	
                 <div class="nNote">
                        <div class="nWarning">
                           <p><strong>ADVERTENCIA: </strong><?php echo $error;?></p>
                        </div>
                 </div>
            	
            <?php endif; ?>
          
        	<form name="form" action="<?php echo base_url() ?>conexion/editar/<?php echo $data[0]['id_conexion'] ?>" method="post" id="form">
            	<div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Tipo de Conexion (ej: VPN, TEAMVIWER):</div>
                        
                        <select id="id_tipo_conexion" name="id_tipo_conexion" class="requiered">
                      			<option value="">Seleccione</option>
                                
                                <?php if( !empty( $tipo_conexion ) ): foreach( $tipo_conexion as $value ): ?>
                                	
                                    <option <?php  if( $data[0]['id_tipo_conexion'] == $value['id_tipo_conexion'] ) echo 'selected="selected"'; ?> value="<?php echo $value['id_tipo_conexion'] ?>"><?php echo $value['tipo_conexiones'] ?></option>
                                
                                <?php endforeach; endif; ?>
                                  
                        </select>
                      
                    </div>
                </div>
                
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Detalle:</div>
                        <input type="text" name="detalles" id="detalles" value="<?php echo set_value( 'detalles', $data[0]['detalles'] ) ?>"/>
                    </div>
                </div>
                
                <div class="fondo-form">
                    <div class="form-boton form-center">
                    	<input type="submit" class="form-insert"  value="Guardar"/>
                         <input type="reset" class="form-insert" id="reset"  value="Limpiar"/>
                    </div>
                    
                </div>
            	<div class="clear"></div>
                <div class="top-form"></div>
            
            </form>
         
        </div>    
</div>
<!--fin content-main-->