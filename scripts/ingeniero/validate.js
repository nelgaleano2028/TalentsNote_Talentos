$( document ).ready(function() {
	
	$('#boton-imagen').bind('click', function(){
		$('#imagen2').trigger('click');
	});
		
	 $('input[type=file]').change(function() {
			
		var names = [];
		for (var i = 0; i < $(this).get(0).files.length; ++i) {
			names.push($(this).get(0).files[i].name);
		}
		$("input[name=valor]").val(names);
		
		var valoresT = $("#valor").val();
		
		var valoresT2 = $("input[name=imagen]").val(valoresT);
		
	   	var recvallor =	$("#imagen").val();									
		var res = recvallor.split(",");
		$('#valor').blur().focus();
	});	
/*
===================================
	Ajax request
=================================== */
	
	$( '#categorias' ).bind( 'change', function(){ 
		if( $( '#categorias' ).val().length > 0 ){
		
			$.ajax({
			
				  url:  General.base+"clientes/subcategorias",
				  type: "POST",
				  data: "categoria="+this.value,
				  success: function( data ){
					  
					  if( data.length > 0 )
						  $( '#id_subcategoria' ).html(data);
					   else
						   $( '#id_subcategoria' ).html( '<option value"">Seleccione...</option>' );
				  }
			});
		
		}
				
	
	});
        

	$( '#id_area' ).bind( 'change', function(){
		
		if( $( '#id_area' ).val().length > 0 ){
		
			$.ajax({
			
				  url:  General.base+"ingeniero/areas",
				  type: "POST",
				  data: "id_area="+this.value,
				  success: function( data ){
					  
					  if( data.length > 0 )					  
					  	$( '#id_ingeniero' ).html(data);
				  	  else
					  	$( '#id_ingeniero' ).html( '<option value="">Seleccione...</option>' );
					
				  }
			});
		
		}
				
	
	});	
});

