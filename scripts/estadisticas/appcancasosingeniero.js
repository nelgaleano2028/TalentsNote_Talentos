$( document ).ready(function() {
	var fecha = '';

	$("#generarReporteGraficos").click(function(){
		var mes = $("#anio").val();
		var empresa = $("#empresa").val();
		var ano = $("#ano").val();
		var id_ingenieroF = $("#id_ingenieroF").val();
		var inge = $("#id_ingenieroF option:selected").text();
		var mescompleto = ano+'-'+mes;
		
		if(mes == 0){
			var mescompleto = "'"+ano+"-"+'01'+"', '"+ano+"-"+'02'+"', '"+ano+"-"+'03'+"', '"+ano+"-"+'04'+"', '"+ano+"-"+'05'+"', '"+ano+"-"+'06'+"', '"+ano+"-"+'07'+"', '"+ano+"-"+'08'+"', '"+ano+"-"+'09'+"', '"+ano+"-"+'10'+"', '"+ano+"-"+'11'+"', '"+ano+"-"+'12'+"', '";
		}

		$.ajax({
			url:  General.base+'estadistica/resultado_cantidad_casos_ing',
			type: 'POST',
			data: 'mes='+mescompleto+'&empresa='+empresa+'&REPORTECANCASOS=si'+'&id_ingeniero='+id_ingenieroF+'&mesval='+mes,
			success: function( data ){
				var totalPromResult3 = $("#recogerhoraLLegada").val(data);
				var totalPromResult4 = $("#recogerhoraLLegada").val();	
				var url= General.base+'estadistica/resultado_cantidad_casos_ing';		
				var titulo='<span style="font-weight:bold">Reporte Atencion</span>';
				var x='';
				var y='Cantidad';
				var tooltip=inge+': ';
				var container='container';
				$("#estadistica").css('display','block');		
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
					var recogeEnero = parseInt(totalPromResult4);
				}
				if(mes == '02'){
					var recogeFebrero =  parseInt(totalPromResult4);
				}
				if(mes == '03'){
					var recogeMarzo =  parseInt(totalPromResult4);
				}
				if(mes == '04'){
				
					var recogeAbril = parseInt(totalPromResult4);
				}
				if(mes == '05'){
				
					var recogeMayo = parseInt(totalPromResult4);
				}
				if(mes == '06'){
					var recogeJunio =  parseInt(totalPromResult4);
				}
				if(mes == '07'){
					var recogeJulio = parseInt(totalPromResult4);
				}
				if(mes == '08'){
					var recogeAgosto = parseInt(totalPromResult4);
				}
				if(mes == '09'){
					var recogeSeptiembre = parseInt(totalPromResult4);
				}
				if(mes == '10'){
					var recogeOctubre = parseInt(totalPromResult4);
				}
				if(mes == '11'){
					var recogeNoviembre = parseInt(totalPromResult4);
				}
				if(mes == '12'){
					var recogeDiciembre = parseInt(totalPromResult4);
				}
				if(mes == '0'){

					var myArray = totalPromResult4.split(','); //explode
					var enero = myArray[0];
					var febrero = myArray[1];
					var marzo = myArray[2];
					var abril = myArray[3];
					var mayo = myArray[4];
					var junio = myArray[5];
					var julio = myArray[6];
					var agosto = myArray[7];
					var septiembre = myArray[8];
					var octubre = myArray[9];
					var noviembre = myArray[10];
					var diciembre = myArray[11];
					var recogeEnero = parseInt(enero);
					var recogeFebrero = parseInt(febrero);
					var recogeMarzo =  parseInt(marzo);
					var recogeAbril = parseInt(abril);
					var recogeMayo =parseInt(mayo);
					var recogeJunio =  parseInt(junio);
					var recogeJulio = parseInt(julio);
					var recogeAgosto = parseInt(agosto);
					var recogeSeptiembre = parseInt(septiembre);
					var recogeOctubre = parseInt(octubre);
					var recogeNoviembre = parseInt(noviembre);
					var recogeDiciembre = parseInt(diciembre);

				}

  				var chart1 = new Highcharts.Chart({
					chart: {
						type: 'column',
						renderTo: container
					},
					title: {
						text: titulo
					},
					subtitle: {
						text: ''
					},
					        xAxis: {
						categories: [
							'Ene',
							'Feb',
							'Mar',
							'Abr',
							'May',
							'Jun',
							'Jul',
							'Ago',
							'Sept',
							'Oct',
							'Nov',
							'Dic'
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
							'<td style="padding:0"><b>'+tooltip+'{point.y:.1f}</b></td></tr>',
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
						name: 'Cantidad de Casos',
						data: [recogeEnero, recogeFebrero, recogeMarzo, recogeAbril, recogeMayo, recogeJunio, recogeJulio, recogeAgosto, recogeSeptiembre, recogeOctubre, recogeNoviembre, recogeDiciembre]

					}]
						 	 
	 			});
			}    
		});
	});
});//cierre del evento del boton CLICK
