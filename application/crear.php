<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
        $this->output->set_header( "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0" ); 
        $this->output->set_header( "Pragma: no-cache" ); 
?>

<div class="static-content-wrapper">
  <div class="static-content">
      <div class="page-content">
        <ol class="breadcrumb">
            <?php $id_incidencia1 = $this->session->CI->view['incidencia'];?>
            <li class=""><a href="<?php echo base_url()?>admin">Home</a></li>
            <li class=""><a href="<?php echo base_url()?>incidencias">Incidentecias</a></li>
            <li class=""><a href="<?php echo base_url()?>incidencias/crear/<?php echo $id_incidencia1[0]['id_incidencia'];?>">Editar</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
                <div class="col-xs-12">
                    <form method="post" action="<?php echo base_url() ?>incidencias/crear/<?php echo $incidencia[0]['id_incidencia'] ?>" name="formincidente" id="formincidente" class="form-horizontal">
                    <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                        style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                        <div class="panel-heading">
                          <h2>Editar Incidente</h2 >
                        </div>
                          <?php
                                $id_incidencia1 = $this->session->CI->view['incidencia'];
                                $id_incidenciaR = $id_incidencia1[0]['id_incidencia'];
                                $errores = $this->session->flashdata('errores');?>
                            <?php $errores = $this->session->flashdata('errores');?>
                            <?php  if($errores): ?>
                                    <?php if($errores['estado']) echo '<div class="alert alert-danger" role="alert">'.$errores['estado'].'</div>';?>
                                    <?php if($errores['condicion']) echo '<div class="alert alert-danger" role="alert">'.$errores['condicion'];?>
                                    <?php if($errores['area']) echo '<div class="alert alert-danger" role="alert">'.$errores['area'].'</div>';?>
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
                                $fecha=substr($incidencia[0]['fecha'],0,-9);
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
                                    <p class="form-control-static"><?php echo $incidencia[0]['prioridad'] ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Causa:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['causa'] ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ingeniero:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['nombre_ingeniero'] ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ingeniero Usuario:</label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?php echo $incidencia[0]['usuario'] ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Detalle:</label>
                                <div class="col-sm-9">
                                   <p class="form-control-static text-justify"> <?php echo strip_tags($incidencia[0]['detalle']);?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-midnightblue">
                        <div class="panel-heading">
                          <h2>NOTAS</h2 >
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="notas" style="height: 400px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-midnightblue">
                        <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Estado*</label>
                            <div class="col-sm-8">
                                <select name="id_estado" id="id_estado"class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $estado ) ): foreach( $estado as $value ): ?>
                                        <option value="<?php echo $value['id_estado'] ?>"<?php if($value['nombre_estado'] ==$incidencia[0]['estado'] ) echo "selected='selected'"?>><?php echo $value['nombre_estado'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Prioridad*</label>
                            <div class="col-sm-8">
                                <select name="id_condicion" id="id_condicion" class="form-control" required>  
                                    <option value="">Seleccione...</option>     
                                    <option value="1" <?php if( $incidencia[0]['id_prioridad'] == 1 ) echo 'selected="selected"' ?>>Alta</option>
                                    <option value="2" <?php if( $incidencia[0]['id_prioridad'] == 2 ) echo 'selected="selected"' ?>>Media</option>
                                    <option value="3" <?php if( $incidencia[0]['id_prioridad'] == 3 ) echo 'selected="selected"' ?>>Baja</option>
                                    <option value="4" <?php if( $incidencia[0]['id_prioridad'] == 4 ) echo 'selected="selected"' ?>>Muy Alta</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Área</label>
                            <div class="col-sm-8">
                               <select name="id_area" id="id_area" class="form-control">
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $areas ) ): foreach( $areas as $value ): ?>
                                        <option value="<?php echo $value['id_area'] ?>"<?php if($value['id_area'] ==$incidencia[0]['id_area'] ) echo "selected='selected'"?>><?php echo $value['nombre_area'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ingeniero</label>
                            <div class="col-sm-8">
                                <select name="id_ingeniero" id="id_ingeniero" class="form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $ingeniero_area ) ): foreach( $ingeniero_area as $value ): ?>
                                        <option value="<?php echo $value['id_ingeniero'] ?>"<?php if($value['id_ingeniero']==$incidencia[0]['ingeniero'] ) echo "selected='selected'"?>><?php echo $value['nombre'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
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
                                        <input type="submit" class="form-insert btn btn-primary" value="Guardar"/>
                                        <input type="button" onclick="window.location='<?php echo base_url()?>incidencias/'" name="boton" class="form-insert btn-inverse btn" value="Cancelar" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="id_incidencia" value="<?php echo $id_incidenciaR ?>">
                        </div> 
                    </div>
                    </form>
                </div>
            </div>
        </div>        
    </div>
</div>
