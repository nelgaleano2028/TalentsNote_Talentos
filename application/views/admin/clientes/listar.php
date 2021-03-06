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
				<li class="active"><a href="">Clientes</a></li>
			</ol> 
			<div class="container-fluid">
				<div class="row">
					<div class="panel-heading">
						<h2 class="panel-head">Clientes Registrados</h2 >
                    	<a href="#" data-toggle="modal" class="btn btn-primary btn-crear" data-target="#mimodal">Crear <i class="fa fa-plus"></i></a>
						<!-- <a class="btn btn-primary btn-crear" href="<?php echo base_url()?>clientes/crear/" >Crear <i class="fa fa-plus"></i></a>  -->
					</div>
					<div class="col-md-12 col-lg-12">
                        <?php $message = $this->session->flashdata( 'message' ); ?>
                        <?php if( !empty( $message ) ): ?>
                            <?php if( $message['type'] == 'failure' ): ?>
                                <div id="men" class="alert alert-danger" role="alert" >
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
                        <!-- Errores del formulario  -->
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['nit']) echo '<div class="alert alert-danger" role="alert">'.$errores['nit'].'</div>';?>
                                <?php if($errores['razon']) echo '<div class="alert alert-danger" role="alert">'.$errores['razon'].'</div>';?>
                        <?php endif; ?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h2>Clientes Registrados</h2 > 
							</div>
							<div class="panel-body">
								<table class="table table-striped table-bordered" id="example">
									<thead>
										<tr>
											<th>Codigo</th>
											<th>Cliente</th>
											<th>Nit</th>
											<th>Razon Social</th>
											<th>Editar</th>
											<th>Eliminar</th>
										</tr>
									</thead>
									<tbody>
										<?php if( !empty( $data ) ):foreach( $data as $value ): ?>
										<tr>
											<td><?php echo $value['id_cliente'] ?></td>
											<td><?php echo $value['nombre_cliente'] ?></td>
											<td><?php echo $value['nit'] ?></td>
											<td><?php echo $value['razon_social'] ?></td>
											<td class="center"><a href="<?php echo base_url() ?>clientes/editar/<?php echo $value['id_cliente']?>" title="Editar elemento" >
											<img src="<?php echo base_url()?>images/editar.png" width="20" height="20" title="Editar elemento" alt="editar"/></a>
											</td>
											<td class="center"><a href="<?php echo base_url() ?>clientes/eliminar/<?php echo $value['id_cliente']?>" onclick="javascript: if( !confirm( 'Quiere eliminar este elemento ?' ) ) return false;">
											<img src="<?php echo base_url()?>images/eliminar.png" width="20" height="20" title="Eliminar elemento" alt="editar"/> </a>
											</td>
												
										</tr>
										<?php endforeach; endif; ?>          
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="mimodal" class="modal bounceInUp animated" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	                <h2 class="modal-title">Crear Cliente</h2>
	            </div>
	            <div class="modal-body">
	                <form action="<?php echo base_url() ?>clientes/crear" method="post" class="form-horizontal" id="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre Cliente*</label>
                            <div class="col-sm-8">
                                <input type="text" required class="form-control" name="nombre_cliente" id="nombre_cliente" value="<?php echo set_value('nombre_cliente');?>">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nit Cliente*</label>
                            <div class="col-sm-8">
                                <input type="text" required class="form-control" pattern="^[0-9\.\-]+[0-9\.\-]" title="Debe ser un Nit valido" name="nit" id="nit" value="<?php echo set_value('nit');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Razon social*</label>
                            <div class="col-sm-8">
                                <input type="text" required  class="form-control" name="razon_social" id="razon_social" value="<?php echo set_value('razon_social');?>">
                            </div>
                        </div>
	            </div>
	            <div class="modal-footer">
	                <button type="submit" class="btn btn-primary" value="Submit">Guardar</button>        
	                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>