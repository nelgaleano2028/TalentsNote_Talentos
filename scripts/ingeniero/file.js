$( document ).ready(function() {	

	$('.ver_imagen').click(function(){
		var incidencia= $('#id_imagen').val();
		$.ajax({
				
			url:  General.base+"clientes/imagen_incidencia",
			type: "POST",
			dataType: 'json',
			data: "imagen="+incidencia,
			success: function( data ){
						
			  	var extensiones_permitidas = new Array(".gif", ".jpg", ".doc", ".pdf", ".xlsx",".rar",".zip");
			  	var extension = (data.substring(data.lastIndexOf("."))).toLowerCase(); 
			  
			    if(extension == ".xlsx"){
						    
					var imagen = "<a href=' " +General.base+"incidentes/" +data +" ' target='_blank'><img src=' " +General.base+"incidentes/Excel.png'></a>"  ;
						  
				}else if(extension == ".docx"){
							  
					var imagen = "<a href=' " +General.base+"incidentes/" +data +" ' target='_blank'><img src=' " +General.base+"incidentes/word.jpg'></a>"  ;
				  
			  	}else if(extension == ".docs"){
							  
					var imagen = "<a href=' " +General.base+"incidentes/" +data +" ' target='_blank'><img src=' " +General.base+"incidentes/word.jpg'></a>"  ;
				  
			  	}else if(extension == ".doc"){
							  
					var imagen = "<a href=' " +General.base+"incidentes/" +data +" ' target='_blank'><img src=' " +General.base+"incidentes/word.jpg'></a>"  ;
				  
			  	}else if(extension == ".rar"){
				  
				  	var imagen = "<a href=' " +General.base+"incidentes/" +data +" ' target='_blank'><img src=' " +General.base+"incidentes/rar.jpg' style='width: 276px;'></a>"  ;
				  
			 	}else if(extension == ".zip"){
				  
				 	var imagen = "<a href=' " +General.base+"incidentes/" +data +" ' target='_blank'><img src=' " +General.base+"incidentes/zip.jpg' style='width: 276px;'></a>"  ;
				  
			  	}else if(extension == ".pdf"){
				  
				  	var imagen = "<a href='" +General.base+"incidentes/"+data +" ' target='_blank'><img src=' " +General.base+"incidentes/pdfp.png'></a>"  ;
				  
			  	}else if(extension == ".txt"){
				  
				  	var imagen = "<a href='" +General.base+"incidentes/" +data +" ' target='_blank'><img src=' " +General.base+"incidentes/txtp.jpg' ></a>"  ;
				  
			  	}else{
				  
				   var imagen= "  <img src=' " +General.base+"incidentes/" +data +" '  > " ;
				  
			  	}

					$('.modal-body div').html(imagen);					
			}
		});
	});
		
	
/*
===================================
	Ajax request
=================================== */

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





