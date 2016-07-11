$( document ).ready(function() {
	       
     $("#mes").attr('disabled','disabled');
	 $("#empresa").attr('disabled','disabled');
     $("#anio").bind('change',function(){
		$("#mes").removeAttr('disabled');
		$("#mes").bind('change',function(){
			$("#empresa").removeAttr('disabled');
			$( '#est_empresa' ).bind( 'click', function(){
			  $.ajax({
			 	url:  General.base+'estadistica/resultados6/',
				  type: 'POST',
				  data: 'anio='+ $("#anio option:selected").val()+'&mes='+$("#mes option:selected").val()+'&cliente='+$("#empresa option:selected").val(),
				  dataType: 'json',
				  cache: false,
				  success: function(data){
					  
						console.log(data);
						 if(data.peticion == 'ok'){
					  
						  $("#estadistica").css('display','block');
						  
						  $(".table_incidente").fadeOut('slow');
					  
				 		 }
						 
						 parseFloat(data.datos.y);
				  
				  		var estadistica=data.datos;
						
						$( '#example tbody' ).html( '' );
	
					 	for( var i in estadistica ) {
						  
	
					 	 $( '#content_table' ).append( '<tr><td>'+estadistica[i].name+'</td><td>'+estadistica[i].y+'%'+'</td></tr>' );
					  
					   }
					   
					   dataTable = $( '#example' ).dataTable({
							"bJQueryUI": true,
							"sScrollXInner": "100%",
							"sPaginationType": "full_numbers",
							"aaSorting": [[ 0, "asc" ]],
							  "oLanguage": {
								  "sLengthMenu": 'Mostrar<select>'+
									'<option value="10">10</option>'+
									'<option value="20">20</option>'+
									'<option value="30">30</option>'+
									'<option value="40">40</option>'+
									'<option value="50">50</option>'+
									'<option value="-1">Todos</option>'+
									'</select> Registros',
									
								"sSearch": "Buscar registros:",
									
								 "sZeroRecords": "No Hay Registros",
								 
								 "oPaginate": {
									"sFirst": "Primera",
									"sLast":  "Ultima",
									"sNext":  "Siguiente",
									"sPrevious": "Anterior"
								 },
								 
								 "sEmptyTable": "No hay datos disponibles en la tabla",
								 "sInfo": "Tiene un total _TOTAL_ registros (_START_ to _END_)",
								 "sInfoEmpty": "No tiene registros"
							 },
							"sDom": '<"H"Tfr>t<"F"ip>',
							"oTableTools": {
								"sSwfPath": General.base+"media/swf/copy_csv_xls_pdf.swf",
								"aButtons": [
									 "csv", "xls", "pdf",
									{
										
										"sExtends":    "collection",
										"sButtonText": "Guardar",
										"aButtons":    [ "csv", "xls", "pdf" ]
									}
								]
							}
						});
									   
						var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
						 f = new Date();
						
					   
					   chart1 = new Highcharts.Chart({
						chart: {
							renderTo: 'container',
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Estadisticas de incidentes mes de '+ + meses[f.getMonth()]
						},
						
						plotOptions: {
							pie: {
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: true,
									color: '#000000',
									connectorColor: '#000000',
									formatter: function() {
										 return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
									}
								}
							}
						},
						series: [{
							type: 'pie',
							name: 'tickets',
							data: data.datos
							
              				  
						}]
					});
					    
				  }//fin del ajax
			  });	
			
			});	
		});

	 });

});