<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
require_once '../../controlador/MyPDO.php';


class archivo extends MyPDO
{
	private $campo_col = array('co_turbocompresor'=>'co_turbocompresor',
								'co_archivo'=>'co_archivo',
								'co_dato'=>'co_dato',
								'tx_descripcion'=>'tx_descripcion',
								'nu_valor_dato'=>'nu_valor_dato',
								'tx_unidad_medida'=>'tx_unidad_medida',
								'fe_fecha_inspeccion'=>'fe_fecha_inspeccion');
	
	
	public function utf8ArrayDecode(array $array) {
		$convertedArray = array();
		foreach($array as $key => $value) {
		  //if(!mb_check_encoding($key, 'UTF-8'))
		  $key = utf8_decode($key);
		  if(is_array($value)) $value = $this->utf8ArrayDecode($value);
		  else $value = utf8_decode($value);

		  $convertedArray[$key] = $value;
		  //echo "<br>".$value;
		}
		return $convertedArray;
	}

	public function utf8ArrayEncode(array $array) {
		$convertedArray = array();
		foreach($array as $key => $value) {
		  //if(!mb_check_encoding($key, 'UTF-8'))
		  $key = utf8_encode($key);
		  if(is_array($value)) $value = $this->utf8ArrayEncode($value);
		  else $value = utf8_encode($value);

		  $convertedArray[$key] = $value;
		  //echo "<br>".$value;
		}
		return $convertedArray;
	}

	public function insertar_archivo($campos) {
	//print_r($columnas);
  	$datos = array_intersect_key($campos, $this->campo_col); //retorna las keys de la variable $campo
	

	$this->pdo->beginTransaction();
 	$oper1 = $this->pdo->_insert('a001t_historico_dato', $datos);

	if($oper1==1 )
	{
		$this->pdo->commit(); return true;

	}
	else
	{
		 $this->pdo->rollback(); return $oper1;
	}  
  } 
	
	public function mostrar_archivo($start, $limit)
	{  
		$reiniciar_id= "ALTER TABLE a001t_historico_dato AUTO_INCREMENT=1";
		
		$arregloLista = $this->pdo->_query($reiniciar_id);
		
		$sql="SELECT * FROM a001t_historico_dato LIMIT $start, $limit";
		
		$arregloLista = $this->pdo->_query($sql);
		
		return $arregloLista;
	}
	
	public function contar_registros()
	{   
		$sql="SELECT * FROM a001t_historico_dato";
		$arregloLista = $this->pdo->_query($sql);
		$cuenta= count($arregloLista);
		return $cuenta;
	}
	/*
	public function insertar_datos_archivo($documento)
	{  
		$this->pdo->beginTransaction();
		$resultado = $this->pdo->_insert('a007t_archivos', array('nb_archivo'=>$documento)); 
		
		if($resultado == 1)
		{
			$this->pdo->commit(); 
			$resp['success'] = 1;
			$resp['mensaje'] = 'Datos guardados ';
		}
		else{
			 $this->pdo->rollback();  
			$resp['success'] = 0;
			$resp['mensaje'] = 'Error al insertar';
		}
		return $resp;
	}*/
}
?>
