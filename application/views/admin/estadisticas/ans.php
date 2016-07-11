<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>
<!--content-main-->
<div id="content-main"> 
        <div class="title-cliente">
            <div class="admin">
            	 <span class="user-admin"><strong>Reportes por mes:</strong></span>
                 
            	
            </div>
        </div>
        <div class="content-on-blank">
        
            <!--table-->
        	<div class="table_incidente">
            
                <form  action="<?php echo base_url()?>estadistica/reporte_ans/" method="post" id="form">
                            
                            <?php $message = $this->session->flashdata( 'message' ); ?>
                            <?php if( !empty( $message ) ): ?>
                       
                            <!-- Notification messages -->
                             <div class="nNote">
                                 <?php if( $message['type'] == 'failure' ): ?>
                                 <div class="nFailure">
                                     <p><strong>ERROR: </strong><?php echo $message['text'] ?></p>
                                 </div>
                                 <?php endif; ?>
                                
                             </div>
                            
                            <?php endif; ?> 
                             
                <div class="fondo-form">
                    <div class="form-l formulario">
                                        <div class="label">Elegir a&ntilde;o</div>
                                        <select name="anio" id="anio">
                                            
                                            <option value="0" >Seleccione...</option>
                                           
                                            <?php
                                             $anio=date('Y');
                                            for($i=2013; $i<=$anio+5; $i++):?>
                                                
                                                <option value="<?php echo $i?>"><?php echo $i?></option>
                                                
                                            <?php endfor;?>
                                        </select>
                                    </div>
                </div>
                            
                   <div class="fondo-form">
                        <div class="form-l formulario">
                                            <div class="label">Elegir empresa</div>
                                            <select name="empresa" id="empresa">
                                                
                                                 <option value="0">Seleccione...</option>
                                               
                                                <?php foreach($clientes as $cliente):?>
                                                
                                                    <option value="<?php echo $cliente['id_cliente']?>"><?php echo $cliente['nombre_cliente']?></option>
                                                    
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                        </div>
                            
                            
                             <div class="fondo-form">
                        
                            <div class="separar"></div>
                                <div class="form-boton2">
                                     <input type="submit" class="form-insert"  value="Generar Excel"/>
                                     <input type="button" class="form-insert"  id="est_mes" value="Generar Estadistica"/>
                                    
                                </div>
                            </div>
                            
                </form>
                
                <div class="clear"></div>
                <div class="separar"></div>   
            </div><!--Fin table-->
            <div class="clear"></div>
                <div class="separar"></div> 
            <div id="estadistica" style="display:none">
                    
                        
                        <div id="container" style="min-width: 400px; height:400px; margin: 0 auto;">
                            
                        </div>
            
            </div>
        </div>	
</div>
<!--fin content-main-->