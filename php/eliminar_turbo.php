<?php 
$co_turbocompresor = $_POST['co_turbocompresor'];

//servidor, usuario, contraseña

$conexion = mysql_connect('localhost','mafer','mafer');

//verifico la conexion

if(!$conexion)
{
		echo "Conexion Fallida debido a: <br>".mysql_error()."<br>";
}
//selecciono la bd
mysql_select_db('sistema',$conexion);

//variable consulta
$sql = "DELETE FROM k001t_turbocompresor WHERE co_turbocompresor = $co_turbocompresor";

$peticion1 = mysql_query($sql,$conexion);

//reinicia el id si un registro es eliminado

$reiniciar_id= "ALTER TABLE k001t_turbocompresor AUTO_INCREMENT=1";

$peticion2 = mysql_query($reiniciar_id,$conexion);
 ?>
