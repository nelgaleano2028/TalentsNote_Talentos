$( document ).ready(function() {

	var u = window.location.href;
	var ur = u.split("/");
	var base1=ur[0]+"/"+ur[1]+"/"+ur[2]+"/"+ur[3]+"/";

	var fecha ='';

	$("#anio").attr('disabled','disabled');	
 	$("#empresa").attr('disabled','disabled');

 	$("#ano").bind('change',function(){
		$("#anio").removeAttr('disabled');
 	});
 	$("#anio").bind('change',function(){
 		$("#empresa").removeAttr('disabled');
 	});

 	$("#generarReporteGraficos").click(function(){
		var mes = $("#anio").val();		
		var empresa = $("#empresa").val();
		var ano = $("#ano").val();
		var id_ingenieroF = $("#id_ingenieroF").val();
		var inge = $("#id_ingenieroF option:selected").text();

		var mescompleto = ano+'-'+mes;	
		$.ajax({
			url:  base1+'estadistica/resultado_solucion/',
			type: 'POST',
			data: 'mes='+mescompleto+'&empresa='+empresa+'&REPORTEATENCION=si'+'&id_ingeniero='+id_ingenieroF,
			success: function( data ){
				$("#recogerfechaLLegada").val(data);
				var fechallegada = $("#recogerfechaLLegada").val();
				$.ajax({
					url:  base1+'estadistica/resultado_solucion/',
					type: 'POST',
					data: 'mes='+mescompleto+'&empresa='+empresa+'&REPORTEATENCIONC2=si'+'&id_ingeniero='+id_ingenieroF,
					success: function( data ){
						$("#estadistica").css('display','block');		
						$("#recogerhoraAbierta").val(data);
						var fechacerrada = $("#recogerhoraAbierta").val();
						$.ajax({
						    url:  base1+'estadistica/resultado_solucion/',
						    type: 'POST',
						    data: 'mes='+mescompleto+'&empresa='+empresa+'&REPORTEATENCIONC3=si'+'&id_ingeniero='+id_ingenieroF,
							success: function( data ){													
								$("#recogersumaHoras").val(data);
								var fechacerrada = $("#recogersumaHoras").val();
								var resultadosumallegada = $("#recogerhoraAbierta").val();
								var resultadosumacerrado = $("#recogersumaHoras").val();
								var resultado =  resultadosumallegada-resultadosumacerrado;	
								var fechallegada = $("#recogerfechaLLegada").val();
								var resultadoprom = resultado/fechallegada;
								var totalTiempoProm =  Math.abs(resultadoprom);																							
								var totalredondeado =  Math.floor(totalTiempoProm);
						 		var resultadoprom = $("#totalpromtal").val(totalredondeado);
							  	if((totalredondeado == 0) || (totalredondeado == 'NaN')){
									var totalredondeado = "No exiten registros...";
								}
					            var resultadoPromF = $("#resultado").html(totalredondeado);	
							    var resultadoprom = $("#totalpromtal").val(totalredondeado);
								var totalPromResult2 = $("#totalpromtal").val();										                
								var url= base1+'estadistica/resultado_solucion/';									
								var titulo='<span style="font-weight:bold">Reporte Atencion</span>';
								var x='';
								var y='Cantidad';
								var tooltip='Ingeniero: '+inge;
								var container='container';
								var recogeEnero = 0;
								var recogeFebrero = 0;
								var recogeMarzo = 0;
								var recogeAbril = 0;
								var recogeMayo = 0;
								var recogeJunio = 0;
								var recogeJulio = 0;
								var recogeAgosto = 0;
								var recogeSeptiembre = 0;
								var recogeOctubre = 0;
								var recogeNoviembre = 0;
								var recogeDiciembre = 0;
								if(mes == '01'){
								var recogeEnero = parseInt(totalPromResult2);
								}
								if(mes == '02'){
								var recogeFebrero =  parseInt(totalPromResult2);
								}
								if(mes == '03'){
								var recogeMarzo =  parseInt(totalPromResult2);

								}
								if(mes == '03'){
								var recogeMarzo =  parseInt(totalPromResult2);

								}
								if(mes == '04'){
								var recogeAbril = parseInt(totalPromResult2);
								}

								if(mes == '05'){
								var recogeMayo = parseInt(totalPromResult2);
								}

								if(mes == '06'){
								var recogeJunio =  parseInt(totalPromResult2);
								}

								if(mes == '07'){
								var recogeJulio = parseInt(totalPromResult2);

								}
								if(mes == '08'){
								var recogeAgosto = parseInt(totalPromResult2);

								}
								if(mes == '09'){
								var recogeSeptiembre = parseInt(totalPromResult2);

								}
								if(mes == '10'){
								var recogeOctubre = parseInt(totalPromResult2);

								}
								if(mes == '11'){
								var recogeNoviembre = parseInt(totalPromResult2);
								}
								if(mes == '12'){
								var recogeDiciembre = parseInt(totalPromResult2);
								}
								
							  	var chart1 = new Highcharts.Chart({ 
									chart: {
										type: 'column',
										renderTo: 'container'
									},
									title: {
										text: titulo
									},
									subtitle: {
										text: ''
									},
							        xAxis: {
										categories: [
											'Enero',
											'Febrero',
											'Marzo',
											'Abril',
											'Mayo',
											'Junio',
											'Julio',
											'Agosto',
											'Septiembre',
											'Octubre',
											'Noviembre',
											'Diciembre'
										]
									},
									yAxis: {
										min: 0,
										title: {
											text: y
										}
									},
									tooltip: {
										headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
										pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
											'<td style="padding:0"><b>{point.y:.1f} '+tooltip+'</b></td></tr>',
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
										name: 'Tiempo de Solución',
										data: [recogeEnero, recogeFebrero, recogeMarzo, recogeAbril, recogeMayo, recogeJunio, recogeJulio, recogeAgosto, recogeSeptiembre, recogeOctubre, recogeNoviembre, recogeDiciembre]

									}]
								});	
							}
						});
					}
				});
			}
		});
	});
});//cierre del evento del boton CLICK
