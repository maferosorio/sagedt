<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
require_once 'MyPDO.php';



class formularios extends MyPDO
{

public	function insertarCampos($documento, $turbo)
	{   $this->pdo->beginTransaction();
		$resultado = $this->pdo->_insert('a007t_archivos', array('nb_archivo'=>$documento, 'co_turbocompresor'=>$turbo)); 
		
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
		
		
		
		/*$sql = "INSERT INTO archivos (nb_archivo) ".
        "VALUES ('$documento')";
		$resultado=ejecutar_sql($sql);*/

	}
	
	public function mostrarFormulario()
	{		
		$sql="SELECT * FROM a007t_archivos";
		
		//$resultado=ejecutar_sql($sql);
			
		$arregloLista = $this->pdo->_query($sql);
		/*$arregloLista = array(); 	
		while ($fila=mysql_fetch_object($resultado))
		{ 
			$arregloLista[] = $fila; 	
		}   */	
		return $arregloLista;
	}
	
	/*function ejecutar_sql($sql){

                $resultado = mysql_query($sql);

                if (! $resultado ) {die("ERROR AL EJECUTAR LA CONSULTA: ".mysql_error());}

                return $resultado;

	}*/
	
	/*function conectar_mysql($host,$usuario,$pass,$db)
	{
        $con = mysql_connect($host,$usuario,$pass);
        if(! $con){die ("ERROR AL CONECTAR MYSQL:".mysql_error());}
        $bd = mysql_select_db($db, $con);
         if (! $bd ){die ("ERROR AL CONECTAR CON LA BASE DE DATOS: ".mysql_error() );}
	}*/
}
?>
