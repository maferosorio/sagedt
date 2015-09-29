<?php
$conexion = mysql_connect('localhost','mafer','mafer');

$accion = $_REQUEST['accion'];
//selecciono la bd
mysql_select_db("sistema",$conexion);
switch($accion)
	{ 
		case 'mostrar':
		//selecciono todo de la tabla k001t_ turbocompresor
		$count_sql = "SELECT * FROM k001t_turbocompresor";
		$arr = array();
		//consulto la tabla k001t_turbocompresor
		$peticion = mysql_query($count_sql, $conexion) or die (mysql_error());
		while ($obj = mysql_fetch_object($peticion)){ 
		$arr[] = $obj;
		}
		echo '{success:true, datos:'.json_encode($arr).'}';
		break;
	}
?>
