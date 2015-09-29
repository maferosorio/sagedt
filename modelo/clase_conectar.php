<?php
class conexion{
	private $servidor = 'localhost';
	private $usuario='root';
	private $pass= '123456';
	private $base_de_datos = 'sistema';
	private $conectar;
	private $resultado;

	/*public function __construct($servidor, $usuario, $pass, $base_de_datos){
		$this -> servidor = $servidor;
		$this -> usuario = $usuario;	
		$this -> pass = $pass;
		$this -> base_de_datos = $base_de_datos;
		$this -> conectarse_base_datos();
	}*/
	public function conectarse_base_datos(){
		$this -> conectar = mysql_connect($this -> servidor, $this -> usuario, $this -> pass) or die("Error al conectar");
		mysql_select_db($this -> base_de_datos, $this -> conectar) or die("Error al seleccionar la BD");
		return $this -> conectar;
	}
}
	/*if(!isset($base_de_datos))
	{
		$base_de_datos = new conexion("localhost", "root", "123456", "sistema");
		//echo "Se conecto a la BD <br>";
		
		 
	}*/
	
?>
