<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<!--content-main-->
<div id="content-main">      
        <div class="title-cliente"><span><strong>Conexión</strong></span></div>
        <div class="content-on-blank-table">
        	
            <?php $message = $this->session->flashdata( 'message' ); ?>
      
             <?php if( !empty( $message ) ): ?>
                   
              <!-- Notification messages -->
               <div class="nNote">
                   <?php if( $message['type'] == 'failure' ): ?>
                   <div class="nFailure">
                       <p><strong>ERROR: </strong><?php echo $message['text'] ?></p>
                   </div>
                   <?php endif; ?>
               	  
                   <?php if( $message['type'] == 'success' ): ?>
                   <div class="nSuccess">
                       <p><strong>Correcto: </strong><?php echo $message['text'] ?></p>
                   </div>
                   <?php endif; ?>
                  
               </div>
              
              <?php endif; ?>
            
            <!--table-->
        	<div class="table_incidente">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Tipo Conexión</th>
                        <th>Detalle</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php if( !empty( $data ) ): foreach( $data as $value ): ?>
                    
                    
                    
                    <tr >
                        <td><?php echo $value['id_conexion']?></td>
                        <td><?php echo $value['tipo_conexiones']?></td>
                        <td><?php echo $value['detalles']?></td>
                        <td><?php echo anchor( 'conexion/editar/'.$value['id_conexion'], 'Editar', array( 'title' => 'Editar Elemento' ) ) ?></td>
                        <td><a href="<?php echo base_url() ?>conexion/eliminar/<?php echo $value['id_conexion']?>" onclick="javascript: if( !confirm( 'Quiere eliminar este elemento ?' ) ) return false;">Eliminar</a></td>
                        
                    </tr>
                  	
                    
                    <?php endforeach; endif; ?>
                                      
                </tbody>
			</table>
            </div>
        	<!--Fin table-->
            
         
        </div>    
</div>