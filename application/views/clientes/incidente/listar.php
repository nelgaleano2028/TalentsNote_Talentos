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
                <li class=""><a href="">Incidencias</a></li>
              </ol> 
              <div class="container-fluid">

                <div class="row">
                  <div class="panel-heading">
                    <h2>Incidencias registradas</h2 > 
                  </div>
                  <div class="col-md-12 col-lg-12">
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2>Incidencias registradas</h2 > 
                        </div>
                        <div class="panel-body">
                          <table class="table table-striped table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Estado</th>
                                    <th>Asunto</th>
                                    <th>Fecha</th>
                                    <th>Prioridad</th>
                                    <th>Ingeniero</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if( !empty( $data ) ): ?>
                              <div id="vigilante" style="display: none;" ><?php echo $data[0]['id_cliente'];?></div>
                              <?php foreach( $data as $value ): ?>
                              <tr>
                                  <td><?php echo $value['id_incidencia']?></td>
                                  <td><?php echo $value['estado']?></td>
                                  <td><?php echo anchor( '/clientes/incidente_crear/'.$value['id_incidencia'], $value['asunto'] )?></td>
                                  <td><?php echo $value['fecha']?></td>
                                  <td class="center"><?php
                                  switch( $value['id_condicion'] ):
                                  
                                    case 1:
                                      echo '<span class="label" style="background-color: #FF7600;">Alta</span>';
                                    break;
                                    case 2:
                                      echo '<span class="label label-warning" >Media</span>';
                                    break;
                                    case 3:
                                      echo '<span class="label" style="background-color:#2A37D0">Baja</span>';
                                    break;
                                    case 4:
                                      echo '<span class="label label-danger">Muy Alta</span>';
                                    break;
                                  endswitch;
                                ?></td>
                                <td><?php echo $value['ingeniero']?></td>
                              </tr>
                              <?php endforeach; ?>
                              <?php endif; ?>
                            </tbody> 
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>