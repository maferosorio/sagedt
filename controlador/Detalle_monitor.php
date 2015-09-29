<?php 
require_once 'MyPDO.php';

/**
 * class Detalle_servicio
 * 
 */
class Detalle_monitor extends MyPDO  //WARNING: PHP5 does not support multiple inheritance but there is more than 1 superclass defined in your UML model!
{

  /** Aggregations: */

  /** Compositions: */

   /*** Attributes: ***/

	private $columDetalle_monitor = array('co_transaccion'=>'co_transaccion', 'fe_transaccion'=>'fe_transaccion', 'tx_operacion_bd'=>'tx_operacion_bd', 'co_operacion_bd'=>'co_operacion_bd');


 /**
   * 
   *
   * @param string co_rif_empresa, co_reset, campos claves para realizar la busqueda de una Detalle_servicio en particular 

      * @return  Array con todos los valores de la Detalle_servicio buscada.
	  			   si no consigue la Detalle_Detalle_monitor devuelve un array vacio.
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access private
   */
   public function buscarDetalles_monitor($co_transaccion) {
  	$query = "SELECT 	c011t.* 
				   FROM  	c011t_detalle_monitor as c011t 
				  WHERE    c011t.co_transaccion  = '".$co_transaccion."'";
	$r = $this->pdo->_query($query);
	return $r;
 } // end of member function insertarDetalle_Detalle_monitor
 /**
   * 
   *
   * @param string co_rif_empresa, co_reset, campos claves para realizar la busqueda de una Detalle_Detalle_monitor en particular 

      * @return  Array con todos los datos de los pasajeros y los datos de la Detalle_Detalle_monitor consultada.
	  			   si no consigue la Detalle_Detalle_monitor devuelve un array vacio.
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access private
   */
  public function buscarDetalle_monitor($co_operacion_bd) {
  	$query = "SELECT 	c011t.* 
				   FROM  	c011t_detalle_monitor as c011t 
				  WHERE    c011t.co_operacion_bd  = '".$co_operacion_bd."'";
	$r = $this->pdo->_query($query);
	return $r;
 } // end of member function insertarDetalle_monitor

  /**
   * 
   *
   * @param Array Detalle_monitor  vector con los valores de los atributos de la Detalle_monitor q se desean insertar, los indices del vector deben ser igual al nombre del campo en la BD 
   				  Array pasajeros. vector q contiene las cedulas de los pasajeros de la Detalle_monitor a cargar los indices no influyen
				  string cedula. cadena con la cedula del usuario de sistema q esta realizando la carga de la Detalle_monitor.

      * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access private
   */
   public function insertarDetalle_monitor($detalle_monitor) {
    $detalle_monitor['tx_operacion_bd'] = str_replace("'","", $detalle_monitor['tx_operacion_bd']);
	//$detalle_monitor['co_transaccion'] = substr_replace($detalle_monitor['co_transaccion'], "'", 0);
	//$detalle_monitor['co_transaccion'] = substr_replace($detalle_monitor['co_transaccion'], "'", strlen($var));
  	$detalle_monitor = array_intersect_key($detalle_monitor, $this->columDetalle_monitor);
 	$r = $this->pdo->_insert('c011t_detalle_monitor', $detalle_monitor);
	return $r;  
  } // end of member function insertarDetalle_monitor

  /**
   * 
   *
     * @param  array $columnass vector con los valores de los atributos q se desean modificar, los indices del vector deben ser igual al nombre del campo en la BD 
				     array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el valor q debe cumplir el campo para ser modificado
				     Array pasajeros. vector q contiene las cedulas de los pasajeros de la Detalle_monitor a cargar los indices no influyen
				    string cedula. cadena con la cedula del usuario de sistema q esta realizando la carga de la Detalle_monitor.

      * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access private
   */
  public function actualizarDetalle_monitor($columnas, $condiciones) {
	$columnas = array_intersect_key($columnas, $this->columDetalle_monitor);
  	$r = $this->pdo->_update('c011t_detalle_monitor', $columnas, $condiciones);
	return $r;
  } // end of member function actualizarDetalle_monitor
	
	/**
    * @param   array $condiciones vector con las condiciones de modificacion, indice igual al campo de la tabla y valor igual el valor q debe cumplir el campo para ser modificado
				  

    * @return  true si operacion se realiza con exito 
                   si falla retorna: nombre de la clase y metodo que llama a la function y el error devuelto por el manejador de BD 
				   
   * @access public
   */
   public function eliminarDetalle_monitor( $condiciones ) {
  	$r = $this->pdo->_delete('c011t_Detalle_monitor', $condiciones);
	return $r;
  } // end of member function eliminarConductor


} // end of Detalle_monitor
?>
