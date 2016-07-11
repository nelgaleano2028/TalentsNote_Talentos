<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>
<!--content-main-->
<div id="content-main"> 
        <div class="title-cliente">
            <div class="admin">
            	 <span class="user-admin"><strong>Por Ingeniero</strong></span>
                 
            	
            </div>
        </div>
        <div class="content-on-blank">
            
             <!--table-->
            <div class="table_incidente">
                <form  action="<?php echo base_url() ?>estadistica/reporte_ansingeniero/" method="post" id="form">

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
                                        <div class="label" >Elegir a&ntilde;o</div>
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
                                        <div class="label">Elegir ingeniero</div>
                                        <select name="ingeniero" id="ingeniero">

                                             <option value="0">Seleccione...</option>

                                            <?php foreach($ingenieros as $ingeniero):?>

                                                <option value="<?php echo $ingeniero['id_ingeniero']?>"><?php echo $ingeniero['nombre']?></option>

                                            <?php endforeach;?>
                                        </select>
                                    </div>
                            </div>


                             <div class="fondo-form">

                            <div class="separar"></div>
                                <div class="form-boton2">
                                    <input type="submit" class="form-insert"  value="Enviar"/>
                                    <input type="button" class="form-insert"  id="est_ing" value="Generar Estadistica"/>

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