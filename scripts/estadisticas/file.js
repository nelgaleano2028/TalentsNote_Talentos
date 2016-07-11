// JavaScript Document data: $("#form").serialize(),

$( document ).ready(function() {
    
	$( '#id_cliente' ).bind( 'change', function(){
		
		if( this.value.length > 0 ){
		
			$.ajax({
				url:  General.base+'estadistica/contactos/',
				type: 'POST',
				data: 'cliente='+this.value,
				cache: false,
				success: function(data){
					
					$( '#id_contacto' ).html( data );
			
				}						
			});
				
		}
	});
	
	$( '#datepicker1' ).bind( 'blur', function(){
			
			$.ajax({
				url:  General.base+'estadistica/resultados/',
				type: 'POST',
				dataType: 'json',
				data: 'cliente='+$( '#id_cliente' ).val()+'&ingeniero='+$( '#id_ingeniero' ).val()+'&fecha='+this.value,
				cache: false,
				success: function(data){
															
					//console.log( data );
					
					$( '#resueltos' ).val(  data.realizadas );
					
					$( '#noresueltos' ).val(  data.no_realizadas );
															
					$( '#content_table' ).html( '<tr><th></th><td>'+data.realizadas+'</td><td>'+data.no_realizadas+'</td></tr>' );
					
					if( data.realizadas != 0 || data.no_realizadas != 0 ){
					
						jQuery('#myTable5').gvChart({
							chartType: 'PieChart',
							gvSettings: {
								vAxis: {title: 'No of players'},
								hAxis: {title: 'Month'},
								width: 720,
								height: 300
								}
						});
					
					}
										
				}						
			});
		
	});
	
	
	
	$( '#datepicker2' ).bind( 'blur', function(){
		
		if( this.value.length > 0 ){
			
			if( $( '#ingeniero_1' ).val().length == 0 ){ alert( 'Campo Vacio' ); }
			
			if( $( '#ingeniero_2' ).val().length == 0 ){ alert( 'Campo Vacio' ); }
			
			if( $( '#ingeniero_1' ).val().length > 0 && $( '#ingeniero_2' ).val().length > 0 ){
			
			
				$.ajax({
					url:  General.base+'estadistica/resultados2/',
					type: 'POST',
					dataType: 'json',
					data: 'ingeniero1='+$( '#ingeniero_1' ).val()+'&ingeniero2='+$( '#ingeniero_2' ).val()+'&fecha='+this.value,
					cache: false,
					success: function(data){
						
						console.log( data );
																		
						$( '#resueltos_1' ).val(  data.realizadas_1 );
					
						$( '#noresueltos_1' ).val(  data.no_realizadas_1 );
						
						$( '#resueltos_2' ).val(  data.realizadas_2 );
					
						$( '#noresueltos_2' ).val(  data.no_realizadas_2 );
						
						$( '#content_header' ).html( '<tr><th></th><th>'+data.ingeniero1+' Realizadas</th><th>'+data.ingeniero1+' No Realizadas</th><th>'+data.ingeniero2+' Realizadas</th><th>'+data.ingeniero2+' No Realizadas</th></tr>' );
						
						$( '#content_table' ).html( '<tr><th></th><td>'+data.realizadas_1+'</td><td>'+data.no_realizadas_1+'</td><td>'+data.realizadas_2+'</td><td>'+data.no_realizadas_2+'</td></tr>' );
					
						if( data.realizadas_1 != 0 || data.no_realizadas_1 != 0 || data.realizadas_2 != 0 || data.no_realizadas_2 != 0 ){
						
							jQuery('#myTable5').gvChart({
								chartType: 'PieChart',
								gvSettings: {
									vAxis: {title: 'No of players'},
									hAxis: {title: 'Month'},
									width: 720,
									height: 300
									}
							});
						
						}
						
					}						
				});
			
		  }
		}
		
	});	
	

	
/*
=====================================
	Estadisticas de incidentes realiazados
===================================== */

	
	/*elegir todos los checbox*/
			$("#checkAll").click(function() { 
	
			  var _status = this.checked; 
			  $("input[type=checkbox]").each(function() { 
					
				  this.checked = _status; 
			  }); 
		  });
					
	
	$( '#datepicker3' ).datepicker({
		
		dateFormat: 'yy-mm-dd',
		
		onSelect: function(){
			
			
		var fecha2=$("#datepicker4").val();
		
		
		var id_ingeniero=[];
			
			 $("input:checked").each(function() {
			   id_ingeniero.push($(this).val());
			});
			$.ajax({
			  url:  General.base+'estadistica/resultados3/',
			  type: 'POST',
			  dataType: 'json',
			  data: {
					  id_ingeniero:id_ingeniero,
					  fecha2:fecha2,
					  fecha1:this.value
					  
				  },
			  cache: false,
			  success: function(data){
				
				//alert(data);
	
				  console.log(data);
				  
				  if(data.peticion == 'ok'){
					  
					  $("#estadistica").css('display','block');
					  
					  $(".table_incidente").fadeOut('slow');
					  
				  }
 
				/*  $( '#msgDialog' ).dialog({
				  autoOpen: false,
				
				  buttons: {
					  'Ok': function() {
						  $( this ).dialog( 'close' );
					  }
				  }
				});*/ //me sirve para cuando total == 0
				
				$("#checkAll").attr('checked', false);

				  
				  console.log( data );
				  
				  	parseFloat(data.datos.y);
				  
				  		var estadistica=data.datos;
	
					  for( var i in estadistica ) {
						  
						
	
					  $( '#content_table' ).append( '<tr><td>'+estadistica[i].name+'</td><td>'+estadistica[i].y+'%'+'</td></tr>' );
					  
					   }
					   
					  chart1 = new Highcharts.Chart({
						chart: {
							renderTo: 'container',
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Estadisticas de ingenieros casos resueltos'
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
					
					$( '#datepicker3' ).val('');
					$( '#datepicker4' ).val('');
	
				}	 					  
			 	
			 				
			});
	
		}	
	} );

/*
=====================================
	Estadisticas de incidentes NO realiazados
===================================== */	


	/*elegir todos los checbox*/
			$("#checkTodos").click(function() { 
	
			  var _status = this.checked; 
			  $("input[type=checkbox]").each(function() { 
					
				  this.checked = _status; 
			  }); 
		  });
					
	
	$( '#datepicker6' ).datepicker({
		
		onSelect: function(){
			
			
			var fecha2=$("#datepicker5").val();
		var id_ingeniero=[];
			
			 $("input:checked").each(function() {
			   id_ingeniero.push($(this).val());
			});
			$.ajax({
			  url:  General.base+'estadistica/resultados4/',
			  type: 'POST',
			  dataType: 'json',
			  data: {
					  id_ingeniero:id_ingeniero,
					  fecha2:fecha2,
					  fecha1:this.value
					  
				  },
			  cache: false,
			  success: function(data){
				  
				  if(data.peticion == 'ok'){
					
					$("#estadistica").css('display','block');
					  
					$(".table_incidente").fadeOut('slow');
	  
				  }

				/*  $( '#msgDialog' ).dialog({
				  autoOpen: false,
				
				  buttons: {
					  'Ok': function() {
						  $( this ).dialog( 'close' );
					  }
				  }
				});*/ //me sirve para cuando total == 0
				  
				  console.log( data );
				  
				  	parseFloat(data.datos.y);
				  
				  		var estadistica=data.datos;
	
					  for( var i in estadistica ) {
						  
						
	
					  $( '#content_table' ).append( '<tr><td>'+estadistica[i].name+'</td><td>'+estadistica[i].y+'%'+'</td></tr>' );
					  
					   }
					   
					  chart1 = new Highcharts.Chart({
						chart: {
							renderTo: 'container',
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Estadisticas de ingenieros casos resueltos'
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
					
					$( '#datepicker6' ).val('');
					$( '#datepicker5' ).val('');
	
				}	 					  
				
			});
	
		}	
	} );

			
		
				 
});


