<?php
//-------------------------------------------------CLASE PARA CONSULTAR LOS TURBOCOMPRESORES-----------------------------------------------
require_once '../../controlador/MyPDO.php';

class comboturbo extends MyPDO
{
	
	public function consultar_turbo()
	{		
		$sql="SELECT co_turbocompresor FROM k001t_turbocompresor WHERE nu_estado='Activo'";
		$arreglo = $this->pdo->_query($sql);
		return $arreglo;
	}
	
}

/*$conexion = mysql_connect('localhost','root','123456');

$accion = $_REQUEST['accion'];
$codigo = $_REQUEST['id'];
//selecciono la bd
mysql_select_db("sistema",$conexion);
switch($accion)
	{ 
		case 'mostrar':
		//selecciono todo de la tabla k001t_ turbocompresor
		$count_sql = "SELECT co_turbocompresor FROM k001t_turbocompresor";
		$arr = array();
		//consulto la tabla k001t_turbocompresor
		$peticion = mysql_query($count_sql, $conexion) or die (mysql_error());
		if (mysql_num_rows($peticion) > 0) {
			while ($obj = mysql_fetch_object($peticion)){ 
			$arr[] = $obj;
			}
		}
		echo '{success:true, datos:'.json_encode($arr).'}';
		break;
	}*/

?>
