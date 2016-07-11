$(document).ready( function () {
	$('#example').DataTable({
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
			"dom": 'T<"clear">lfrtip<"toolbar">'
		});

	$.extend( $.fn.dataTableExt.oStdClasses, {
	    "sSortAsc": "header headerSortDown",
	    "sSortDesc": "header headerSortUp",
	    "sSortable": "header"
	} );
} );
