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
          <li class=""><a href="<?php echo base_url()?>estadistica/abierto_cerrado">Casos Abiertos Vs Cerrados</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Casos Abiertos Vs Cerrados</h2 >
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
                      <div class="panel-body" id="table_incidente">
                        <form class="form col-xs-4 col-md-6">
                          <div class="form-group">
                              <label class="control-label"> Elegir a&ntilde;o</label>
                              <select name="anio" id="anio" class="form-control">
                                  <option value="0">Seleccione...</option>
                                  <?php
                                    $anio=2013;
                                    for($i=2013; $i<=$anio+5; $i++):?>
                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                    <?php endfor;?>
                              </select>  
                          </div>
                          <div class="form-group">
                            <label class="control-label"> Elegir mes</label>
                             <select name="mes" id="mes" class="form-control">                                            
                                <option value="0">Seleccione...</option>                              
                                <?php foreach($mes as $key=>$val):?>
                                <option value="<?php echo $key?>"><?php echo $val?></option>
                                <?php endforeach;?>
                            </select> 
                          </div>
                          <div class="form-group">
                              <label class="control-label"> Elegir empresa</label>
                                <select name="empresa" id="empresa" class="form-control">
                                    <option value="0">Seleccione...</option>
                                    <?php foreach($clientes as $cliente):?>
                                    <option value="<?php echo $cliente['id_cliente']?>"><?php echo $cliente['nombre_cliente']?></option>     
                                    <?php endforeach;?>
                                </select> 
                          </div>
                        </form>
                      </div>
                      <div class="panel-body" id="estadistica" style="display:none">
                        <table class="incidencias table table-striped table-bordered" id="example">
                          <thead id="content_header">
                            <tr>                      
                              <th>Nombre Ingeniero</th>
                              <th>% Porcentaje de realizados</th>                         
                            </tr>
                          </thead>
                          <tbody id="content_table">

                          </tbody>
                        </table>
                        <div id="container" style="margin-left:auto; margin-right: auto; ">
                        </div>
                      </div>
                </div>
              </div>
            </div>
          </div>
        </div>        
      </div>
    </div>
 