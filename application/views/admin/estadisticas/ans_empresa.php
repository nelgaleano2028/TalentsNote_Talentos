<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>
<!--content-main-->
<div id="content-main"> 
        <div class="title-cliente2">
            <div class="admin">
            	 <span class="user-admin"><strong>Ans por Empresa</strong></span>	
            </div>
        </div>
        <div class="content-on-blank">
            
            <!--table-->
        	<div class="table_incidente">
                <form  id="form" action="<?php echo base_url() ?>estadistica/reporte_empresa/" method="post" >
                            <div class="fondo-form">
                    <div class="form-l formulario">
                                        <div class="label">Elegir a&ntilde;o</div>
                                        <select name="anio" id="anio">
                                            
                                            <option value="0">Seleccione...</option>
                                           
                                            <?php
                                             $anio=2013;
                                            for($i=2013; $i<=$anio+5; $i++):?>
                                                
                                                <option value="<?php echo $i?>"><?php echo $i?></option>
                                                
                                            <?php endfor;?>
                                        </select>
                                    </div>
                   </div>
                             
                            
                            <div class="fondo-form">
                    <div class="form-l formulario">
                                        <div class="label">Elegir mes</div>
                                        <select name="mes" id="mes">
                                            
                                             <option value="0">Seleccione...</option>
                                           
                                            <?php foreach($mes as $key=>$val):?>
                                            
                                                <option value="<?php echo $key?>"><?php echo $val?></option>
                                                
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                    </div>
                    
                      <div class="fondo-form">
                                 <div class="form-l formulario">
                                        <div class="label">Elegir Cliente</div>
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
                                    <input type="button" class="form-insert"  id="est_empresa" value="Generar Estadistica"/>
                                    
                                </div>
                            </div>
         
                </form>
                
                <div class="clear"></div>
                <div class="separar"></div>
            </div><!--Fin table-->
              
            <div id="estadistica" style="display:none">
                        <table class="incidencias" cellpadding="0" cellspacing="0" border="0"  id="example">
                            <thead>
                                <tr>
                                    
                                    <th>Estado</th>
                                    <th>% Porcentaje</th>
                         
                                </tr>
                            </thead>
                                <tbody id="content_table">
                                
                                </tbody>
                        </table>
                        
                        <div id="container">
                            
                        </div>
            
            </div>
        </div>	
</div>
<!--fin content-main-->