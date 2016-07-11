<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">
                <li class=""><a href="<?php echo base_url()?>/admin">Home</a></li>
                <li class="active"><a href="">Ingenieros</a></li>
            </ol> 
            <div class="container-fluid">
                <div class="row">
                    <div class="panel-heading">
                        <h2 class="panel-head">Ingenieros Registrados</h2 >
                        <a href="#" data-toggle="modal" class="btn btn-primary btn-crear" data-target="#mimodal">Crear <i class="fa fa-plus"></i></a>
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
                        <!-- vALIDACIONES DE CREAR INGENIERO -->
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['cedula']) echo '<div class="alert alert-danger" role="alert">'.$errores['cedula'].'</div>';?>
                                <?php if($errores['celular']) echo '<div class="alert alert-danger" role="alert">'.$errores['celular'].'</div>';?>
                                <?php if($errores['correo']) echo '<div class="alert alert-danger" role="alert">'.$errores['correo'].'</div>';?>
                                <?php if($errores['estado']) echo '<div class="alert alert-danger" role="alert">'.$errores['estado'].'</div>';?>
                                <?php if($errores['eps']) echo '<div class="alert alert-danger" role="alert">'.$errores['eps'].'</div>';?>
                                <?php if($errores['pension']) echo '<div class="alert alert-danger" role="alert">'.$errores['pension'].'</div>';?>
                                <?php if($errores['cesantia']) echo '<div class="alert alert-danger" role="alert">'.$errores['cesantia'].'</div>';?>
                                <?php if($errores['cargo']) echo '<div class="alert alert-danger" role="alert">'.$errores['cargo'].'</div>';?>
                                <?php if($errores['area']) echo '<div class="alert alert-danger" role="alert">'.$errores['area'].'</div>';?>
                        <?php endif; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2>Ingenieros Registrados</h2 > 
                            </div>
                            <div class="panel-body">
                              <table class="table table-striped table-bordered" id="example">
                                <thead>
                                  <tr>
                                      <th>Codigo</th>
                                      <th>Nombre</th>
                                      <th>Cedula</th>
                                      <th>Celular</th>
                                      <th>Correo</th>
                                      <th>Estado</th>
                                      <th>Editar</th>
                                      <th>Eliminar</th> 
                                  </tr>
                                </thead>
                                <tbody>
                                    
                                   <?php if( !empty( $data ) ):  foreach( $data as $value  ):?>
                                    
                                    <tr >
                                        <td><?php echo $value['id_ingeniero'] ?></td>
                                        <td><?php echo $value['nombre'] ?></td>
                                        <td><?php echo $value['cedula'] ?></td>
                                        <td><?php echo $value['celular'] ?></td>
                                        <td><?php echo $value['correo'] ?></td>
                                        <td><?php 
                                              if( $value['estado_laboral'] == 1 ) echo 'Activo'; 
                                              if( $value['estado_laboral'] != 1 ) echo 'Inactivo';  
                                            ?>
                                        </td>                     
                                        <td class="center"><a href="<?php echo base_url() ?>ingeniero/editar/<?php echo $value['id_ingeniero']?>" title="Editar elemento" >
                                        <img src="<?php echo base_url()?>images/editar.png" width="20" height="20" title="Editar elemento" alt="editar"/></a>
                                        </td>
                                        <td class="center"><a href="<?php echo base_url() ?>ingeniero/eliminar/<?php echo $value['id_ingeniero']?>" onclick="javascript: if( !confirm( 'Quiere eliminar este elemento ?' ) ) return false;">
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
                    <h2 class="modal-title">Crear Ingeniero</h2>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url() ?>ingeniero/crear" method="post" class="form-horizontal" id="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre Completo*</label>
                            <div class="col-sm-8">
                                <input type="text" title="Debe ser Alfanumerico" required pattern="[a-zA-Z9-0\sáéíóúñ]*" class="form-control" name="nombre" id="nombre" value="<?php echo set_value('nombre');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cedula*</label>
                            <div class="col-sm-8">
                                <input type="text" title="Debe ser una Cedula, Sin signos" required class="form-control" pattern="[0-9.]{8,18}" name="cedula" id="cedula" value="<?php echo set_value('cedula');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Celular*</label>
                            <div class="col-sm-8">
                                <input type="text" required title="Debe ser un Telefono, Sin signos" pattern="[0-9]{7,10}" class="form-control" name="celular" id="celular" value="<?php echo set_value('celular');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Correo*</label>
                            <div class="col-sm-8">
                                <input type="email" required class="form-control" name="correo" id="correo" value="<?php echo set_value('correo');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Estado Laboral*</label>
                            <div class="col-sm-8">
                               <select name="estado_laboral" id="estado_laboral" required class="form-control" >
                                    <option value="">Seleccione...</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">EPS</label>
                            <div class="col-sm-8">
                                <select name="id_eps" id="id_eps" class="required form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $eps ) ): foreach( $eps as $value ): ?>
                                        <option value="<?php echo $value['id_eps'] ?>"><?php echo $value['nombre_eps'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pensión*</label>
                            <div class="col-sm-8">
                                <select name="id_pensiones" id="id_pensiones" required class="form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $pension ) ): foreach( $pension as $value ): ?>
                                        <option value="<?php echo $value['id_pensiones'] ?>"><?php echo $value['nombre_pensiones'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Cesantias*</label>
                            <div class="col-sm-8">
                                <select name="id_cesantias" id="id_cesantias" required class="form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $cesantia ) ): foreach( $cesantia as $value ): ?>
                                        <option value="<?php echo $value['id_cesantias'] ?>"><?php echo $value['nombre_cesantias'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cargo*</label>
                            <div class="col-sm-8">
                                <select name="id_cargo" id="id_cargo" class="required form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $cargo ) ): foreach( $cargo as $value ): ?>
                                        <option value="<?php echo $value['id_cargo'] ?>"><?php echo $value['nombre_cargo'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Área*</label>
                            <div class="col-sm-8">
                                <select name="id_area" id="id_area" required class="form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $area ) ): foreach( $area as $value ): ?>
                                        <option value="<?php echo $value['id_area'] ?>"><?php echo $value['nombre_area'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
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