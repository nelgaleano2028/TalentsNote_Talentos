<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
          	<ol class="breadcrumb">
	            <li class=""><a href="<?php echo base_url()?>admin">Home</a></li>
	            <li class=""><a href"">Incidentes</a></li>
          	</ol> 
            <div class="container-fluid">
                <div class="row">
                	 <?php $message = $this->session->flashdata( 'message' ); ?>			
					<?php $message1 = $this->session->userdata( 'login' );
		            $id_ingeniero = $message1[0]['id_ingeniero'];  
				    // echo $id_ingeniero;
					?>
                  	<div class="panel-heading">
                   		<h2>Incidentes por Clientes</h2 > 
                  	</div>
                  	<div class="col-md-12 col-lg-12">
                  		<?php $message = $this->session->flashdata( 'message' ); ?>
                        <?php if( !empty( $message ) ): ?>
                            <?php if( $message['type'] == 'failure' ): ?>
                                <div id="men"  class="alert alert-danger" role="alert" >
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    <?php echo $message['text'] ?>
                                </div>
                            <?php endif; ?>
                            <?php if( $message['type'] == 'success' ): ?>
                                <div id="men" class="alert alert-success" role="alert" >
                                <?php echo "✔ ".$message['text'] ?>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <h2>Incidentes por Clientes</h2 > 
	                        </div>
	                        <div class="panel-body">
	                          	<table class="table table-striped table-bordered" id="example">
	                        		<thead>
					                    <tr>
					                        <th>Codigo</th>
					                        <th>Estado</th>
					                        <th>Asunto</th>
					                        <th>Fecha</th>
					                        <th>Prioridad</th>
					                        <th>Empresa</th>
					                    </tr>
					                </thead>
					                <tbody>
	                    				<?php if( !empty( $data ) ): foreach( $data as $value ): ?>
	                    				<tr>
					                        <td><?php echo $value['id_incidencia']?></td>
					                        <td><?php echo $value['estado'] ?></td>
					                        <td><?php echo anchor( '/ingeniero/incidente_crear/'.$value['id_incidencia'].'/'.$value['id_ingeniero'], $value['asunto'])?></td>
					                        <td class="center"><?php echo $value['fecha'] ?></td>
					                        <td class="center">
				                        	<?php
				                        	    switch( $value['condicion'] ):
											
													case 'Alta':
														echo '<span class="label" style="background-color: #FF7600;">'.$value['condicion'].'</span>';
													break;
												        case 'Media':
														echo '<span class="label label-warning" >'.$value['condicion'].'</span>';
													break;
												        case 'Baja':
														echo '<span class="label" style="background-color:#F3C17B">'.$value['condicion'].'</span>';
													break;
												        case 'Muy alta':
														echo '<span class="label label-danger">'.$value['condicion'].'</span>';
													break;
												endswitch;  
											?>	
						 					</td>
	                        				<td class="center"><?php echo $value['cliente'] ?></td>
	                   	 				</tr>
	                   					<?php endforeach;
			   							endif; ?>
	                				</tbody>
			  						<tfoot>
					                    <tr>
					                        <th ><input type="text" name="search_engine" value="" class="search_init" /></th>
					                        <th><input type="text" name="search_engine" value="" class="search_init" /></th>
					                        <th><input type="text" name="search_engine" value="" class="search_init" /></th>
					                        <th><input type="text" name="search_engine" value="" class="search_init" /></th>
					                        <th></th>
					                        <th><input type="text" name="search_engine" value="" class="search_init" /></th>
					                    </tr>
	        						</tfoot>
	                          	</table>
	                        </div>
	                    </div>
                	</div>
            	</div>
        	</div>
    	</div>
	</div>

