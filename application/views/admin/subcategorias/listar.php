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
                <li class="active"><a href="">Subcategorias</a></li>
            </ol> 
            <div class="container-fluid">
                <div class="row">
                    <div class="panel-heading">
                        <h2 class="panel-head">Subcategorias Registradas</h2 >
                        <a href="#" data-toggle="modal" class="btn btn-primary btn-crear" data-target="#mimodal">Crear <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <?php $message = $this->session->flashdata( 'message' ); ?>
                          <?php if( !empty( $message ) ): ?>
                              <?php if( $message['type'] == 'failure' ): ?>
                                  <div id="men" class="alert alert-danger" role="alert" >
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
                        <!-- Errores del formulario -->
                        <?php $errores = $this->session->flashdata('errores');?>
                        <?php  if($errores): ?>
                                <?php if($errores['nombre']) echo '<div class="alert alert-danger" role="alert">'.$errores['nombre'].'</div>';?>
                                <?php if($errores['categoria']) echo '<div class="alert alert-danger" role="alert">'.$errores['categoria'].'</div>';?>
                        <?php endif; ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2>Subcategorias Registradas</h2 > 
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Categoria</th>
                                            <th>Subcategoria</th>
                                            <th>Editar</th>
                                            <th>Eliminar</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if( !empty( $data ) ):  foreach( $data as $value ): ?>
                                        <tr >
                                            <td><?php echo $value['id'] ?></td>
                                            <td><?php echo $value['categoria'] ?></td>
                                            <td><?php echo $value['opcion'] ?></td>
                                            <td class="center"><a href="<?php echo base_url() ?>subcategoria/editar/<?php echo $value['id']?>" title="Editar elemento" >
                                            <img src="<?php echo base_url()?>images/editar.png" width="20" height="20" title="Editar elemento" alt="editar"/></a>
                                            </td>
                                            <td class="center"><a href="<?php echo base_url() ?>subcategoria/eliminar/<?php echo $value['id']?>" onclick="javascript: if( !confirm( 'Quiere eliminar este elemento ?' ) ) return false;">
                                            <img src="<?php echo base_url()?>images/eliminar.png" width="20" height="20" title="Eliminar elemento" alt="editar"/> </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif; ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="mimodal" class="modal bounceInUp animated" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Crear Subcategoría</h2>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url()?>subcategoria/crear" class="form-horizontal" method="post" id="formu">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Subcategoria*</label>
                            <div class="col-sm-8">
                                <input type="text" required pattern="[a-zA-Z9-0\sáéíóúñ]*" title="Debe ser alfanumerico" class="form-control" name="opcion" id="opcion" value="<?php echo set_value('opcion');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Categoría*</label>
                            <div class="col-sm-8">
                                <select name="relacion" id="relacion" required class="form-control" >
                                    <option value="">Seleccione...</option>
                                    <?php if( !empty( $categorias ) ): foreach( $categorias as $value ): ?>
                                        <option value="<?php echo $value['id'] ?>"><?php echo $value['opcion'] ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" value="Submit">Guardar</button>        
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>