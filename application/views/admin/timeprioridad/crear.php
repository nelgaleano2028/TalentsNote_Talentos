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
            <li class=""><a href="<?php echo base_url()?>tiempoprioridad">Tiempo Prioridad</a></li>
            <li class=""><a href="<?php echo base_url()?>tiempoprioridad/crear">Crear</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Crear Tiempo Prioridad</h2 >
                    </div>
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['cli']) echo '<div class="alert alert-danger" role="alert">'.$errores['cli'].'</div>';?>
                                <?php if($errores['hora']) echo '<div class="alert alert-danger" role="alert">'.$errores['hora'];?>
                                
                        <?php endif; ?>
                    <div class="panel-body" id="table_incidente">
                        <form name="form" action="<?php echo base_url() ?>tiempoprioridad/crear" method="post" class="form-horizontal" id="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Prioridad*</label>
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
                                <label class="col-sm-2 control-label">Cliente*</label>
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
                                <label class="col-sm-2 control-label">Definir Tiempo de Prioridad (en horas):* </label>
                                <div class="col-sm-8">
                                    <input type="text" required class="form-control" name="horas" id="horas">
                                </div>
                            </div>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>                                
                                <input type="button" onclick="window.location='<?php echo base_url()?>tiempoprioridad/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>        
      </div>
    </div>
