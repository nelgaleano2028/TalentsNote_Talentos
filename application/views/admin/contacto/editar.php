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
            <li class=""><a href="<?php echo base_url()?>contacto/">Contacto</a></li>
            <li class=""><a href="">Editar</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Editar Contacto</h2 >
                    </div>
                      <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['apellido']) echo '<div class="alert alert-danger" role="alert">'.$errores['apellido'].'</div>';?>
                                <?php if($errores['cliente']) echo '<div class="alert alert-danger" role="alert">'.$errores['cliente'];?>
                                <?php if($errores['correo']) echo '<div class="alert alert-danger" role="alert">'.$errores['correo'].'</div>';?>
                                <?php if($errores['tel']) echo '<div class="alert alert-danger" role="alert">'.$errores['tel'].'</div>';?>
                        <?php endif; ?>
                    <div class="panel-body" id="table_incidente">
                        <form action="<?php echo base_url()?>contacto/editar/<?php echo $data[0]['id_contacto'] ?>" class="form-horizontal" method="post" id="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre*</label>
                                <div class="col-sm-8">
                                    <input title="Debe ser Alfanumerico" type="text" class="form-control" pattern="[a-zA-Z9-0\sáéíóúñ]*" name="nombre" required  id="nombre" value="<?php echo set_value('nombre',$data[0]['nombre'])?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Apellido*</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" title="Debe ser alfanumerico" pattern="[a-zA-Z0-9 áéíóúñ\.]+[a-zA-Z0-9 áéíóúñ\.]"
                                    name="apellido" required  id="apellido" value="<?php echo set_value('apellido',$data[0]['apellido'])?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Empresa*</label>
                                <div class="col-sm-8">
                                    <select name="id_cliente" id="id_cliente" required class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $cliente ) ): foreach( $cliente as $value ): if( $value['id_cliente'] = $data[0]['id_cliente'] ) $ch = 'selected="selected"';  else $ch = ''; ?>
                                             <option <?php echo $ch ?>  value="<?php echo $value['id_cliente'] ?>"><?php echo $value['nombre_cliente'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Correo*</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control"
                                    name="correo" required  id="correo" value="<?php echo set_value('correo',$data[0]['correo'])?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Telefono*</label>
                                <div class="col-sm-8">
                                    <input title="Debe ser numerico, entre 7 y 10 digitos" type="text" class="form-control" pattern="[0-9]{7,10}"
                                    name="telefono" required  id="telefono" value="<?php echo set_value('telefono',$data[0]['telefono'])?>">
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
