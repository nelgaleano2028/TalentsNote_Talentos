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
                <li class=""><a href="<?php echo base_url()?>usuario/">Usuario</a></li>
              </ol> 
              <div class="container-fluid">

                <div class="row">
                  <div class="panel-heading">
                    <h2>Usuarios Registrados</h2 > 
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
                            <h2>Usuarios Registrados</h2 > 
                        </div>
                        <div class="panel-body">
                          <table class="table table-striped table-bordered" id="example">
                             <thead>
                              <tr>
                                  <th>Codigo</th>
                                  <th>Usuario</th>
                                  <th>Contacto</th> <!--Ojo preguntar si tiene id_contaco o si tiene id_ingeniero-->
                                  <th>Perfil</th>
                                  <th>Estado</th>
                                  <th>Editar</th>
                                  <th>Eliminar</th>
                              </tr>
                            </thead>
                            <tbody>
                               
                             <?php if( !empty( $data ) ):  foreach( $data as $value  ):?>
                              
                              <tr >
                                  <td><?php echo $value['id_usuario'] ?></td>
                                  <td><?php echo $value['Usuario'] ?></td>
                                  <td><?php echo $value['contacto'] ?></td>
                                  <td>
                                    <?php echo $value['perfil'] ?>
                                  </td>
                                  <td>
                                    <?php 
                                      if( $value['estado'] == 1 ) echo 'Activo'; 
                                      if( $value['estado'] != 1 ) echo 'Inactivo';  
                                    ?>
                                  </td>
                                  <td class="center"><a href="<?php echo base_url() ?>usuario/editar/<?php echo $value['id_usuario']?>" title="Editar elemento" >
                                  <img src="<?php echo base_url()?>images/editar.png" width="20" height="20" title="Editar elemento" alt="editar"/></a>
                                  </td>
                                  <td class="center"><a href="<?php echo base_url() ?>usuario/eliminar/<?php echo $value['id_usuario']?>" onclick="javascript: if( !confirm( 'Quiere eliminar este elemento ?' ) ) return false;">
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