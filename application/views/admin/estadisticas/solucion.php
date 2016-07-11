<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>


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
	        <li class=""><a href="<?php echo base_url()?>estadistica/reportessolucion">Reporte Solución</a></li>
        </ol> 
        <div class="container-fluid">
          <div data-widget-group="group1" class="ui-sortable">
            <div class="row">
              <div class="col-xs-12">
                <div class="panel panel-midnightblue" data-widget="{'draggable:false'}" data-widget-static=""
                    style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                    <div class="panel-heading">
                      <h2>Reportes de Solución por mes</h2 >
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
                        <form action="" method="post" id="form" class="form-horizontal" >
	                        <div class="form-group">
	                              <label class="col-sm-2 control-label"> Elegir a&ntilde;o</label>
	                              <div class="col-sm-8">
	                              	<select name="ano" id="ano" class="form-control">
										<option value="" >Seleccione...</option> 
										<?php
											$anio=2014;
											for($i=2014; $i<=$anio+1; $i++):?>
		                                <option value="<?php echo $i?>"><?php echo $i?></option>
										<?php endfor;?>
									</select>
	                              </div> 
	                        </div>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label">Elegir mes</label>
	                            <div class="col-sm-8">
									<select name="anio" id="anio" class="form-control">
									<option value="0" >Seleccione...</option>
									<option value="01" >Enero</option>
									<option value="02" >Febrero</option>
									<option value="03" >Marzo</option>
									<option value="04" >Abril</option>
									<option value="05" >Mayo</option>
									<option value="06" >Junio</option>
									<option value="07" >Julio</option>
									<option value="08" >Agosto</option>
									<option value="09" >Septiembre</option>
									<option value="10" >Octubre</option>
									<option value="11" >Noviembre</option>
									<option value="12" >Diciembre</option>
								</select> 
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label"> Elegir empresa</label>
                                <div class="col-sm-8">
                                	<select name="empresa" id="empresa" class="form-control">
										<option value="">Seleccione...</option>
										<?php foreach($clientes as $cliente):?>
										<option value="<?php echo $cliente['id_cliente']?>"><?php echo $cliente['nombre_cliente']?></option>
										<?php endforeach;?>
									</select>
                                </div>
                                
	                        </div>
	                        <div class="form-group">
	                            <label class="col-sm-2 control-label">Elegir Ingeniero</label>
                                <div class="col-sm-8">
	                                <select name="id_ingeniero" id="id_ingenieroF" class="form-control">
										 <option value="">Seleccione...</option>
										<?php foreach($ingeniero as $ingenieros):?>
											<option value="<?php echo $ingenieros['id_ingeniero']?>"><?php echo $ingenieros['nombre']?></option>
										<?php endforeach;?>
									</select>
								</div>
	                        </div>
                    </div>
                    <div class="form-boton panel-footer">
                        <div class="row">
                            <div class="form-boton2 col-sm-8" style="margin-left:20px;">
                                <input type="button" class="form-insert btn btn-primary" id="generarReporteGraficos" value="Generar Reporte"/>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            	<input type="hidden" id="recogerfechaLLegada">
				<input type="hidden" id="recogerhoraAbierta">
				<input type="hidden" id="recogersumaHoras">
                <div class="panel panel-midnightblue" id="estadistica" style="display:none">
                	<div class="panel-heading">
                      <h2>El promedio de Solución en Minutos es de:&nbsp;</h2><p id="resultado" style="font-size:15px;"></p>
                    </div>
					<input type="hidden" id="totalpromtal">

                    <div id="container" style="margin-left: auto; margin-right: auto;">
                	</div>
                </div>
              </div>
            </div>
          </div>
        </div>        
      </div>
    </div>
	
