var oTable = $('#tabla_ingeniero').dataTable();
	oTable.fnDestroy();

$('#example').dataTable( {

			"aaSorting": [[ 0, "desc" ]],
			  "oLanguage": {
				  "sLengthMenu": 'Mostrar <select>'+
				  	'<option value="5">5</option>'+
					'<option value="10">10</option>'+
					'<option value="20">20</option>'+
					'<option value="30">30</option>'+
					'<option value="40">40</option>'+
					'<option value="50">50</option>'+
					'<option value="-1">Todos</option>'+
					'</select> Registros',
										
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
			 searching: false
					
	} );