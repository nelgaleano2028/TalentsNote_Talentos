<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<div class="static-content-wrapper">
  <div class="static-content">
      <div class="page-content">
        <ol class="breadcrumb">
          <li class=""><a href="<?php echo base_url()?>/admin">Home</a></li>
          <li class="active"><a href="">Cambiar Contraseña</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Cambiar Contraseña Administrador</h2 >
                    </div>
                    <?php $message = $this->session->flashdata( 'message' ); ?>
                        <?php if( !empty( $message ) ): ?>
                            <?php if( $message['type'] == 'failure' ): ?>
                                <div id="men"  class="alert alert-danger" role="alert" >
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    <?php echo $message['text'] ?>
                                </div>
                            <?php endif; ?>
                            <?php if( $message['type'] == 'success' ): ?>
                                <div id="men" class="alert alert-success" role="alert" >
                                <?php echo "✔ ".$message['text'] ?>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <div class="panel-body">
                        <form action="<?php echo base_url() ?>usuario/cambiar_contadmin/" method="post" class="form-horizontal" id="formperfil" autocomplete="off">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contraseña Anterior</label>
                                <div class="col-sm-8">
                                  <input type="password" required class="form-control" name="contrasena_original" id="contrasena_original">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Contraseña Nueva</label>
                                <div class="col-sm-8">
                                    <input type="password" required class="form-control" name="contrasena" id="contrasena">
                                </div>
                            </div><div class="form-group">
                                <label class="col-sm-2 control-label">Confirmar Contraseña</label>
                                <div class="col-sm-8">
                                    <input type="password" required class="form-control" name="re_contrasena" id="re_contrasena">
                                </div>
                            </div>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="submit" class="form-insert btn btn-primary"  value="Guardar"/>                                
                                <input type="button" onclick="window.location='<?php echo base_url()?>admin/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
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