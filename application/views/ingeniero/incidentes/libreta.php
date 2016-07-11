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
                <li class=""><a href="<?php echo base_url()?>ingeniero/libreta">Ingeniero</a></li>
              </ol> 
            <div class="container-fluid">
                <div class="row">
                    <div class="panel-heading">
                        <h2>Clientes Registrados</h2 > 
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
                                <h2>Clientes Registrados</h2 > 
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Contacto</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if( !empty( $data ) ): foreach( $data as $value ): ?>
                                        <tr >
                                            <td><?php echo $value['empresa']?></td>
                                            <td><?php echo $value['nombre'].'&nbsp;&nbsp;'. $value['apellido'] ?></td>
                                            <td><?php echo $value['correo']?></td>
                                            <td><?php echo $value['telefono'] ?></td>
                                            <td><?php echo $value['usuario']?></td>
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