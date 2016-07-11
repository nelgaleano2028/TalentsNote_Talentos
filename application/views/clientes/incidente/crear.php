
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
          <li class=""><a href="">Incidente</a></li>
          <li class="active"><a href="">Editar</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
                <div class="col-xs-12">
                    <form action="<?php echo base_url() ?>clientes/incidente_crear/<?php echo $id_incidencia ?>" method="post" id="formincidente" class="form-horizontal">
                    <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                        style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                        <div class="panel-heading">
                          <h2>Editar Incidente</h2 >
                        </div>
                          <?php $errores = $this->session->flashdata('errores');?>
                          <?php  if($errores): ?>
                                    <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                          <?php endif; ?>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Codigo:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['id_incidencia'] ?></p>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-sm-2 control-label">Estado:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['estado'] ?></p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Asunto:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['asunto'] ?></p>
                                </div>
                            </div> 
                            <?php
                                $fecha=substr($incidencia[0]['fecha'], 0, -9);
                                $fecha = explode( '-', $fecha );
                                $fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
                            ?>                          
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Fecha:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $fecha ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cliente:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['cliente'] ?></p>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-sm-2 control-label">Subcategoría:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['subcategoria'] ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Prioridad:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['condicion'] ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Causa:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['nombre_causa'] ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Detalle:</label>
                                <div class="col-sm-9">
                                   <p class="form-control-static text-justify"><?php echo strip_tags($incidencia[0]['detalle']);?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <a href="#"  
                                       data-toggle="modal" class="ver_imagen" data-target="#mimodal">Ver Adjuntos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-midnightblue">
                        <div class="panel-heading">
                          <h2>NOTAS*</h2 >
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12" id="id_estado<?php echo $incidencia[0]['id_estado']?>">
                                <textarea name="notas" id="notas"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-midnightblue">
                        <div class="panel-body" >
                        <table class="table table-striped table-bordered" id="example" width="100%">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th >Nota</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                   <?php  if( !empty( $notas ) ): foreach( $notas as $value ): ?>
                                   <?php $fecha = explode( ' ', $value['fecha'] ); ?>
                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                   <?php $fecha = explode( '-', $fecha[0] ); ?>
                                <tr>
                                    <td ><?php echo $fecha[2].'/'.$fecha[1].'/'.$fecha[0] ?></td>
                                    <td ><pre style="background-color:transparent; border:1px #ccc"><?php echo $value['notas'] ?></pre></td>
                                    <td><?php echo $value['usuario'] ?></td>
                                </tr>
                                <?php endforeach; endif; ?>
                           </tbody>
                        </table>
                        </div>
                        <div class="form-boton panel-footer">
                            <div class="row">
                                <div class="col-sm-8" style="margin-left:20px;">
                                    <input type="submit" class="form-insert btn btn-primary" id="click_seguro" value="Guardar"/>
                                    <input type="button" onclick="window.location='<?php echo base_url()?>clientes/ver_incidente/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
                                    <input type="hidden" name="id_imagen" id="id_imagen" value="<?php echo $incidencia[0]['id_incidencia'] ?>" />
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
<div class="modal fade in" id="mimodal" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Archivos Adjuntos</h4>
          </div>
          <div class="modal-body">
            <div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
          </div>
        </div>

    </div>
</div>