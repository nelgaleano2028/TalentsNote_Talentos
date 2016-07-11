<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>
<!--content-main-->
<div id="content-main"> 
        <div class="title-cliente">
        <div class="admin">
            	 <span class="user-admin"><strong>Estadistica:</strong></span>
                 
            	
            </div>
         </div>
        <div class="content-on-blank">
        	
            
          
        	<form  action="" method="post" id="form">
            	
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Empresa</div>
                        <select name="id_cliente" id="id_cliente" class="required">
                        	<option value="">Seleccione...</option>
                           	<?php if( !empty( $clientes ) ): foreach( $clientes as $value ): ?>
                            	<option value="<?php echo $value['id_cliente'] ?>"><?php echo $value['nombre_cliente'] ?></option>
                            <?php endforeach; endif; ?>
                            
                        </select>
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">Contacto</div>
                        <select name="id_contacto" id="id_contacto" class="required">
                        	<option value="">Seleccione...</option>
                        </select>
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">Ingeniero</div>
                        <select name="id_ingeniero" id="id_ingeniero" class="required">
                        	<option value="">Seleccione...</option>
                            	<?php if( !empty( $ingenieros ) ): foreach( $ingenieros as $value ): ?>
                            	<option value="<?php echo $value['id_ingeniero'] ?>"><?php echo $value['nombre'] ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Fecha</div>
                        <input type="text" id="datepicker1" name="fecha" class="input-media">
                    </div>
                </div>
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Resueltos</div>
                        <input type="text" id="resueltos" name="resueltos" class="input-peque">
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">No Resueltos</div>
                        <input type="text" id="noresueltos" name="noresueltos" class="input-peque">
                    </div>
                </div>
                
               
                    <div class="clear"></div>
                    <div class="form-boton">
                   
                    </div>
                </div>
            	
            
            </form>
         	
                       
            <table id='myTable5'>
				<caption>Estadistica</caption>
				<thead>
					<tr>
						<th></th>
						<th>Realizadas</th>
						<th>No Realizadas</th>
												
					</tr>
				</thead>
					<tbody id="content_table">
					
				</tbody>
			</table>
            
         
            
        </div>    
</div>
<!--fin content-main-->