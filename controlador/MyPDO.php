<?php session_start();
require_once 'Monitor.php';

/**
 * class MyPDO
 * 
 */
class MyPDO extends PDO
{

   /*** Attributes: ***/
	private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
	//private $conexion;

 /*** Attributes: ***/

  /**

   * @sin param 

   * @return link coneccion
   * @access public
   */
 
    var  $pdo; 
    public  $monitor;

    public function __construct($pdo=NULL){
	 if ($pdo==NULL){
        $this->engine = 'mysql';
		$this->host = 'localhost';
		$this->port = '';
		$this->database =  'sistema'; //'condomkg_condominiosvzla'; 
		$this->user = 'mafer';  //'condomkg_publico'; 
		$this->pass = 'mafer';
		$dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
		
		try {
      		parent::__construct( $dns, $this->user, $this->pass );
		} catch (PDOException $e) {
			echo 'Conexin Fallida: <br/> Ha ocurrido un error al intentar establecer conexion con el servidor. Por favor contacte con el administrador o custodio de esta aplicacin para notificarle acerca de este error. '. $e->getMessage();
			exit;
		}
	    $this->pdo= $this;
		$this->reg_padre=NULL;
		$this->reg_padre_detalle=NULL;
	  }
	    else{
		$this->pdo = $pdo;
		$this->reg_padre[$this->cont]=$pdo->reg_padre[$pdo->cont];
	 }
	// $this->monitor = new Monitor($this->pdo);
    }
	 /**
   * 
   *
   * @param string co_rif_empresa, co_reset, campos claves para realizar la busqueda de una Monitor en particular 

      * @return  Array con todos los valores de la Monitor buscada.
	  			   si no consigue la Monitor devuelve un array vacio.
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access private
   */
   public function Attach(Monitor $monitor) {
  		//$this->pdo->monitor=$monitor;
		$this->monitor=$monitor;
}
 /**
   * 
   *
   * @param string co_rif_empresa, co_reset, campos claves para realizar la busqueda de una Monitor en particular 

      * @return  Array con todos los valores de la Monitor buscada.
	  			   si no consigue la Monitor devuelve un array vacio.
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access private
   */
   public function Notify($descripcion) { 
  		return $r = $this->pdo->monitor->insertarMonitor(array('co_cedula'=>$_SESSION['cedula'], 'fe_transaccion'=>date('Y-m-d H:i:s'), 'tx_descripcion'=>$descripcion));
} 
 /**
   * 
   *
   * @param string co_rif_empresa, co_reset, campos claves para realizar la busqueda de una Monitor en particular 

      * @return  Array con todos los valores de la Monitor buscada.
	  			   si no consigue la Monitor devuelve un array vacio.
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access private
   */
   public function pushNotify($Method) { 
  		if(is_object($this->pdo->monitor))
	    	$this->pdo->monitor->pushRegPadre($this->pdo->Notify($Method)); //Notificar metodo en la posicion reg_padre));
} 
// end of member function insertarMonitor
 /**
   * 
   *
   * @param string co_rif_empresa, co_reset, campos claves para realizar la busqueda de una Monitor en particular 
      * @return  Array con todos los valores de la Monitor buscada.
  			   si no consigue la Monitor devuelve un array vacio.
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access private
   */
   public function popNotify() { 
  		if(is_object($this->pdo->monitor))
	    	$this->pdo->monitor->popRegPadre(); // Libera posicion reg_padre
} 
// end of member function insertarMonitor
	/**
   * 
   * @param string $tabla nombre de la tabla de base de datos donde se desea insertar
                  array $atributos vector con los valores de los atributos q se desean insertar, los indices del vector deben ser igualal nombre del campo en la BD 
				  
   * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access privado
   */
	protected function _insert($tabla, $atributos){
		$comillas = "";
	    $columnas = array_keys($atributos);
		$insert = "INSERT INTO ".$tabla." (";
		for($i=0 ; $i< count($columnas); $i++)
			$insert .= ($i+1 == count($columnas)) ? $columnas[$i].") VALUES (" : $columnas[$i].", ";
				
		for($i=0 ; $i< count($atributos); $i++){
			$comillas = ((substr_count($atributos[$columnas[$i]], '$-'))>=1) ? "" : "'";
			if((substr_count($atributos[$columnas[$i]], '$-'))>=1) $atributos[$columnas[$i]] = str_replace("$-","", $atributos[$columnas[$i]]); 

			$insert .= ($i+1 == count($atributos)) ? $comillas.$atributos[$columnas[$i]].$comillas.");" : $comillas.$atributos[$columnas[$i]].$comillas.", ";

		}
			//echo $insert;
			$r = $this->pdo->exec($insert);
			$error = $this->pdo->errorInfo();
			if(is_object($this->pdo->monitor))
					$this->pdo->Notify($error[2]." - ".$insert, 'detalle');
			if($r == NULL)
					return  get_class($this)." - ".__METHOD__." - ".$error[2]."\n";
			else				
				return $r;
	}
	/**
   * 
   *
   * @param string $tabla nombre de la tabla de base de datos donde se desea modificar
                  array $atributos vector con los valores de los atributos q se desean modificar, los indices del vector deben ser igual al nombre del campo en la BD 
				  array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el alor q debe cumplir el campo para ser modificado

			  

     * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access public
   */
	protected function _update($tabla, $atributos, $condiciones){
	
		$columnas = array_keys($atributos);
		$columCond = array_keys($condiciones);
		$update = "UPDATE ".$tabla." SET ";
		for($i=0 ; $i< count($columnas); $i++)
			$update .= ($i+1 == count($columnas)) ? $columnas[$i]."='".$atributos[$columnas[$i]]."'" : $columnas[$i]."='".$atributos[$columnas[$i]] ."', ";
		if(is_array($condiciones)){
			$update .= ' WHERE ';
			for($i=0 ; $i< count($condiciones); $i++)
				$update .= ($i+1 == count($condiciones)) ? $columCond[$i]."='".$condiciones[$columCond[$i]]."';" : $columCond[$i]."='".$condiciones[$columCond[$i]] ."' AND ";
		}
		//echo $update;
		$r = $this->pdo->exec($update);
		$error = $this->pdo->errorInfo(); //print_r($error);
		if(is_object($this->pdo->monitor))
					$this->pdo->Notify($error[2]." - ".$update, 'detalle');
		if(isset($error[2])){
			return  get_class($this)." - ".__METHOD__." - ".$error[2]."\n";
		}
		else
			return true;
	}
/**
   * 
   *
   * @param string $tabla nombre de la tabla de base de datos donde se desea modificar
                  array $atributos vector con los valores de los atributos q se desean modificar, los indices del vector deben ser igual al nombre del campo en la BD 
				  array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el alor q debe cumplir el campo para ser modificado

			  

     * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access public
   */
	protected function _updatePlus($tabla, $atributos, $condiciones, $signos){
	
		$columnas = array_keys($atributos);
		$columCond = array_keys($condiciones);
		$update = "UPDATE ".$tabla." SET ";
		for($i=0 ; $i< count($columnas); $i++)
			$update .= ($i+1 == count($columnas)) ? $columnas[$i]."='".$atributos[$columnas[$i]]."'" : $columnas[$i]."='".$atributos[$columnas[$i]] ."', ";
		if(is_array($condiciones)){
			$update .= ' WHERE ';
			for($i=0 ; $i< count($condiciones); $i++)
				$update .= ($i+1 == count($condiciones)) ? $columCond[$i]."".$signos[$i]."'".$condiciones[$columCond[$i]]."';" : $columCond[$i]."".$signos[$i]."'".$condiciones[$columCond[$i]] ."' AND ";
		}
		//echo $update;
		$r = $this->pdo->exec($update);
		$error = $this->pdo->errorInfo(); //print_r($error);
		if(is_object($this->pdo->monitor))
					$this->pdo->Notify($error[2]." - ".$update, 'detalle');
		if(isset($error[2])){
			return  get_class($this)." - ".__METHOD__." - ".$error[2]."\n";
		}
		else
			return true;
	}
	/**
   * 
   *
   * * @param string $tabla nombre de la tabla de base de datos donde se desea modificar
                     array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el valor q debe cumplir el campo para ser modificado
	

     * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access public
   */
	protected function _delete($tabla, $condiciones){ 
		$columCond = array_keys($condiciones);
		$delete = "DELETE FROM ".$tabla;
	
	if(is_array($condiciones)){
			$delete .= ' WHERE ';

			for($i=0 ; $i< count($condiciones); $i++)

				$delete .= ($i+1 == count($condiciones)) ? $columCond[$i]."='".$condiciones[$columCond[$i]]."';" : $columCond[$i]."='".$condiciones[$columCond[$i]] ."' AND ";

		}
		//echo $delete;
		$r = $this->pdo->exec($delete);
		$error = $this->pdo->errorInfo();
		if(is_object($this->pdo->monitor))
					$this->pdo->Notify($error[2]." - ".$delete, 'detalle');
		if($error[2]){
			return  get_class($this)." - ".__METHOD__." -  ".$error[2]."\n";
		}
		else
			return true;
		}
		/**
   * 
   *
   * * @param string $tabla nombre de la tabla de base de datos donde se desea modificar

                     array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el valor q debe cumplir el campo para ser modificado
	

     * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 

				   
   * @access public
   */
	protected function _query($query, $notify=true){
		if(is_object($this->pdo->monitor) && $notify)
			$this->pdo->Notify($query, 'detalle');
		$r = $this->pdo->query($query);
		
		 if($r!=NULL){
	  		$result = $r->fetchALL(PDO::FETCH_ASSOC);
			return $result;
		} 
		else{
			$error = $this->pdo->errorInfo();
			return $error[2];
		}
	}
		/**
   * 
   *
   * * @param string $tabla nombre de la tabla de base de datos donde se desea modificar
                     array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el valor q debe cumplir el campo para ser modificado

     * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
   * @access public
   */
	protected function _queryBind($query, $campo, $notify=true){
		$aux=NULL;
		if(is_object($this->pdo->monitor) && $notify)
			$this->pdo->Notify($query, 'detalle');
		$r = $this->pdo->query($query);
		 if($r!=NULL){
		 	$r->bindColumn($campo, $aux, PDO::PARAM_STR);
	  		$result = $r->fetch(PDO::FETCH_BOUND);
			return $aux;
		} 
		else{
			$error = $this->pdo->errorInfo();
			return $error[2];
		}
	}
	/**
   * 
   *
   * * @param string $tabla nombre de la tabla de base de datos donde se desea modificar
                     array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el valor q debe cumplir el campo para ser modificado
	

     * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access public
   */
public function decode_chartset($chartset, $a){
		foreach($a as $key=>$val)
			if(is_array($val))
				$r[$key]=$this->decode_chartset($chartset, $val);
			else
				 $r[$key]=htmlentities($val);
		return $r;
	}
	/**
  * 
   *
   * * @param string $tabla nombre de la tabla de base de datos donde se desea modificar
                     array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el valor q debe cumplir el campo para ser modificado
	

     * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access public
   */
	function recursiveArraySearchAll($haystack, $needle, $index = null)
{
    $aIt     = new RecursiveArrayIterator($haystack);
    $it    = new RecursiveIteratorIterator($aIt);
    $resultkeys;
                       
    while($it->valid()) {       
    if (((isset($index) AND ($it->key() == $index)) OR (!isset($index))) AND (strpos($it->current(), $needle)!==false)) { //$it->current() == $needle
    $resultkeys[]=$aIt->key(); //return $aIt->key();
    }
                           
    $it->next();
    }
    return $resultkeys;  // return all finding in an array
                       
} 

function multidimensional_search($parents, $searched) {
  if (empty($searched) || empty($parents)) {
    return false;
  }
 
  foreach ($parents as $key => $value) {
    $exists = true;
    foreach ($searched as $skey => $svalue) {
      $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);

    }
    if($exists){ return $key; }
  }
 
  return false;
}

 public function sortByOneKey(array $array, $key, $asc = true) {
    $result = array();
       
    $values = array();
    foreach ($array as $id => $value) {
        $values[$id] = isset($value[$key]) ? $value[$key] : '';
    }
       
    if ($asc) {
        asort($values);
    }
    else {
        arsort($values);
    }
   $i=0;    
    foreach ($values as $key => $value) {
        $result[$i] = $array[$key];
		$i++;
    }
       
    return $result;
}

  /*******************************************************/
function getParentStackComplete($child, $stack) {
    $retorno = array();

	//print_r($stack);
    foreach ($stack as $k => $v) {
        if (is_array($v)) {
            // If the current element of the array is an array, recurse it
            // and capture the return stack
            $stack = $this->getParentStackComplete($child, $v);
           
            // If the return stack is an array, add it to the return
            if (is_array($stack) && !empty($stack)) {
                $retorno[$k] = $stack;
            }
        } else {
            // Since we are not on an array, compare directly
            if ($v == $child) {
                // And if we match, stack it and return it
                $retorno[$k] = $child;
            }
        }
    }
   
    // Return the stack
    return empty($retorno) ? false : $retorno;
}
/**********************************************************/

function sumArray($array, $params = array('direction' => 'x', 'key' => 'xxx'), $exclusions = array()) {

    if(!empty($array)) {
   
        $sum = 0;
   
        if($params['direction'] == 'x') {
       
            $keys = array_keys($array);
           
            for($x = 0; $x < count($keys); $x++) {
           
                if(!in_array($keys[$x], $exclusions))
                    $sum += $array[$keys[$x]];
           
            }
           
            return $sum;
       
        } elseif($params['direction'] == 'y') {
       
            $keys = array_keys($array);
       
            if(array_key_exists($params['key'], $array[$keys[0]])) {
           
                for($x = 0; $x < count($keys); $x++) {
               
                    if(!in_array($keys[$x], $exclusions))
                        $sum += $array[$keys[$x]][$params['key']];
                   
                }
                   
                return $sum;
           
            } else return false;
       
        } else return false;
   
    } else return false;

}



  /**
   * 
   *
   * * @param string $tabla nombre de la tabla de base de datos donde se desea modificar
                     array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el valor q debe cumplir el campo para ser modificado
	

     * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access public
   */
  public function filtrarQuery($filter) {	
	$where = "";
	if (is_array($filter)) {	
		for ($i=0;$i<count($filter);$i++){
      //echo '<br>'.$filter[$i]['type'].'<br>';
      $tipo = $filter[$i]['type'];
			switch($tipo){
				case 'string' : 
					switch ($filter[$i]['comparison']) {
						case 'ne' : 
							$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." NOT LIKE '%".$filter[$i]['value']."%'"; 
						break;
						default:
							$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." LIKE '%".$filter[$i]['value']."%'"; 
					}				
				break;
				case 'list' : 
					if (strstr($filter[$i]['value'],',')){
						$fi = explode(',',$filter[$i]['value']);
						for ($q=0;$q<count($fi);$q++){
							$fi[$q] = "'".$fi[$q]."'";
						}
						$filter[$i]['value'] = implode(',',$fi);
						$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." IN (".$filter[$i]['value'].")"; 
					}else{
						$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." = '".$filter[$i]['value']."'"; 
					}
				break;
				case 'boolean' : 
					$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." = ".($filter[$i]['value']); 
				break;
				case 'numeric' : 
					switch ($filter[$i]['comparison']) {
						case 'eq' : 
							$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." = ".$filter[$i]['value']; 
						break;
						case 'lt' : 
							$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." < ".$filter[$i]['value']; 
						break;
						case 'gt' : 
							$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." > ".$filter[$i]['value']; 
						break;
					}
				break;
				case 'date' : 
					switch ($filter[$i]['comparison']) {
						case 'eq' : 
							$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." LIKE '".date('Y-m-d',strtotime($filter[$i]['value']))."%'"; 
						break;
						case 'lt' : 

						$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." < '".date('Y-m-d',strtotime($filter[$i]['value']))."'"; 
						break;
						case 'gt' : 
							$qs .= " AND ".$this->columFiltros[$filter[$i]['field']]." > '".date('Y-m-d',strtotime($filter[$i]['value']))."'"; 
						break;
					}
				break;
			}
		}	
		$where .= $qs;
	}  
	return $where;
  }
  } // end of member function cargarConductores// end of MyPDO
?>
