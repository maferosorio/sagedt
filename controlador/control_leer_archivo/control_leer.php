<?php

include_once("../../libreria/excel_reader2.php");
include_once("../../modelo/modelo_leer_archivo/clase_archivo.php");

//------------------------------------------------------------COMBOBOX TURBOCOMPRESOR---------------------------------------------------------

$turbo=$_REQUEST['equipo'];

//-----------------------------------------------------------ARCHIVO CON DATOS DE TURBOCOMPRESOR----------------------------------------------
$archivo_completo=$_FILES['archivo']['tmp_name'];
$nombre_archivo = $_FILES['archivo']['name'];
$tipo = $_FILES['archivo']['type'];
$tamano = $_FILES['archivo']['size'];
$directorio = '../../archivos/';


function exportar($archivo, $turbo)
{		
	
	$datos = new archivo();
	$xls = new Spreadsheet_Excel_Reader("../../archivos/$archivo");

		$columnas=$xls->colcount();
		$filas=$xls->rowcount();
		$valor="";
		$campo = array('co_turbocompresor','co_dato','tx_descripcion','nu_valor_dato','tx_unidad_medida','fe_fecha_inspeccion');	
		
		for ($row=1;$row<=$filas;$row++) 
		{	
			$vector=array();
			for ($col=1;$col<=$columnas;$col++) 
			{

				if($xls->val($row,$col)) 		
				{	
					
					$valor=str_replace(";",'',$xls->val($row,$col));
					$vector[$campo[$col/*-1*/]]=$valor;
				}
				
			}  
				$vector["co_turbocompresor"]=$turbo;
				$vector["co_archivo"]=$archivo; //$archivo

				$resultado = $datos->insertar_archivo($vector);
				if($resultado)
				{$resp+=1;}
		}
		return $resultado; 
}



$uploaded = 0;
$failed = 0;

	if (!file_exists($directorio))
		{mkdir($directorio, 0777, true);}



        // max upload file is 25 KB
        if (($_FILES['archivo']['size'] <= 5000000) and ($_FILES['archivo']['size'] > 0) )
        {
            // mueve el documento a la carpetas "archivos" del servidor
            move_uploaded_file($_FILES['archivo']['tmp_name'],$directorio.$_FILES['archivo']['name']);
			
			$var=exportar($_FILES['archivo']['name'], $turbo);
			$uploaded++;
        } 
		else if ($tipo != '') 
		{
            $failed++;
        }


	//echo '{"success": '.$respuesta['success'].', "archivo":'.json_encode($respuesta, true).'}';
echo '{success: true, failed: '.$failed.', uploaded: '.$uploaded.', archivo: '.json_encode($var, true).'}';

	/*	$datos_archivo= new archivo();
		$respuesta= $datos_archivo->insertarCampos($nombre_archivo);
echo '{"success": '.$respuesta['success'].', "archivo":'.json_encode($respuesta['mensaje']).'}';*/
?>
