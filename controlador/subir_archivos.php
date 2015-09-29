<?php
error_reporting(E_ALL ^ E_NOTICE);

//$turbocompresor=$_POST['equipo'];
/*echo '<pre>';
print_r($_FILES);
echo '</pre>'; */

//----------------------------------------------COMBO DE LOS TURBOCOMPRESORES DISPONIBLES----------------------
$turbo=$_POST['equipo'];


//------------------------------------------------SUBIR ARCHIVO AL SERVIDOR----------------------------------------------------	
$archivo_completo=($_FILES['archivo']['tmp_name']);
$nombre_archivo = ($_FILES['archivo']['name']);
$tipo = ($_FILES['archivo']['type']);
$tamano = ($_FILES['archivo']['size']);
$directorio = '../archivos/';
$extension = strtolower(substr(strrchr($nombre_archivo, '.'), 1));    
			
			include_once("../modelo/clase_formulario.php");
			
  			$obj = new formularios();
	/*	
						$mostrar_repetido = $obj->mostrarFormulario();
  						foreach($mostrar_repetido as $nombreCampo)
  						{
  							if($nombreCampo['nb_archivo'] == $nombre_archivo)
  							{
 	    						
 	    						$resp['success'] = 0;
								$resp['mensaje'] = 'El archivo "'.$nombre_archivo.'" ya está registrado. Favor elija otro';
								echo '{success:false, error: '.json_encode($resp['mensaje']).'}';
 	    						exit;
  			     			}
  						}
		*/
 	    				// Muevo el archivo desde su ubicación temporal al directorio definitivo
 	    				//echo $archivo_completo."-" .$directorio.$nombre_archivo;
							$mf= move_uploaded_file($archivo_completo,$directorio.$nombre_archivo);
							//echo 'mf: '.$mf;
							// print_r($mf);
							//echo $mf;
  		 					if($mf)
  		 					{
								$respuesta= $obj->insertarCampos($nombre_archivo, $turbo);
								//$mostrarform = $obj->mostrarFormulario();
								//echo '{success:true}';	
								
  		 					}
							
           	   			 	else 
           	   			 	{
								$resp['success'] = 0;
								$resp['mensaje'] = 'Error al subir archivo';
							}
	//echo "nada"	;					
 //print_r($respuesta);

	echo '{"success": '.$respuesta['success'].', "archivo":'.json_encode($respuesta['mensaje']).'}';

?>
