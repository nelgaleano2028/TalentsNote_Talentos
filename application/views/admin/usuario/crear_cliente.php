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
            <li class=""><a href="<?php echo base_url()?>clientes">Cliente</a></li>
            <li class=""><a href="">Crear</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Crear Usuario Cliente</h2 >
                    </div>
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['clave']) echo '<div class="alert alert-danger" role="alert">'.$errores['clave'].'</div>';?>
            
                        <?php endif; ?>
                    <div class="panel-body">
                        <form action="<?php echo base_url()?>usuario/crear_cliente" method="post" class="form-horizontal" id="form" autocomplete="off">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Usuario*</label>
                                <div class="col-sm-8">
                                    <input type="text" required pattern="[a-zA-Z9-0\sáéíóúñ]*" title="Debe ser alfanumerico" class="form-control" name="Usuario" id="Usuario" value="<?php echo set_value('usuario');?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contraseña*</label>
                                <div class="col-sm-8">
                                    <input type="password" required class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contacto</label>
                                <div class="col-sm-8">
                                    <select name="id_contacto" id="id_contacto" required class="form-control" >
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $contacto ) ): foreach( $contacto as $value ): ?>
                                            <option value="<?php echo $value['id_contacto'] ?>"><?php echo $value['nombre'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="id_perfil" value="3"/>
                            <input type="hidden" name="estado" value="1" id="estado"/>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>                                
                                <input type="button" onclick="window.location='<?php echo base_url()?>usuario/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
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