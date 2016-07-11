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
            <li class=""><a href="<?php echo base_url()?>subcategoria">Subcategorías</a></li>
            <li class=""><a href="">Editar</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Editar Categoría</h2 >
                    </div>
                      <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['categoria']) echo '<div class="alert alert-danger" role="alert">'.$errores['categoria'].'</div>';?>
                        <?php endif; ?>
                    <div class="panel-body" id="table_incidente">
                        <form action="<?php echo base_url() ?>subcategoria/editar/<?php echo $data[0]['id'] ?>" class="form-horizontal" method="post" id="form" name="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Subcategoría*</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" pattern="[a-zA-Z9-0\sáéíóúñ]*" title="Debe ser alfanumerico"
                                    name="opcion" required="required"  id="opcion" value="<?php echo set_value('opcion',$data[0]['opcion'])?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Categoría*</label>
                                <div class="col-sm-8">
                                    <select name="relacion" id="relacion" class="form-control" required >
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $categorias ) ): foreach( $categorias as $value ): ?>
                                            <option <?php if( $data[0]['relacion'] == $value['id'] ) echo 'selected="selected"' ?> value="<?php echo $value['id'] ?>"><?php echo $value['opcion'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>
                                <input type="button" onclick="window.location='<?php echo base_url()?>subcategoria/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
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
