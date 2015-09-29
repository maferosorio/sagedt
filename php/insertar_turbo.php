<?php

// $mostrar=$_REQUEST['form_turbo'];
//$co_turbocompresor = $_POST['co_turbocompresor'];
$nb_fabricante = $_REQUEST['nb_fabricante'];
$tx_modelo = $_REQUEST['tx_modelo'];
$nu_capacidad = $_REQUEST['nu_capacidad'];
$nu_estado = $_REQUEST['nu_estado'];

//conecto a la bd
$conexion = mysql_connect('localhost','mafer','mafer');
//verifico la conexion
if(!$conexion){
			
			echo "Conexion Fallida debido a: <br>".mysql_error()."<br>";
			}
//selecciono la bd
mysql_select_db('sistema',$conexion);
//inserto valores en los campos de la tabla k001t_turbocompresor
$consulta= mysql_query("INSERT INTO k001t_turbocompresor
						(nb_fabricante, tx_modelo, nu_capacidad_nominal,nu_estado)
			VALUES 
						('$nb_fabricante','$tx_modelo','$nu_capacidad','$nu_estado')
					  ");
	if($consulta)
	{
		echo "{success:true}";
	}
	else
	{
		echo "{success:false}";
	}
mysql_close($conexion);
 ?>
