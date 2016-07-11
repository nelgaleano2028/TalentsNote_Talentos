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
            <li class=""><a href="<?php echo base_url()?>contacto">Contacto</a></li>
            <li class=""><a href="<?php echo base_url()?>contacto/crear">Crear</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Crear Contacto</h2 >
                    </div>
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['apellido']) echo '<div class="alert alert-danger" role="alert">'.$errores['apellido'].'</div>';?>
                                <?php if($errores['cliente']) echo '<div class="alert alert-danger" role="alert">'.$errores['cliente'];?>
                                <?php if($errores['correo']) echo '<div class="alert alert-danger" role="alert">'.$errores['correo'].'</div>';?>
                                <?php if($errores['tel']) echo '<div class="alert alert-danger" role="alert">'.$errores['tel'].'</div>';?>
                        <?php endif; ?>
    
                    <div class="panel-body">
                        <form action="<?php echo base_url() ?>contacto/crear" method="post" id="cesantias" class="form-horizontal" id="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre*</label>
                                <div class="col-sm-8">
                                    <input type="text" required title="Debe ser alfanumerico" pattern="[a-zA-Z0-9 áéíóúñ\.]+[a-zA-Z0-9 áéíóúñ\.]" class="form-control" name="nombre" id="nombre" value="<?php echo set_value('nombre');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Apellido*</label>
                                <div class="col-sm-8">
                                    <input type="text" required title="Debe ser alfanumerico" pattern="[a-zA-Z0-9 áéíóúñ\.]+[a-zA-Z0-9 áéíóúñ\.]" class="form-control" name="apellido" id="apellido" value="<?php echo set_value('apellido');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Empresa*</label>
                                <div class="col-sm-8">
                                    <select name="id_cliente" id="id_cliente" required class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $cliente ) ): foreach( $cliente as $value ): ?>
                                         <option value="<?php echo $value['id_cliente'] ?>"><?php echo $value['nombre_cliente'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Correo*</label>
                                <div class="col-sm-8">
                                    <input type="email" required class="form-control" name="correo" id="correo" value="<?php echo set_value('correo');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Telefono*</label>
                                <div class="col-sm-8">
                                    <input type="text" required title="Debe ser numerico, entre 7 y 10 digitos" pattern="[0-9]{7,10}" class="form-control" name="telefono" id="telefono" value="<?php echo set_value('telefono');?>">
                                </div>
                            </div>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>                                
                                <input type="button" onclick="window.location='<?php echo base_url()?>contacto/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
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