<?php

//----------------------------------------------COMBO REMOTO QUE MUESTRA LOS TURBOCOMPRESORES DISPONIBLES----------------------
include_once("../modelo/combo_turbo.php");

//$combo=$_POST['equipo'];

$turbo= new comboturbo();
$resultado= $turbo->consultar_turbo();
//echo '{"success": '.$resultado['success'].', "datos":'.json_encode($resultado, true).'}';
echo '{success:true, datos:'.json_encode($resultado).'}';
?>
