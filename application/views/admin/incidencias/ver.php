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
                <li class=""><a href="<?php echo base_url()?>incidencias/">Incidencias</a></li>
              </ol> 
              <div class="container-fluid">

                <div class="row">
                  <div class="panel-heading">
                    <h2>Incidencias Registradas</h2 > 
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2>Incidencias Registradas</h2 > 
                        </div>
                        <div class="panel-body">
                          <table class="table table-striped table-bordered" id="example">
                            <thead>
                              <tr>
                                  <th>Codigo</th>
                                  <th>Estado</th>
                                  <th>Cliente</th>
                                  <th>Ingeniero</th>
                                  <th>Prioridad</th>
                                  <th>Área</th>
                                  <th>Asunto</th>
                                  <th>Fecha</th>
                                  <th>Fecha Final</th>
                              </tr>
                            </thead>
                            <tbody>
                          
                              <?php if( !empty( $data ) ): foreach( $data as $value ): ?>
                                  <tr >
                                      <td><?php echo $value['id_incidencia'] ?></td>
                                      <td>
                                        <?php echo $value['nombre_estado'] ?>
                                      </td>
                                      <td><?php echo $value['cliente'] ?></td>
                                      <td><?php echo $value['ingeniero'] ?></td>
                                      <td><?php echo $value['nombre_condicion'] ?> </td>
                                      <td><?php echo $value['area'] ?></td>
                                      <td class="center"><?php echo anchor( '/incidencias/crear/'.$value['id_incidencia'], $value['asunto'], 'target = "_blank"')?></td>
                                      <td><?php echo $value['fecha'] ?></td>
                                      <td><?php echo $value['fecha_final'] ?></td>
                                      
                                  </tr>
                              
                              <?php endforeach; endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th ><input type="text" name="search_engine" value="" class="search_init" /></th>
                                    <th><input type="text" name="search_engine" value="" class="search_init" /></th>
                                    <th><input type="text" name="search_engine" value="" class="search_init" /></th>
                                    <th><input type="text" name="search_engine" value="" class="search_init" /></th>
                                    <th><input type="text" name="search_engine" value="" class="search_init" /></th>
                                    <th><input type="text" name="search_engine" value="" class="search_init" /></th>
                                    <th></th>
                                    <th><input type="text" name="search_engine" value="" class="search_init" /></th>
                                    <th><input type="text" name="search_engine" value="" class="search_init" /></th>
                                </tr>
                            </tfoot>
                          </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>