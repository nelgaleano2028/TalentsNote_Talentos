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
            <li class=""><a href="<?php echo base_url()?>usuario">Usuarios</a></li>
            <li class=""><a href="">Editar</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Editar Usuario</h2 >
                    </div>
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['clave']) echo '<div class="alert alert-danger" role="alert">'.$errores['clave'].'</div>';?>
                                <?php if($errores['perfil']) echo '<div class="alert alert-danger" role="alert">'.$errores['perfil'].'</div>';?>
                        <?php endif; ?>
                    <div class="panel-body" id="table_incidente">
                        <form action="<?php echo base_url()?>usuario/editar/<?php echo $data[0]['id_usuario'] ?>" class="form-horizontal" method="post" id="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Usuario*</label>
                                <div class="col-sm-8">
                                    <input title="Debe ser Alfanumerico" type="text" class="form-control" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]*" name="Usuario" required  id="Usuario" value="<?php echo set_value('nombre',$data[0]['Usuario'])?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contraseña*</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" pattern="[a-zA-Z9-0\sáéíóúñ]*"
                                    name="password" required  id="password" value="<?php echo set_value('password',$data[0]['contraseña'])?>">
                                </div>
                            </div>
                    <?php 
                        if($data[0]['id_perfil']==3){
                    ?>
                           <div class="form-group">
                                <label class="col-sm-2 control-label">Nombre Contacto*</label>
                                <div class="col-sm-8">
                                    <select name="id_contacto" id="id_contacto" class="form-control" >
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $contacto ) ): foreach( $contacto as $value ): ?>
                                            <option <?php if( $data[0]['id_contacto'] == $value['id_contacto'] ) echo 'selected="selected"' ?> value="<?php echo $value['id_contacto'] ?>"><?php echo $value['nombre'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                        <?php
                        }else{
                        ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ingeniero*</label>
                                <div class="col-sm-8">
                                    <select name="id_ingeniero" id="id_ingeniero" class="form-control" >
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $ingenieros ) ): foreach( $ingenieros as $value ): ?>
                                            <option <?php if( $data[0]['id_ingeniero'] == $value['id_ingeniero'] ) echo 'selected="selected"' ?> value="<?php echo $value['id_ingeniero'] ?>"><?php echo $value['nombre'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                        <?php
                        }
                        ?>    
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tipo Perfil*</label>
                                <div class="col-sm-8">
                                    <select name="id_perfil" id="id_perfil" class="form-control" required>
                                        <option value="">Seleccione...</option>
                                        <?php if( !empty( $perfiles ) ): foreach( $perfiles as $value ): ?>
                                            <option <?php if( $data[0]['id_perfil'] == $value['id_perfil'] ) echo 'selected="selected"' ?> value="<?php echo $value['id_perfil'] ?>"><?php echo $value['nombre_perfil'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Estado*</label>
                                <div class="col-sm-8">
                                    <select name="estado" id="estado" class="form-control" required="required" >
                                        <option value="">Seleccione...</option>
                                        <option value="1" <?php if( $data[0]['estado'] == 1 ) echo 'selected="selected"' ?>>Activo</option>
                                        <option value="0" <?php if( $data[0]['estado'] ==0 ) echo 'selected="selected"' ?>>Inactivo</option>
                                    </select>
                                </div>
                            </div>          
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
