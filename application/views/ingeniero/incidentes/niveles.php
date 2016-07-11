<?php
echo "hola";

/*
	
		$sql = "SELECT USUARIO, NOM_PRG FROM acc_programas 
				WHERE USUARIO = '$UsuarioEm'";


		//var_dump($sql);
		$stid = oci_parse($conn, $sql);
			$rs = oci_execute($stid);
			 $num = "";
			while ($obj = oci_fetch_assoc($stid)) {
				 @$num = oci_num_rows($stid);
				//@$Usuario = $obj['USUARIO'];
				@$Nom_P = $obj['NOM_PRG'];
		}  

		 if(@$Nom_P == ""){
				  echo "False";
		  }else{
				 //echo @$Usuario;

				 echo @$Nom_P;
		  }              


		//echo $Usuario."-";

		//echo @$Nom_P;	*/

?>