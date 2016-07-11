$( document ).ready(function() {
	
	function traer(i){
    
    switch (i){
        
        case 1:
            var retorno= 'Enero';
        break;
        case 2:
             var retorno='Febrero';
        break;
        case 3:
             var retorno='Marzo';
        break;
        case 4:
             var retorno='Abril';
        break;
        case 5:
             var retorno='Mayo';
        break;
        case 6:
             var retorno='Junio';
        break;
        case 7:
            var retorno='Julio';
        break;
        case 8:
            var retorno='Agosto';
        break;
        case 9:
             var retorno='Septiembre';
        break;
        case 10:
             var retorno='Octubre';
        break;
        case 11:
            var retorno='Nomviembre';
        break;
         case 12:
             var retorno='Diciembre';
        break;
    }; 
    
        return retorno;
   };
	
 $("#empresa").attr('disabled','disabled');	
 
  $("#anio").bind('change',function(){
	 
		$("#empresa").removeAttr('disabled');
		
		$( '#est_mes' ).bind( 'click', function(){
			// alert("hola");
			$.ajax({
			 	url:  General.base+'estadistica/resultados7/',
				  type: 'POST',
				  data: 'anio='+ $("#anio option:selected").val()+'&cliente='+$("#empresa option:selected").val(),
				  dataType: 'json',
				  cache: false,
				  success: function(data){
					  
						 if(data.peticion == 'ok'){
						  
							  $("#estadistica").css('display','block');
							  
							  $(".table_incidente").fadeOut('slow');
						  
						  }
						        var f = new Date();
								var mes=f.getMonth() +1;
								var mes_push= new Array;
								
								 for(var i=1; i<=mes; i++){
									 
									 var meses_atual=traer(i);
									 
									 mes_push.push(meses_atual);
								  
								 }
						   
							 chart1 = new Highcharts.Chart({
										chart: {
											renderTo: 'container',
											plotBackgroundColor: null,
											type: 'column',
											plotBorderWidth: null,
											plotShadow: false
										},
										title: {
								text: 'Estadisticas Por mes'
							},
							subtitle: {
								text: 'Empresa: '+data.empresa
							},
							xAxis: {
								categories:mes_push
							},
							yAxis: {
								min: 0,
								title: {
									text: 'porcentajes %'
								}
							},
							tooltip: {
								headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
								pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
									'<td style="padding:0"><b>{point.y} %</b></td></tr>',
								footerFormat: '</table>',
								shared: true,
								useHTML: true
							},
							plotOptions: {
								column: {
									pointPadding: 0.2,
									borderWidth: 0
									
								}
							},
							series: [{
								name: 'No cumple',
								data: data.no_cumple
					
							}, {
								name: 'cumple',
								data: data.cumple
					
							}, {
								name: 'pausado',
								data: data.pausado
					
							}]
						});
				  }
			});
			
		});
				
  });
});
