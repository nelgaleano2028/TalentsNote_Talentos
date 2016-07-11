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
            <li class=""><a href="">Incidentes</a></li>
            <li class=""><a href="">Crear</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
                <div class="col-xs-12">
                    <form enctype="multipart/form-data" action="<?php echo base_url() ?>ingeniero/crear_incidentes" id="formincidente" method="POST" class="form-horizontal">
                    <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                        style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                        <div class="panel-heading">
                          <h2>Crear Incidente</h2 >
                        </div>
                            <?php $errores = $this->session->flashdata('errores');?>
                            <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['sub']) echo '<div class="alert alert-danger" role="alert">'.$errores['sub'].'</div>';?>
                                <?php if($errores['condicion']) echo '<div class="alert alert-danger" role="alert">'.$errores['condicion'].'</div>';?>
                                <?php if($errores['area']) echo '<div class="alert alert-danger" role="alert">'.$errores['area'].'</div>';?>
                                <?php if($errores['asunto']) echo '<div class="alert alert-danger" role="alert">'.$errores['asunto'].'</div>';?>
                                <?php if($errores['detalle']) echo '<div class="alert alert-danger" role="alert">'.$errores['detalle'].'</div>';?>
                                <?php if($errores['cliente']) echo '<div class="alert alert-danger" role="alert">'.$errores['cliente'].'</div>';?>
                            <?php endif; ?>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Categoria*</label>
                                <div class="col-sm-8">
                                    <select name="categorias" id="categorias" required class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $categorias ) ): foreach( $categorias as $value ): ?>
                                            <option value="<?php echo $value['id']?>"><?php echo $value['opcion']?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Subcategoria*</label>
                                <div class="col-sm-8">
                                    <select name="id_subcategoria" id="id_subcategoria" required class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Prioridad*</label>
                                <div class="col-sm-8">
                                    <select name="id_condicion" id="id_condicion" required class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $condicion ) ): foreach( $condicion as $value ): ?>
                                        <option value="<?php echo $value['id_condicion']?>"><?php echo $value['descripcion']?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-sm-2 control-label">Causa*</label>
                                <div class="col-sm-8">
                                    <select name="causa" id="causa" required class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $causas ) ): foreach( $causas as $value ): ?>
                                        <option value="<?php echo $value['id_causa']?>"><?php echo $value['nombre_causa']?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-md-2 control-label">Archivo</label>
                                <div class="col-sm-5 col-md-6" style="padding-right: 0;">
                                    <input type="file" class="form-control" name="imagen2" style="display: none" id="imagen2"> 
                                    <!-- Fake field to fool the user -->
                                    <input type="hidden"  name="imagen"  id="imagen" readonly>                      
                                    <input type="text" class="form-control" name="valor" readonly id="valor">
                                    <input type="hidden"  name="valor" readonly id="valor">
                                    <!-- Button to invoke the click of the File Input -->
                                </div>
                                <div class="col-sm-3 col-md-2">
                                    <input type="button" class="btn btn-primary text" style="height:34px; width: 100%" id="boton-imagen" value="Subir Archivo" >
                                    <input type="hidden" id="cargap">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Área*</label>
                                <div class="col-sm-8">
                                    <select name="id_area" id="id_area" required class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $areas ) ): foreach( $areas as $value ): ?>
                                        <option value="<?php echo $value['id_area']?>"><?php echo $value['nombre_area']?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ingeniero*</label>
                                <div class="col-sm-8">
                                    <select name="id_ingeniero" id="id_ingeniero" required class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cliente*</label>
                                <div class="col-sm-8">
                                    <select name="id_cliente" id="id_cliente" required class="form-control" >
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $clientes ) ): foreach( $clientes as $value ): ?>
                                            <option value="<?php echo  $value['id_cliente']?>"><?php echo  $value['nombre_cliente']?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Asunto*</label>
                                <div class="col-sm-8">
                                    <input type="text" name="asunto" id="asunto" required class="asunto form-control" value="<?php echo set_value( 'asunto' )?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fecha*</label>
                                <div class="col-sm-8">
                                    <input type="text" name="fecha" id="fecha" required class="form-control" value="" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-midnightblue">
                        <div class="panel-heading">
                          <h2>Detalles del incidente</h2 >
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <textarea name="detalle" id="detalle"></textarea>
                            </div>
                        </div>
                        <div class="form-boton panel-footer">
                            <div class="row">
                                <div class="col-sm-8" style="margin-left:20px;">
                                    <input type="submit" class="form-insert btn btn-primary" id="click_seguro" value="Guardar"/>
                                    <input type="button" onclick="window.location='<?php echo base_url()?>admin'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>        
    </div>
</div>
