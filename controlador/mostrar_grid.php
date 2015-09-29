<?php

//include_once("incluir_modelo.php");
//include_once("../modelo/clase_conectar.php");
include_once("../modelo/clase_formulario.php");

 
 $datos = new formularios();
 $mostrarCampos = $datos->mostrarFormulario();
 //echo json_encode($mostrarCampos);
 
 echo '{success:true, archivo:'.json_encode($mostrarCampos).'}';
?>
