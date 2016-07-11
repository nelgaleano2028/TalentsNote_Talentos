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
            <li class=""><a href="<?php echo base_url()?>clientes/">Clientes</a></li>
            <li class=""><a href="">Crear</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Crear Cliente</h2 >
                    </div>
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['nit']) echo '<div class="alert alert-danger" role="alert">'.$errores['nit'].'</div>';?>
                                <?php if($errores['razon']) echo '<div class="alert alert-danger" role="alert">'.$errores['razon'].'</div>';?>
                        <?php endif; ?>
                    <div class="panel-body" id="table_incidente">
                        <form action="<?php echo base_url() ?>clientes/crear" method="post" class="form-horizontal" id="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre Cliente*</label>
                                <div class="col-sm-8">
                                    <input type="text" required class="form-control" name="nombre_cliente" id="nombre_cliente" value="<?php echo set_value('nombre_cliente');?>">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nit Cliente*</label>
                                <div class="col-sm-8">
                                    <input type="text" required class="form-control" pattern="^[0-9\.\-]+[0-9\.\-]" title="Debe ser un Nit valido" name="nit" id="nit" value="<?php echo set_value('nit');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Razon social*</label>
                                <div class="col-sm-8">
                                    <input type="text" required  class="form-control" name="razon_social" id="razon_social" value="<?php echo set_value('razon_social');?>">
                                </div>
                            </div>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>                                
                                <input type="button" onclick="window.location='<?php echo base_url()?>clientes/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
                                
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
 