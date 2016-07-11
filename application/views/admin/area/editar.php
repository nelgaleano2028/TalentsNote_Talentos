<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<div class="static-content-wrapper">
  <div class="static-content">
      <div class="page-content">
        <ol class="breadcrumb">
          <li class="active"><a href="<?php echo base_url()?>area/'">Área</a></li>
          <li class="active"><a href="">Editar</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget={"draggable:false"} data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Editar Área</h2 >
                    </div>
                      <?php $errores = $this->session->flashdata('errores');?>
                      <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                      <?php endif; ?>                  
      
                    <div class="panel-body" id="table_incidente">
                        <form action="<?php echo base_url()?>area/editar/<?php echo $data[0]['id_area'] ?>" class="form-horizontal" method="post" id="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Área*</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control"
                                    name="nombre_area" required id="nombre_area" value="<?php echo set_value('nombre_area',$data[0]['nombre_area'])?>">
                                </div>
                            </div>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>
                                <input type="button" onclick="window.location='<?php echo base_url()?>area'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
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
