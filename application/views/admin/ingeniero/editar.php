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
            <li class=""><a href="<?php echo base_url()?>ingeniero/">Ingeniero</a></li>
            <li class=""><a href="">Editar</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Editar Ingeniero</h2 >
                    </div>
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
                    <div class="panel-body" id="table_incidente">
                        <form action="<?php echo base_url() ?>ingeniero/editar/<?php echo $id ?>" method="post" class="form-horizontal" id="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre Completo*</label>
                                <div class="col-sm-8">
                                    <input type="text" required pattern="[a-zA-Z9-0\sáéíóúñ]*" title="Debe ser alfanumerico" class="form-control" name="nombre" id="nombre" value="<?php echo set_value('nombre', $data[0]['nombre']); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cedula*</label>
                                <div class="col-sm-8">
                                    <input type="text" required pattern="[9-0]{5,12}" title="Debe ser una Cedula, Sin signos" class="form-control" name="cedula" id="cedula" value="<?php echo set_value('cedula', $data[0]['cedula']);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Celular*</label>
                                <div class="col-sm-8">
                                    <input type="text" required pattern="[9-0]{7,10}" title="Debe ser un Telefono, Sin signos" class="form-control" name="celular" id="celular" value="<?php echo set_value('celular',$data[0]['celular']);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Correo*</label>
                                <div class="col-sm-8">
                                    <input type="email" required class="form-control" name="correo" id="correo" value="<?php echo set_value('correo',$data[0]['correo']);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Estado Laboral*</label>
                                <div class="col-sm-8">
                                   <select name="estado_laboral" id="estado_laboral" class="form-control" required>
                                        <option value="">Seleccione...</option>
                                        <option value="1" <?php if( $data[0]['estado_laboral'] == 1 ) echo 'selected="selected"' ?>>Activo</option>
                                        <option value="0" <?php if( $data[0]['estado_laboral'] ==0 ) echo 'selected="selected"' ?>>Inactivo</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">EPS*</label>
                                <div class="col-sm-8">
                                    <select name="id_eps" id="id_eps" class="form-control" required>
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $eps ) ): foreach( $eps as $value ): ?>
                                            <option <?php if( $data[0]['id_eps'] == $value['id_eps'] ) echo 'selected="selected"' ?> value="<?php echo $value['id_eps'] ?>"><?php echo $value['nombre_eps'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Pensión*</label>
                                <div class="col-sm-8">
                                    <select name="id_pensiones" id="id_pensiones" class="form-control" required>
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $pension ) ): foreach( $pension as $value ): ?>
                                            <option <?php if( $data[0]['id_pensiones'] == $value['id_pensiones'] ) echo 'selected="selected"' ?> value="<?php echo $value['id_pensiones'] ?>"><?php echo $value['nombre_pensiones'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-sm-2 control-label">Cesantias*</label>
                                <div class="col-sm-8">
                                    <select name="id_cesantias" id="id_cesantias" class="form-control" required >
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $cesantia ) ): foreach( $cesantia as $value ): ?>
                                            <option <?php if( $data[0]['id_cesantias'] == $value['id_cesantias'] ) echo 'selected="selected"' ?> value="<?php echo $value['id_cesantias'] ?>"><?php echo $value['nombre_cesantias'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cargo*</label>
                                <div class="col-sm-8">
                                    <select name="id_cargo" id="id_cargo" class="form-control" required >
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $cargo ) ): foreach( $cargo as $value ): ?>
                                            <option <?php if( $data[0]['id_cargo'] == $value['id_cargo'] ) echo 'selected="selected"' ?> value="<?php echo $value['id_cargo'] ?>"><?php echo $value['nombre_cargo'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Área*</label>
                                <div class="col-sm-8">
                                    <select name="id_area" id="id_area" class="form-control" required >
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $area ) ): foreach( $area as $value ): ?>
                                            <option <?php if( $data[0]['id_area'] == $value['id_area'] ) echo 'selected="selected"' ?> value="<?php echo $value['id_area'] ?>"><?php echo $value['nombre_area'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>                                
                                <input type="button" onclick="window.location='<?php echo base_url()?>ingeniero/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
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
 