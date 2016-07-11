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
                <li class=""><a href="">Estadisticas</a></li>
                <li class=""><a href="<?php echo base_url()?>estadistica/ingenieros2">Reporte no Realizados</a></li>
              </ol> 
              <div class="container-fluid">

                <div class="row">
                  <div class="panel-heading">
                    <h2>No realizados</h2 > 
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
                              <h2>No realizados</h2 > 
                          </div>
                          <div class="panel-body">
                          <form  action="" method="post" >
                            <input id="checkAll" name="checkAll" type="checkbox" style="vertical-align: bottom;" /> Elegir todos los ingenieros
                            <br>
                            <br>
                            Desde: <input type="text" name="datepicker4" id="datepicker4" class="input-media" style="margin-bottom: 18px;>">
                            Hasta: <input type="text" id="datepicker3" class="input-media">
                            <table class="table table-striped table-bordered" id="example">
                              <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Area</th>
                                    <th>Cargo</th>
                                    <th>Estado Laboral</th>
                                    <th>Elegir</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if( !empty( $ingeniero) ):  foreach( $ingeniero as $value  ):?>
                                  <tr>
                                      <td><?php echo $value['nombre'] ?></td>
                                      <td><?php echo $value['area'] ?></td>
                                      <td><?php echo $value['cargo'] ?></td>
                                      <td><?php echo $value['estado_laboral'] ?></td>
                                      <td class="prueba"><input type="checkbox" name="id_ingeniero[]" id="id_ingeniero" value="<?php echo $value['id_ingeniero'] ?>"></td>
                                  </tr>
                                <?php endforeach; endif; ?>
                              </tbody>
                            </table>
                          </form>
                          <div id="estadistica" style="display:none">
                            <table class="incidencias table table-striped table-bordered">
                              <caption>Estadisticas</caption>
                              <thead id="content_header">
                                <tr>                      
                                  <th>Nombre Ingeniero</th>
                                  <th>% Porcentaje de realizados</th>                         
                                </tr>
                              </thead>
                              <tbody id="content_table">

                              </tbody>
                            </table>
                            <div id="container">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>