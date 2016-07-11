 var asInitVals = new Array();
 $(document).ready(function() {	
		  oTable = $('#example').dataTable({
			  "bJQueryUI": true,
			  "sPaginationType": "full_numbers",
			  "aaSorting": [[ 15, "desc" ]],
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
			 }
			  
		  });

			$("tfoot input").keyup( function () {
					
					oTable.fnFilter( this.value, $("tfoot input").index(this) );
				} );
				
				
	
				$("tfoot input").each( function (i) {
					asInitVals[i] = this.value;
				} );
				
				$("tfoot input").focus( function () {
					if ( this.className == "search_init" )
					{
						this.className = "";
						this.value = "";
					}
				} );
				
				$("tfoot input").blur( function (i) {
					if ( this.value == "" )
					{
						this.className = "search_init";
						this.value = asInitVals[$("tfoot input").index(this)];
					}
				} );
} );