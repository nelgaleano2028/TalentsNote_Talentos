<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>
<div class="static-content-wrapper">
  <div class="static-content">
      <div class="page-content">
        <ol class="breadcrumb">
          <li class=""><a href="<?php echo base_url()?>admin">Inicio</a></li>
          <li class="active"><a href="">Perfil</a></li>
          <li class=""><a href="">Editar</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <?php $attributes=array('id'=>'formperfil','class'=>'form-horizontal','name'=>'formperfil');?> 
                    <?php echo form_open_multipart('ingeniero/perfil_ingeniero/'.$data[0]['id_ingeniero'], $attributes);?>
                    <div class="panel-heading">
                      <h2>Editar Perfil</h2 >
                    </div>
                      <?php 
                       $errores = $this->session->flashdata('errores');
                       $message = $this->session->flashdata('message');?>
                        <?php if( !empty( $message ) ): ?>
                          <?php if( $message['type'] == 'failure' ): ?>
                            <div class="alert alert-danger" role="alert">
                              <?php echo $message['text'] ?></p>
                            </div>
                          <?php endif; ?>    
                          <?php if( $message['type'] == 'success' ): ?>
                            <div class="alert alert-success" role="alert">
                              <?php echo $message['text'] ?></p>
                            </div>
                          <?php endif; ?>
                        <?php endif; ?>
                        <?php  if($errores): ?>
                                <?php if($errores['contra']) echo '<div class="alert alert-danger" role="alert">'.$errores['contra'].'</div>';?>
                                <?php if($errores['cel']) echo '<div class="alert alert-danger" role="alert">'.$errores['cel'].'</div>';?>
                                <?php if($errores['correo']) echo '<div class="alert alert-danger" role="alert">'.$errores['correo'];?>
                                <?php if($errores['original']) echo '<div class="alert alert-danger" role="alert">'.$errores['original'].'</div>';?>
                                <?php if($errores['recontra']) echo '<div class="alert alert-danger" role="alert">'.$errores['recontra'].'</div>';?>
                        <?php endif; ?>

                    <div class="panel-body" id="table_incidente">
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Celular o Fijo*</label>
                            <div class="col-sm-8">
                                <input type="text" required name="celular" id="celular"  class="form-control" value="<?php echo set_value('celular', $data[0]['celular']) ?>"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Correo*</label>
                            <div class="col-sm-8">
                                <input type="email" name="correo" id="correo" required class="form-control" value="<?php echo set_value('correo', $data[0]['correo']) ?>"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Contraseña anterior*</label>
                            <div class="col-sm-8">
                                <input type="password" name="contrasena_original" required class="form-control" id="contrasena_original"  />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Contraseña nueva*</label>
                            <div class="col-sm-8">
                                <input type="password" name="contrasena" id="contrasena"  required class="form-control" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Repetir Contraseña*</label>
                            <div class="col-sm-8">
                                <input type="password" name="re_contrasena" id="re_contrasena" required class="form-control"  />
                            </div>
                          </div>
                          <input type="hidden" name="foto" id="foto" value="">
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>
                                <input type="button" onclick="window.location='<?php echo base_url()?>admin'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
          </div>
        </div>        
      </div>
    </div>
