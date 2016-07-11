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
                <li class=""><a href="">Reportes</a></li>
            </ol> 
            <div class="container-fluid">
                <div class="row">
                    <div class="panel-heading">
                        <h2>Reportes</h2 > 
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
                                <h2>Reportes</h2 > 
                            </div>
                            <div class="panel-body">
                                
                                <div class="toolbar" style="margin-bottom:5px; text-align: right;">
                                    <a class="btn btn-success" href="<?php echo base_url()?>ingeniero/reporte_print2/<?php echo $this->login[0]['id_ingeniero'].'/xls'?>" >Excel
                                    </a>
                                    <a class="btn btn-danger" href="<?php echo base_url()?>ingeniero/reporte_print2/<?php echo $this->login[0]['id_ingeniero'].'/pdf'?>" target="_blank">PDF</a>
                                </div>
                                <table class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Estado</th>
                                            <th>Cliente</th> 
                                            <th>Prioridad</th>
                                            <th>Asunto</th>
                                            <th>Contacto</th>
                                            <th>Fecha</th>
                                            <th>Fecha Final</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if( !empty( $data ) ): foreach( $data as $value ): ?>
                                        <tr>
                                            <td><?php echo $value['id_incidencia']?></td>
                                            <td><?php echo $value['estado']?></td>                  
                                            <td><?php echo $value['cliente'] ?>  </td>
                                            <td class="center"><?php echo $value['prioridad'] ?></td>
                                            <td class="center"><?php echo $value['asunto'] ?></td>
                                            <td class="center"><?php echo $value['contacto'] ?></td>
                                            <td class="center"><?php echo $value['fecha'] ?></td>
                                            <td class="center"><?php echo $value['fecha_final'] ?></td>

                                            <td>
                                                <a href="<?php echo base_url()?>ingeniero/reporte_print/<?php echo $value['id_incidencia'].'/pdf'?>" target="_blank">
                                                    <img src="<?php echo base_url()?>images/pdf.png" width="20" height="20" alt="imprimir en pdf"  title="pdf" />
                                                </a>
                                                
                                                <a href="<?php echo base_url()?>ingeniero/reporte_print/<?php echo $value['id_incidencia'].'/xls'?>" >
                                                    <img src="<?php echo base_url()?>images/excel.png" width="20" height="20" alt="imprimir en pdf"  title="excel"/>
                                                </a>
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