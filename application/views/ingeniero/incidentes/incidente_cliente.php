<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<!--content-main-->
<div id="content-main"> 
        <div class="title-cliente">
        <div class="ingeniero">
            	 <span class="user-admin"><strong>Incidentes por Clientes:</strong></span>
                 
            	
            </div>
         </div>
        <div class="content-on-blank">
        	<!--table-->
        	<div class="table">
            	<table class="incidencias">
                	<tr>
                    	<th>Codigo</th>
                        <th>Estado</th>
                        <th>Asunto</th>
                        <th>Fecha</th>
                        <th>Autor</th>
                        <th>Subcategoría</th>
                        <th>Prioridad</th>
                        <th>Causa</th>
                    </tr>
                 
                    <tr>
                        <td>12</td>
                        <td>Cerrado</td>
                        <td>Prima extra legal debe ser 5 dias</td>
                        <td class="center">23:55:38 Horas</td>
                        <td class="center">Rfranco America</td>
                        <td class="center">Prima</td>
                        <td class="center">Alta</td>
                        <td class="center">sin definir</td>
                    </tr>
                   
                </table>
                <div class="separar"></div>
                <table cellpadding="0" cellspacing="0" border="0" class="incidencias">
                	<tr>
                    	<caption>Detalle</caption>
                       
                    </tr>
                 
                    <tr>
                        <td>Buenas Tardes Por favor revisar la Prima extralegal, ya que esta liquidando diez dias de salario y deben de ser cinco dias. Gracias, Nubia Lopez</td>
                    </tr>
                   
                </table>
                 <div class="separar"></div> 
                 <form method="post" name="incidente" id="incidente">
                 
                 	<div class="fondo-form">
                        <div class="form-l">
                            <div class="label">Nota:</div>
                           
                        </div>
               		</div>
                    
                    <div class="fondo-form">
                        <div class="form-center formulario">
                           <textarea></textarea>
                           
                        </div>
               		</div>
                    
                     
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Actualizar Estado Incidencia:</div>
                        <select name="estado" >
                        	<option value="">Abiero y sin resolver</option>
                            <option value="">Cerrado y resuelto	</option>
                        </select>
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">Actualizar Prioridad:</div>
                        <select name="prioridad" >
                        	<option value="">Alta</option>
                            <option value="">Media</option>
                            <option value="">Baja</option>
                        </select>
                    </div>
                    
                    <div class="form-l formulario">
                    	<div class="label">Actualizar Area:</div>
                        <select name="area" >
                        	<option value="">Desarrollo</option>
                            <option value="">Soporte</option>
                        </select>
                    	</div> 
                </div>
                
                <div class="fondo-form">
                	<div class="form-l formulario">
                    	<div class="label">Causa:</div>
                        <select name="causa" >
                        	<option value="">Error de la aplicación</option>
                            <option value="">Error de Usuario</option>
                        </select>
                        
                        
                    </div>
                    <div class="clear"></div>
                    <div class="form-boton">
                    	<input type="button" class="form-insert"  value="Insertar"/>
                    </div>
                </div>
                 
                 </form>
                 <div class="clear"></div>
                 <div class="separar"></div>
                 
                <table cellpadding="0" cellspacing="0" border="0" class="incidencias">
                	<tr>
                    	<caption>Nota</caption>
                       
                    </tr>
                 
                    <tr>
                        <td>27/05/2011. Se modifico el concepto 48 Prima Extralegal, para que liquidara cinco dias de salario basico. Se envia a prueba por el usuario.</td>
                    </tr>
                   
                </table>

                 <div class="clear"></div>
                <div class="top-form"></div>
    	
            </div>
            <!--table-->
        </div>    
</div>
<!--fin content-main-->