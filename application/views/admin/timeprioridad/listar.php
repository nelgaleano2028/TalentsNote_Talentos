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
                <li class="active"><a href="">Tiempo</a></li>
            </ol> 
            <div class="container-fluid">
                <div class="row">
                    <div class="panel-heading">
                        <h2 class="panel-head">Tiempo Prioridad Registrados</h2 >
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
                        <!-- Errores del formulario -->
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['cli']) echo '<div class="alert alert-danger" role="alert">'.$errores['cli'].'</div>';?>
                                <?php if($errores['hora']) echo '<div class="alert alert-danger" role="alert">'.$errores['hora'];?>
                        <?php endif; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2>Tiempo Prioridad Registrados</h2 > 
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Prioridad</th>
                                            <th>Cliente</th>
                                            <th>Tiempo(horas)</th>
                                            <th>Editar</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>                           
                                        <?php if( !empty( $data ) ): foreach( $data as $value ): ?>
                                        <tr >
                                            <td><?php echo $value['id_tiempoprioridad']?></td>
                                            <td><?php echo $value['condicion']?></td>
                                            <td><?php echo $value['cliente']?></td>
                                            <td class="center"><?php echo $value['horas']?> Hora</td>
                                            <td class="center"><a href="<?php echo base_url() ?>tiempoprioridad/editar/<?php echo $value['id_tiempoprioridad']?>" title="Editar elemento" >
                                            <img src="<?php echo base_url()?>images/editar.png" width="20" height="20" title="Editar elemento" alt="editar"/></a>
                                            </td>
                                            <td class="center"><a href="<?php echo base_url() ?>tiempoprioridad/eliminar/<?php echo $value['id_tiempoprioridad']?>" onclick="javascript: if( !confirm( 'Quiere eliminar este elemento ?' ) ) return false;">
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
                    <h2 class="modal-title">Crear Tiempo Prioridad</h2>
                </div>
                <div class="modal-body">
                    <form name="form" action="<?php echo base_url() ?>tiempoprioridad/crear" method="post" class="form-horizontal" id="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Prioridad*</label>
                            <div class="col-sm-8">
                                <select name="id_condicion" id="id_condicion" required class="form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $condicion ) ): foreach( $condicion as $value ): ?>
                                        <option value="<?php echo  $value['id_condicion']?>"><?php echo  $value['descripcion']?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cliente*</label>
                            <div class="col-sm-8">
                                <select name="id_cliente" id="id_cliente" required class="form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $cliente ) ): foreach( $cliente as $value ): ?>
                                        <option value="<?php echo  $value['id_cliente']?>"><?php echo  $value['nombre_cliente']?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Definir Tiempo de Prioridad (en horas):* </label>
                            <div class="col-sm-8">
                                <input type="text" required class="form-control" name="horas" id="horas">
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