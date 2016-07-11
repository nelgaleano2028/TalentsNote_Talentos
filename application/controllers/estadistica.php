<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadistica extends CI_Controller{	
	
	public $view = array();
	public $login = array();	
	public $data = array();	
	public $estadistica = array();	
	public $nombre= array();	
	public $realizados= array();
	public function __construct(){ 		
		parent::__construct(); 
						
		// Permisos
		$this->login = $this->session->userdata( 'login' );
		
		if( empty( $this->login ) ) redirect( '/usuario/login', 'refresh' );
				
		if( $this->login[0]['id_perfil'] != 1 ){				
			$message = array(		
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 		
			);		
			redirect( '/admin/', 'refresh' );	
		}					
	}	
	
	public function cliente(){
		
		// Load Model
		$this->load->model( array( 'cliente', 'ingenieros' ) );
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />'
				
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.ui.datepicker-es.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/date.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jsapi.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.gvChart-1.0.min.js"></script>',
				'<script type="text/javascript">
					gvChartInit();
				</script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
				
				
			),
			'login' => $this->login,
			'section' => 'inicio',
			'content' => 'admin/estadisticas/ver2',
			'clientes' => $this->cliente->all(),
			'ingenieros' => $this->ingenieros->all()
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
	
	
	public function ingeniero(){
		
		// Load Model
		$this->load->model( array( 'cliente', 'ingenieros' ) );
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />'
				
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.ui.datepicker-es.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/date.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jsapi.js"></script>',
				/*'<script type="text/javascript" src="http://www.google.com/jsapi"></script>',*/
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.gvChart-1.0.min.js"></script>',
				'<script type="text/javascript">
					gvChartInit();
				</script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
				
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'content' => 'admin/estadisticas/ver',
			'clientes' => $this->cliente->all(),
			'ingenieros' => $this->ingenieros->all()
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
	
	public function ingenieros(){
		
		if( $this->login[0]['id_perfil'] != 1 ){
						
			$message = array(
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			);
		}
		$this->load->model('ingenieros');
		$ingeniero=$this->ingenieros->all2();

		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.min.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',
			),

			'scripts'=>array(
				
				'<script type="text/javascript" src="'.base_url().'scripts/datatable.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.ui.datepicker-es.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/date.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
	
			),
			'login' => $this->login,
			'ingeniero'=>$ingeniero,
			'section' => 'estadistica',
			'content' => 'admin/estadisticas/ver3',
			
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	}
	
	public function ingenieros2(){
		
		if( $this->login[0]['id_perfil'] != 1 ){
						
			$message = array(
			
				'type' => 'warning',
				'text' => 'No tiene permisos para accesar a esta área..' 
			
			);
		}
		
		$this->load->model('ingenieros');
		$ingeniero=$this->ingenieros->all2();

		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
                 '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.min.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',
				
				
			),
			'scripts'=>array(
				
				'<script type="text/javascript" src="'.base_url().'scripts/datatable.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.ui.datepicker-es.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/date.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',

				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
	
			),
			'login' => $this->login,
			'ingeniero'=>$ingeniero,
			'section' => 'estadistica',
			'content' => 'admin/estadisticas/ver4',
			
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	}
	
	
	public function ans(){
		
		$this->load->model('cliente');
		$clientes=$this->cliente->all();
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools.css" type="text/css" />',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools_JUI.css" type="text/css"/>'	
				
			),
			'scripts'=>array(
				 '<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script src="'.base_url().'scripts/ZeroClipboard.js"></script>',
				'<script src="'.base_url().'scripts/TableTools.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/est_mes.js"></script>'
				
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'clientes'=>$clientes,
			'content' => 'admin/estadisticas/ans',
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	
        }
	
	//*************************************
	
	
		public function reportesatencion(){
		
		$this->load->model('cliente');
		$clientes=$this->cliente->all();
	
		$this->load->model('ingenieros');
		$ingeniero=$this->ingenieros->all2();

		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
			),

			'scripts'=>array(
				'<script type="text/javascript">
				      jQuery.noConflict()
				      jQuery144 = jQuery
				      console.log(jQuery144,jQuery)
				</script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>',
				'<script type="text/javascript">
		            jQuery144(function($) {
		                console.log("hello", $.fn.jquery)
		            })
		            jQuery(function($) {
		                console.log("world", $.fn.jquery)
		            });

					$("#generarReporteGraficos").on("click", function(){
					    var posicion = $("#estadistica").height()+500;
					    $("html, body").animate({
					        scrollTop: posicion
					    }, 2000); 
					});
		        </script>',
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/est_mes.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/app.js"></script>'
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'clientes'=>$clientes,
			'content' => 'admin/estadisticas/atencion',
			
			'login' => $this->login,
			'ingeniero'=>$ingeniero,
			'section' => 'estadistica',
			'content' => 'admin/estadisticas/atencion',

	    );
		
		$this->load->view( 'includes/include', $this->view );
	
        }

	//*************************************

	public function reportessolucion(){
		
		$this->load->model('cliente');
		$clientes=$this->cliente->all();

		$this->load->model('ingenieros');
		$ingeniero=$this->ingenieros->all2();
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
				
			),
			'scripts'=>array(
	
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/appsolucion.js"></script>',
				'<script type="text/javascript" language="javascript">
					$("#generarReporteGraficos").on("click", function(){
					    var posicion = $("#estadistica").height()+500;
					    $("html, body").animate({
					        scrollTop: posicion
					    }, 2000); 
					});
				</script>',
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'clientes'=>$clientes,
			'content' => 'admin/estadisticas/solucion',
			
			
			'login' => $this->login,
			'ingeniero'=>$ingeniero,
			'section' => 'estadistica',
			'content' => 'admin/estadisticas/solucion',
	    	);
		
			$this->load->view( 'includes/include', $this->view );
        }

	//**************************************************
	
	
	
	public function reportescatidadcasos(){
		
		$this->load->model('cliente');
		$clientes=$this->cliente->all();
		$this->load->model('ingenieros');
		$ingeniero=$this->ingenieros->all2();
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
			),
			'scripts'=>array(
				'<script type="text/javascript">
				      jQuery.noConflict()
				      jQuery144 = jQuery
				      console.log(jQuery144,jQuery)
				</script>',
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>',
				'<script type="text/javascript">
		            jQuery144(function($) {
		                console.log("hello", $.fn.jquery)
		            })
		            jQuery(function($) {
		                console.log("world", $.fn.jquery)
		            })
		        </script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/appcancasos.js"></script>'
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'clientes'=>$clientes,
			'content' => 'admin/estadisticas/cancasos',
			
			
			'login' => $this->login,
			'ingeniero'=>$ingeniero,
			'section' => 'estadistica',
			'content' => 'admin/estadisticas/cancasos',
			
			
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	
        }

	public function reportescatidadcasosingenieros(){
		
		$this->load->model('cliente');
		$clientes=$this->cliente->all();
		
		$this->load->model('ingenieros');
		$ingeniero=$this->ingenieros->all2();
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
			),
			'scripts'=>array(
				'<script type="text/javascript">
				      jQuery.noConflict()
				      jQuery144 = jQuery
				      console.log(jQuery144,jQuery)
				</script>',
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>',
				'<script type="text/javascript">
		            jQuery144(function($) {
		                console.log("hello", $.fn.jquery)
		            })
		            jQuery(function($) {
		                console.log("world", $.fn.jquery)
		            })
		        </script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/est_mes.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/appcancasosingeniero.js"></script>',
				'<script type="text/javascript" language="javascript">
					$("#generarReporteGraficos").on("click", function(){
					    var posicion = $("#estadistica").height()+500;
					    $("html, body").animate({
					        scrollTop: posicion
					    }, 2000); 
					});
				</script>'
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'clientes'=>$clientes,
			'content' => 'admin/estadisticas/cancasosingeniero',
			
			
			'login' => $this->login,
			'ingeniero'=>$ingeniero,
			'section' => 'estadistica',
			'content' => 'admin/estadisticas/cancasosingeniero',
			
			
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
	
        }	
	//**************************************************

        public function reporte_ans(){
		
		// Cargar modelo de datos
		$this->load->model( 'mensual' );
		
		$anio=$_POST['anio'];
		$cliente=$_POST['empresa'];
		
		$datos=$this->mensual->reporte($anio,$cliente);
		
		
		if($datos == NULL ){
			
			$message = array(
			
				'type' => 'failure',
				'text' => 'No se ha generado reporte para este mes..' 
			
			);
			$this->session->set_flashdata( 'message', $message );					
	            redirect( 'estadistica/ans/', 'refresh' ); 
		}else{
			
			// Load Library
		        $this->load->library( array( 'exp' ) );
			
			$file = $this->exp->fullExport( $datos );	
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=downloaded.xls" );
			
			
			echo $file;
			
			
		}
		
		
			
	}
	
	public function ans_empresa(){
		
		$this->load->model('cliente');
		$clientes=$this->cliente->all();
		
		$mes=array(
			'01'=>'Enero',
			'02'=>'Febrero',
			'03'=>'Marzo',
			'04'=>'Abril',
			'05'=>'Mayo',
			'06'=>'Junio',
			'07'=>'Julio',
			'08'=>'Agosto',
			'09'=>'Septiembre',
			'10'=>'Octubre',
			'11'=>'Noviembre',
			'12'=>'Diciembre'  
			);
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools.css" type="text/css" />',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools_JUI.css" type="text/css"/>'	
				
			),
			'scripts'=>array(
				
                '<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script src="'.base_url().'scripts/ZeroClipboard.js"></script>',
				'<script src="'.base_url().'scripts/TableTools.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/est_empresa.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
				
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'mes'=>$mes,
			'clientes'=>$clientes,
			'content' => 'admin/estadisticas/ans_empresa',
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
		
		
	}
	
	public function reporte_empresa(){
		
		// Cargar modelo de datos
		$this->load->model( 'mensual' );
		
		$anio=$_POST['anio'];
		$mes=$_POST['mes'];
		$cliente=$_POST['empresa'];
		
		
		
		$datos=$this->mensual->reporte_aempresa($anio ,$mes, $cliente);
		
		if($datos == NULL ){
			
			$message = array(
			
				'type' => 'failure',
				'text' => 'No se ha generado reporte para este mes..' 
			
			);
			$this->session->set_flashdata( 'message', $message );
									
	                redirect( 'estadistica/ans_empresa/', 'refresh' ); 
			
			
			
		}else{
			
			// Load Library
		        $this->load->library( array( 'exp' ) );
			
			$file = $this->exp->fullExport( $datos );	
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=downloaded.xls" );
			
			
			echo $file;
			
			
		}
		
	}
	
	public function ans_vencidos(){
		
		$mes=array(
			'01'=>'Enero',
			'02'=>'Febrero',
			'03'=>'Marzo',
			'04'=>'Abril',
			'05'=>'Mayo',
			'06'=>'Junio',
			'07'=>'Julio',
			'08'=>'Agosto',
			'09'=>'Septiembre',
			'10'=>'Octubre',
			'11'=>'Noviembre',
			'12'=>'Diciembre'  
			);
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />'
				
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.ui.datepicker-es.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/date.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jsapi.js"></script>',
				/*'<script type="text/javascript" src="http://www.google.com/jsapi"></script>',*/
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.gvChart-1.0.min.js"></script>',
				'<script type="text/javascript">
					gvChartInit();
				</script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
				
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'mes'=>$mes,
			'content' => 'admin/estadisticas/ans_vencidos',
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
	
	public function reporte_vencido(){
		
		// Cargar modelo de datos
		$this->load->model( 'mensual' );
		
		$anio=$_POST['anio'];
		$mes=$_POST['mes'];
		
		
		$datos=$this->mensual->reporte_avencido($anio ,$mes);
		
		
		if($datos == NULL ){
			
			$message = array(
			
				'type' => 'failure',
				'text' => 'No se ha generado reporte para este mes..' 
			
			);
			$this->session->set_flashdata( 'message', $message );
									
	                redirect( 'estadistica/ans_vencidos/', 'refresh' ); 
			
			
			
		}else{
			
			// Load Library
		        $this->load->library( array( 'exp' ) );
			
			$file = $this->exp->fullExport( $datos );	
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=downloaded.xls" );
			
			
			echo $file;
			
			
		}
		
		
	}
	
	public function ans_cumple(){
		
		$mes=array(
			'01'=>'Enero',
			'02'=>'Febrero',
			'03'=>'Marzo',
			'04'=>'Abril',
			'05'=>'Mayo',
			'06'=>'Junio',
			'07'=>'Julio',
			'08'=>'Agosto',
			'09'=>'Septiembre',
			'10'=>'Octubre',
			'11'=>'Noviembre',
			'12'=>'Diciembre'  
			);
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />'
				
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.ui.datepicker-es.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/date.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jsapi.js"></script>',
				/*'<script type="text/javascript" src="http://www.google.com/jsapi"></script>',*/
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.gvChart-1.0.min.js"></script>',
				'<script type="text/javascript">
					gvChartInit();
				</script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/file.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
				
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'mes'=>$mes,
			'content' => 'admin/estadisticas/ans_cumple',
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
	
	
	public function reporte_cumple(){
		
		
		// Cargar modelo de datos
		$this->load->model( 'mensual' );
		
		$anio=$_POST['anio'];
		$mes=$_POST['mes'];
		
		
		$datos=$this->mensual->reporte_acumple($anio ,$mes);
		
		
		if($datos == NULL ){
			
			$message = array(
			
				'type' => 'failure',
				'text' => 'No se ha generado reporte para este mes..' 
			
			);
			$this->session->set_flashdata( 'message', $message );
									
	                redirect( 'estadistica/ans_cumple/', 'refresh' ); 
			
			
			
		}else{
			
			// Load Library
		        $this->load->library( array( 'exp' ) );
			
			$file = $this->exp->fullExport( $datos );	
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=downloaded.xls" );
			
			
			echo $file;
			
			
		}
			
	}
	
	
	public function ans_ingeniero(){
		
		$this->load->model('ingenieros');
		
		$ingenieros=$this->ingenieros->all();
		
		$mes=array(
			'01'=>'Enero',
			'02'=>'Febrero',
			'03'=>'Marzo',
			'04'=>'Abril',
			'05'=>'Mayo',
			'06'=>'Junio',
			'07'=>'Julio',
			'08'=>'Agosto',
			'09'=>'Septiembre',
			'10'=>'Octubre',
			'11'=>'Noviembre',
			'12'=>'Diciembre'  
			);
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools.css" type="text/css" />',
				'<link rel="stylesheet" href="'.base_url().'style/TableTools_JUI.css" type="text/css"/>'
				
			),
			'scripts'=>array(
				 '<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script src="'.base_url().'scripts/ZeroClipboard.js"></script>',
				'<script src="'.base_url().'scripts/TableTools.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/est_ing.js"></script>',
				'<script type="text/javascript" language="javascript">
					$(function() {
						$("#tool-tip").hide();
						$(".btmiddle").click(function() {
							if ($(".btmiddle").hasClass("bt")) {
								$(".btmiddle").removeClass("bt");
								$(".btmiddle").addClass("clicked");
								$("#tool-tip").show();
							} else {
								$(".btmiddle").removeClass("clicked");
								$(".btmiddle").addClass("bt");
								$("#tool-tip").hide();
							}
						});
					});
				</script>'
				
				
			),
			'login' => $this->login,
			'section' => 'lista',
			'ingenieros'=>$ingenieros,
			'mes'=>$mes,
			'content' => 'admin/estadisticas/ans_ingeniero',
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
	
	public function abierto_cerrado(){
		
		
		$this->load->model('cliente');
		$clientes=$this->cliente->all();
		
		$mes=array('01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio',
				'07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre');
		
		$this->view=array(
			'title'=>'Talents Notes',
			'css'=>array(
				'<link rel="stylesheet" href="'.base_url().'style/demo_page.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/demo_table_jui.css" type="text/css" />',
                '<link rel="stylesheet" href="'.base_url().'style/smoothness/jquery-ui-1.8.4.custom.css" type="text/css"/>',
				'<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap.css" type="text/css"/>',
                '<link rel="stylesheet" href="'.base_url().'style/bootstrap/bootstrap-theme.css" type="text/css"/>',         
				'<link rel="stylesheet" href="'.base_url().'style/TableTools.css" type="text/css" />',
			),
			'scripts'=>array(
				'<script type="text/javascript" src="'.base_url().'scripts/general.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/jquery.dataTables.js"></script>',
				'<script src="'.base_url().'scripts/ZeroClipboard.js"></script>',
				'<script src="'.base_url().'scripts/TableTools.js"></script>',
				'<script  type="text/javascript" src="'.base_url().'scripts/jquery-ui.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/highcharts.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/modules/exporting.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/estadisticas/casos.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/bootstrap.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/dataTables.bootstrap.min.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/bootstrap/npm.js"></script>',
				'<script type="text/javascript" src="'.base_url().'scripts/highcharts/themes/grid-light.js"></script>'	
			),
			'login' => $this->login,
			'section' => 'lista',
			'mes'=>$mes,
			'clientes'=>$clientes,
			'content' => 'admin/estadisticas/abierto_cerrado',
			
	    );
		
		$this->load->view( 'includes/include', $this->view );
		
	}
	
	
	public function reporte_ansingeniero(){
		
		// Cargar modelo de datos
		$this->load->model( 'mensual' );
		
		$anio=$_POST['anio'];
		$mes=$_POST['mes'];
		$ingeniero= $_POST['ingeniero'];
		
		
		$datos=$this->mensual->reporte_aingeniero($anio ,$mes, $ingeniero);
		
		
		if($datos == NULL ){
			
			$message = array(
			
				'type' => 'failure',
				'text' => 'No se ha generado reporte para este mes..' 
			
			);
			$this->session->set_flashdata( 'message', $message );
									
	                redirect( 'estadistica/ans_ingeniero/', 'refresh' ); 
			
			
			
		}else{
			
			// Load Library
		        $this->load->library( array( 'exp' ) );
			
			$file = $this->exp->fullExport( $datos );	
			header( "Content-type: application/vnd.ms-excel" );
			header( "Content-Disposition: attachment; filename=downloaded.xls" );
			
			
			echo $file;
			
			
		}
		
		
	}
	
	
	
/*
=====================================
	AJAX REQUEST
===================================== */		
	public function contactos(){
		
		if( $this->input->is_ajax_request() == false ) return false;
		
		if( empty( $_POST['cliente'] ) or !is_numeric( $_POST['cliente'] ) ) return false;
		
		// Load Model
		$this->load->model( 'contactos' );
		
		$this->data = $this->contactos->cliente( $_POST['cliente'] );
		
		$data = '<option value="">Seleccione...</option>';
		
		if( empty( $this->data  ) ){ echo $data; return false; }
		
		foreach( $this->data as $value ){
			
			$data .= '<option value="'.$value['id_contacto'].'">'.$value['nombre'].'</option>';
			
		}	
		
		echo $data;
		
		return false;
				
	}
	
	public function resultados(){
		
		if( $this->input->is_ajax_request() == false ) return false;
		
		if( empty( $_POST['cliente'] ) or !is_numeric( $_POST['cliente'] ) or  empty( $_POST['ingeniero'] ) or !is_numeric( $_POST['ingeniero'] ) or  empty( $_POST['fecha'] ) ) return false;
		
		// Load Model
		$this->load->model( 'incidencia' );
		
		$realizadas = $this->incidencia->realizadas( $_POST['cliente'], $_POST['ingeniero'], $_POST['fecha']);
		
		$no_realizadas = $this->incidencia->no_realizadas( $_POST['cliente'], $_POST['ingeniero'], $_POST['fecha']);
		
		unset($this->data); 
		
			$this->data = array(
				
				'realizadas' => $realizadas[0]['numero'],
				'no_realizadas' => $no_realizadas[0]['numero']
				
			);
		
		echo  json_encode($this->data) ;
						
	}
	
	
	public function resultados2(){
		
		if( $this->input->is_ajax_request() == false ) return false;
		
		if( empty( $_POST['ingeniero1'] ) or !is_numeric( $_POST['ingeniero1'] ) or  empty( $_POST['ingeniero2'] ) or !is_numeric( $_POST['ingeniero2'] ) or  empty( $_POST['fecha'] ) ) return false;
		
		// Load Model
		$this->load->model( array( 'incidencia', 'ingenieros' ) );
		
		$ingeniero1 = $this->ingenieros->id( $_POST['ingeniero1'] );
		
		$realizadas1 = $this->incidencia->realizadas_ingeniero_fecha( $_POST['ingeniero1'], $_POST['fecha'] );
		
		$no_realizadas1 = $this->incidencia->no_realizadas_ingeniero_fecha( $_POST['ingeniero1'], $_POST['fecha'] );
		
		$ingeniero2 = $this->ingenieros->id( $_POST['ingeniero2'] );
		
		$realizadas2 = $this->incidencia->realizadas_ingeniero_fecha( $_POST['ingeniero2'], $_POST['fecha'] );
		
		$no_realizadas2 = $this->incidencia->no_realizadas_ingeniero_fecha( $_POST['ingeniero2'], $_POST['fecha'] );
		
		
		unset( $this->data ); 
		
			$this->data = array(
				
				'ingeniero1' => $ingeniero1[0]['nombre'],
				'realizadas_1' => $realizadas1[0]['numero'],
				'no_realizadas_1' => $no_realizadas1[0]['numero'],
				'ingeniero2' => $ingeniero2[0]['nombre'],
				'realizadas_2' => $realizadas2[0]['numero'],
				'no_realizadas_2' => $no_realizadas2[0]['numero']
				
				
			);
		
		
		echo  json_encode( $this->data ) ;
						
	}
	
	public function resultados3(){
		
		if( $this->input->is_ajax_request() == false ) return false;

		 //Load Model
		$this->load->model( array( 'incidencia', 'ingenieros' ) );
		
		if($_POST['id_ingeniero'][0]== 'on')
		{
			
			unset($_POST['id_ingeniero'][0]); // borrar la casilla que elige a todos los ingenieros
		}
		
		$ingeniero=$this->input->post('id_ingeniero');
		
		
		unset( $this->data);
		
		$total=0;
		
		//$re=count($ingeniero);
		//echo $re;exit;
		foreach($ingeniero as $check){
						
			$realizadas = $this->incidencia->realizadas_ingeniero_fecha( $check, $_POST['fecha1'], $_POST['fecha2'] );
		    $total=$total + $realizadas[0]['numero'];		
		}
		
		foreach($ingeniero as $check){
			
			$realizadas= $this->incidencia->realizadas_ingeniero_fecha( $check, $_POST['fecha1'], $_POST['fecha2'] );
			$ingenieros= $this->ingenieros->id( $check );
			
			//si el total es cero mensaje
			if($total== 0){
				
				break;
			}else{
			    $estadistica= (100 * $realizadas[0]['numero']) / $total;
			   	$y=round($estadistica);
			   	$this->data[]=array(
			  		'name'=>$ingenieros[0]['nombre'],
				  	'y' => $y,
			   	);
			}

		}
		
		if($total==0){
			
			$this->data[]=array(
				'name'=>'No hay datos',
				'y' => '0 resultados',
					
			);
			
			echo json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok'));
		}else{
			
			echo  json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok')) ;
		}
		
			
    }
	
	public function resultados4(){
		
		if( $this->input->is_ajax_request() == false ) return false;

		 //Load Model
		$this->load->model( array( 'incidencia', 'ingenieros' ) );
		
		if($_POST['id_ingeniero'][0]== 'on')
		{
			
			unset($_POST['id_ingeniero'][0]); // borrar la casilla que elige a todos los ingenieros
		}
		
		$ingeniero=$this->input->post('id_ingeniero');
		
		unset( $this->data);
		
		$total=0;
		
		foreach($ingeniero as $check){
			
			$realizadas = $this->incidencia->no_realizadas_ingeniero_fecha( $check, $_POST['fecha1'], $_POST['fecha2'] );
			
		
				$total=$total + $realizadas[0]['numero'];
						
		}
		
		
		foreach($ingeniero as $check){
			
			$realizadas= $this->incidencia->no_realizadas_ingeniero_fecha( $check, $_POST['fecha1'], $_POST['fecha2'] );
			$ingenieros= $this->ingenieros->id( $check );
			
				//si el total es cero mensaje
				if($total== 0){
					
					break;
					
				}else{
					
					$estadistica= (100 * $realizadas[0]['numero']) / $total;
				  
				  
				       $y=round($estadistica);
				  
		  
					$this->data[]=array(
						'name'=>$ingenieros[0]['nombre'],
						'y' => $y,
					
					);
					
				}

		}
		
		if($total==0){
			
			$this->data[]=array(
				'name'=>'No hay datos',
				'y' => '0 resultados',
					
			);
			
			echo json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok'));
			
		}else{
			echo  json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok')) ;
		}
		
	
    }
	
	public function resultados5(){
		
		if( $this->input->is_ajax_request() == false ) return false;

		 //Load Model
		$this->load->model( array( 'incidencia', 'estados' ) );
	
		$cliente=$this->input->post('cliente');
		$anio=$this->input->post('anio');
		$mes=(int)$this->input->post('mes');
		
		$fecha=$anio.'-'.$mes;
		$fecha=strtotime($fecha);
        $fecha=date('Y-m',$fecha);
		unset($this->data);
		$total=0;
		$estados=$this->estados->all();		
		foreach($estados as $estado){
			$realizadas = $this->incidencia->casos( $estado['id_estado'], $fecha, $cliente );
		    $total=$total + $realizadas[0]['numero'];
			 				
		}		
		if($total==0){
			
			$this->data[]=array(
				'name'=>'No hay datos',
				'y' => '0 resultados',
					
			);
			echo json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok'));
		}else{
			
			 foreach($estados as $estado){
			
				$realizadas = $this->incidencia->casos( $estado['id_estado'] , $fecha, $cliente );
			
				  $estadistica= (100 * $realizadas[0]['numero']) / $total;
				
				 $y=round($estadistica);
				
		
				 $this->data[]=array(
					'name'=>$estado['nombre_estado'],
					'y' => $y,
				
				 );
			}
			
			echo  json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok')) ;
			
		}		
	
	} 
	
	public function resultados6(){
		
		if( $this->input->is_ajax_request() == false ) return false;

		 //Load Model
		$this->load->model( array( 'incidencia' ) );
	
		$cliente=$this->input->post('cliente');
		$anio=$this->input->post('anio');
		$mes=$this->input->post('mes');
		
		$fecha=$anio.'-'.$mes;
		
		unset( $this->data);
		
		$total=0;
	
		$ans_empresa=array(
			'1'=>'No cumple',
			'2'=>'Cumple',
			'3'=>'Pausado'
		);
		
		
		foreach($ans_empresa as $key=>$ans){
			
			$realizadas = $this->incidencia->traer_ids( $fecha, $cliente, $ans );
		    $total=$total + $realizadas[0]['numero'];
		}
		
		if($total==0){
			
			$this->data[]=array(
				'name'=>'No hay datos',
				'y' => '0 resultados',
					
			);
			echo json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok'));
			
		}else{
			
			 foreach($ans_empresa as $key=>$ans){
				$realizadas = $this->incidencia->traer_ids( $fecha, $cliente, $ans );
			
				$estadistica= (100 * $realizadas[0]['numero']) / $total;
				
				$y=round($estadistica);
				$this->data[]=array(
					'name'=>$ans,
					'y' => $y,
				);
			}
			
			echo  json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok')) ;
		}		
	} 
	public function resultados7(){
		
		if( $this->input->is_ajax_request() == false ) return false;

		 //Load Model
		$this->load->model( array( 'incidencia','cliente' ) );
	
		$cliente=$this->input->post('cliente');
		$anio=$this->input->post('anio');
		
		unset( $this->data);
		$actual= time();	
		$mes=date( 'n', $actual ); // 'n' Representación numérica de un mes, sin ceros iniciales
		$anio_actual=date( 'Y', $actual );
		//$fecha=array();
		$fechas=array();
		
		for($i=1; $i<=$mes;$i++){
			
			$mes_actual=$anio_actual.'-'.$i;
			$mes_actual= strtotime($mes_actual);
			$mes_actual= date('Y-m',$mes_actual);
			
			array_push($fechas, $mes_actual); // array_push agrega datos a un arreglo 
			
		}
		
		$ans_empresa=array(
			'1'=>'No cumple',
			'2'=>'Cumple',
			'3'=>'Pausado'
		);
		
		$total=0;
		foreach($fechas as $key=>$fecha){
			
			foreach($ans_empresa as $llave=>$ans){
				
				$realizadas = $this->incidencia->traer_mes( $fecha, $cliente, $ans );
			
		        $total=$total + $realizadas[0]['numero'];
			
			
			}
			
			
			if($total==0){
				
				$this->data[]=array(
					'name'=>'No hay datos',
					'y' => '0 resultados',
						
				);
				echo json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok'));
				
			}else{

				   foreach($ans_empresa as $key=>$ans){
				  
					  $realizadas = $this->incidencia->traer_ids( $fecha, $cliente, $ans );
				  
					  $estadistica= (100 * $realizadas[0]['numero']) / $total;
					  
					   $y=round($estadistica);
					  
			  
					   $this->data[]=array(
						  'name'=>$ans,
						  'y' => $y,
					  
					   );
					   
				   }
					
					
				}
					 				
		}
	
		$arregloNoCumple=array();
		$arregloCumple=array();
		$pausado=array();
		
		foreach($this->data as $llave2=>$valor2){
			if($valor2['name']=='No cumple'){
			  	array_push($arregloNoCumple,$valor2['y'] );					
			}elseif($valor2['name']=='Cumple'){
				array_push($arregloCumple,$valor2['y'] );				
			}elseif($valor2['name']=='Pausado'){
				array_push($pausado,$valor2['y'] );
			}
		}
		
		$empresa=$this->cliente->id($cliente);
		
		echo  json_encode(array('empresa'=>$empresa[0]['nombre_cliente'],'no_cumple'=>$arregloNoCumple, 'cumple'=>$arregloCumple,'pausado'=>$pausado,'peticion'=>'ok')) ;		
	} 
	public function resultados8(){
		
		if( $this->input->is_ajax_request() == false ) return false;

		 //Load Model
		$this->load->model( array( 'incidencia' ) );
	
		$ingeniero=$this->input->post('ingeniero');
		$anio=$this->input->post('anio');
		$mes=$this->input->post('mes');
		
		$fecha=$anio.'-'.$mes;
		
		unset( $this->data);
		
		$total=0;
		
		
		$ans_empresa=array(
			'1'=>'No cumple',
			'2'=>'Cumple',
			'3'=>'Pausado'
		);
		
		
		foreach($ans_empresa as $key=>$ans){
			
			$realizadas = $this->incidencia->traer_ingeniero( $fecha, $ingeniero, $ans );
			
		    $total=$total + $realizadas[0]['numero'];
			 				
		}
		
		
		if($total==0){
			
			$this->data[]=array(
				'name'=>'No hay datos',
				'y' => '0 resultados',
					
			);
			echo json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok'));
			
		}else{
			
			
			 foreach($ans_empresa as $key=>$ans){
			
				$realizadas = $this->incidencia->traer_ids( $fecha, $ingeniero, $ans );
			
				$estadistica= (100 * $realizadas[0]['numero']) / $total;
				
				 $y=round($estadistica);
				
		
				 $this->data[]=array(
					'name'=>$ans,
					'y' => $y,
				
				 );
			}
			
			echo  json_encode(array( 'datos'=>$this->data, 'peticion'=>'ok')) ;
			
		}		
	} 
    public function resultado_atencion(){
		if( $this->input->is_ajax_request() == false ) return false;
		$this->load->model( array( 'incidencia' ) );
		$mes = $_POST['mes'];
		$empresa = $_POST['empresa'];
		$id_ingeniero = $_POST['id_ingeniero'];

		if(isset($_POST['REPORTEATENCION'])=="si"){
			$data=$this->incidencia->reporte_atencion($mes,$empresa,$id_ingeniero);
			echo $data;
		}
		if(isset($_POST['REPORTEATENCIONC'])=="si"){
			$data=$this->incidencia->reporte_atencionc($mes,$empresa,$id_ingeniero);
			echo $data;
		}
		if(isset($_POST['REPORTEATENCIONHORAS'])=="si"){
			$data=$this->incidencia->reporte_atencionhoras($mes,$empresa,$id_ingeniero);
			echo $data;
		}
		if(isset($_POST['READ'])=="si"){
			$data=$this->incidencia->reporte_read($empresa);
			echo $data;
		}

	}

	public function resultado_solucion(){
		if( $this->input->is_ajax_request() == false ) return false;
		$this->load->model( array( 'incidencia' ) );
		$mes = $_POST['mes'];
		$empresa = $_POST['empresa'];
		$id_ingeniero = $_POST['id_ingeniero'];

		if(isset($_POST['REPORTEATENCION'])=="si"){
			$data=$this->incidencia->reporte_atencion($mes,$empresa,$id_ingeniero);
			echo $data;
		}
		if(isset($_POST['REPORTEATENCIONC2'])=="si"){
			$data=$this->incidencia->reporte_solucion($mes,$empresa,$id_ingeniero);
			echo $data;
		}
		if(isset($_POST['REPORTEATENCIONC3'])=="si"){
			$data=$this->incidencia->reporte_solucion_final($mes,$empresa,$id_ingeniero);
			echo $data;
		}
	}

	public function resultado_cantidad_casos(){
		if( $this->input->is_ajax_request() == false ) return false;
		$this->load->model( array( 'incidencia' ) );
		$mesVal = $_POST['mesval'];
		$empresa = $_POST['empresa'];
		$mes = $_POST['mes'];
		if(isset($_POST['REPORTECANCASOS'])=="si"){
			$data=$this->incidencia->reporte_cantidad_casos($mes,$mesVal,$empresa);
			echo $data;
		}
	}

	public function resultado_cantidad_casos_ing(){
		if( $this->input->is_ajax_request() == false ) return false;
		$this->load->model( array( 'incidencia' ) );
		$mesVal = $_POST['mesval'];
		$empresa = $_POST['empresa'];
		$mes = $_POST['mes'];
		$id_ingeniero = $_POST['id_ingeniero'];

		if(isset($_POST['REPORTECANCASOS'])=="si"){
			$data=$this->incidencia->reporte_cantidad_casos_ing($mes,$mesVal,$empresa,$id_ingeniero);
			echo $data;
		}
	}
}
?>