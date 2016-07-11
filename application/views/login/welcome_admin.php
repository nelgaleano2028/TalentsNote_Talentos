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
                <li class="active"><a href="<?php echo base_url()?>admin">Perfil</a></li>
              </ol> 
              <div class="container-fluid">

                <div class="row">
                  <div class="panel-heading">
                    <h2>Bienvenido Administrador</h2 > 
                  </div>
                  <div class="col-md-12 col-lg-12">
                    <div class="panel panel-default">
                        <?php $message = $this->session->flashdata( 'message' ); ?>
       
                       <?php if( !empty( $message ) ): ?>
                            
                       <!-- Notification messages -->
                       <div class="pt20">
                            <?php if( $message['type'] == 'warning' ): ?>
                            <div class="nNote nWarning hideit">
                                <p><strong>WARNING: </strong><?php echo $message['text'] ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if( $message['type'] == 'information' ): ?>
                            <div class="nNote nInformation hideit">
                                <p><strong>INFORMATION: </strong><?php echo $message['text'] ?></p>
                            </div>   
                            <?php endif; ?>
                            <?php if( $message['type'] == 'success' ): ?> 
                            <div class="nNote nSuccess hideit">
                                <p><strong>SUCCESS: </strong><?php echo $message['text'] ?></p>
                            </div> 
                            <?php endif; ?> 
                            <?php if( $message['type'] == 'failure' ): ?>
                            <div class="nNote nFailure hideit">
                                <p><strong>FAILURE: </strong><?php echo $message['text'] ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                       
                       <?php endif; ?> 

                        <div class="panel-heading">
                            <h2>Perfil</h2 > 
                        </div>
                        <div class="panel-body">
                          <table class="table table-striped table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th>Empresa:</th>
                                    <th>Nit:</th>
                                    <th>Telefono:</th>
                                    <th>Direccion:</th>
                                    <th>Website:</th>
                                </tr>
                            </thead>
                            <tbody>                            
                                <tr>
                                    <td>Talentos y Tecnologia</td>
                                    <td>830-071958-5</td>
                                    <td>371-7611</td>
                                    <td class="center">avenida 2da EN # 40-73</td>
                                    <td class="center">www.talentsw.com</td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>