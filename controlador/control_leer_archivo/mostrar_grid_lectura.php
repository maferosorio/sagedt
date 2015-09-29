<?php


include_once("../../modelo/modelo_leer_archivo/clase_archivo.php");

 $start=$_REQUEST['start']; 
 $limit=$_REQUEST['limit'];
 
 //echo "hola:".$start; echo "hola:".$limit; 
 
 $datos = new archivo();
 
 $mostrarCampos = $datos->mostrar_archivo($start, $limit);
 //print_r($mostrarCampos);
 $total= $datos->contar_registros();
 //$total = count($mostrarCampos);
 
 echo '{success:true,"total":'.$total.', "archivo":'.json_encode($datos->utf8ArrayEncode($mostrarCampos)).'}';
?>
