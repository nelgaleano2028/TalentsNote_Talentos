<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>
<!--content-main-->
<div id="content-main"> 
        <div class="title-cliente">
        <div class="admin">
            	 <span class="user-admin"><strong>Estadisticas:</strong></span>
                 
            	
            </div>
         </div>
        <div class="content-on-blank">
        	
            
          
        	<form  action="" method="post" id="form">
            	
                
                <div class="fondo-form">
                    <div class="form-l formulario">
                    	<div class="label">Ingeniero</div>
                        <select name="ingeniero_1" id="ingeniero_1" class="required">
                        	<option value="">Seleccione...</option>
                           	<?php if( !empty( $ingenieros ) ): foreach( $ingenieros as $value ): ?>
                            	<option value="<?php echo $value['id_ingeniero'] ?>"><?php echo $value['nombre'] ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">Resueltos</div>
                        <input type="text" id="resueltos_1" class="input-peque">
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">No Resueltos</div>
                        <input type="text" id="noresueltos_1" class="input-peque">
                    </div>
                </div>
                
                <div class="fondo-form">
                    <div class="form-l formulario">
                    	<div class="label">Ingeniero</div>
                        <select name="ingeniero_2" id="ingeniero_2" class="required">
                        	<option value="">Seleccione...</option>
                           	<?php if( !empty( $ingenieros ) ): foreach( $ingenieros as $value ): ?>
                            	<option value="<?php echo $value['id_ingeniero'] ?>"><?php echo $value['nombre'] ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">Resueltos</div>
                        <input type="text" id="resueltos_2" class="input-peque">
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">No Resueltos</div>
                        <input type="text" id="noresueltos_2" class="input-peque">
                    </div>
                </div>
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Fecha</div>
                        <input type="text" id="datepicker2" class="input-media">
                    </div>
                </div>
                
               
                    <div class="clear"></div>
                    <div class="form-boton"> </div>
                    	
                    
               
            	
            
            </form>
         
         <table id='myTable5'>
				<caption>Estadistica</caption>
				<thead id="content_header">
					<tr>
						<th></th>
						<th>Primer Ingeniero Realizadas</th>
						<th>Primer Ingeniero No Realizadas</th>
						<th>Segundo Ingeniero Realizadas</th>
						<th>Segundo Ingeniero No Realizadas</th>						
					</tr>
				</thead>
					<tbody id="content_table">
					
				</tbody>
			</table>
         
        </div>    
</div>
<!--fin content-main-->