// JavaScript Document

$( document ).ready(function() {

	$('[name="notas"]').summernote({
	    height: 300,
	    toolbar: [
			    ['style', ['bold', 'italic', 'underline', 'clear']],
			    ['para', ['ul', 'ol']]
	    ]
    });	

	/*
===================================
	Ajax request
=================================== */
	$( '#id_area' ).bind( 'change', function(){ 
		var id = $(this).val();
		$("#id_area [selected=\"selected\"").removeAttr("selected");
		$("#id_area option[value="+id+"]").attr("selected","selected");

		if( $( '#id_area' ).val().length > 0 ){
		
			$.ajax({
			    url:  General.base+"ingeniero/areas",
			    type: "POST",
			    data: "id_area="+this.value,
			    success: function( data ){
					if(data.length > 0 )					  
						$( '#id_ingeniero' ).html(data);
					else
						$( '#id_ingeniero' ).html( '<option value="">Seleccione...</option>' );
			    }
			});
		}
	});	
	

	$( '#clickcambioing' ).click(function(){ 
		var  url3 = "http://"+location.host+"/";
		var id_incidencia = $("#id_incidencia").val();
		var id_estado = $("#id_estado").val();
		var id_condicion = $("#id_condicion").val();
		var id_area = $("#id_area").val();
		var id_ingeniero = $("#id_ingeniero").val();		
			$.ajax({
				url:  url3+"modeloTalentos/actualizaring.php",
				type: "POST",
				data: 'CAMBIOINGADMIN=si'+'&id_estado='+id_estado+'&id_condicion='+id_condicion+'&id_area='+id_area+'&id_ingeniero='+id_ingeniero+'&id_incidencia='+id_incidencia,
				success: function( data ){		  
					location.href=General.base+'incidencias/';
				}
			});
	});
	
	
});