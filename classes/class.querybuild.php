<?
/**
 * 
 */
class querybuild
{	
	function __construct()
	{

	}

	/**
	*	Limpia la entrada de datos POST, elimnando del array los valores no machan con la tabla en base de datos
	*/

	function cleanPost($ignoreFields = array("PHPSESSID", "type", "method", "confirm_pass")){
	    $result = array();

	    while(list($key, $value) = each($_POST)){
	        if(!in_array($key, $ignoreFields))
	            $result[$key] = $_POST[$key];
	    }
	    
	    $this->fields = $result;
	}

	/**
	*	Agrega registro a la base de datos
	*   recibe el parametro tabla
	*   la entrada de datos es recibida por el Array POST, debe equivaler a los campos en la base de datos
	*/

	function add($table){
		$this->cleanPost();

	    $keys = "";
	    $values = "";

	    while(list($key, $value) = each($this->fields)){
	        $keys .= $key . ",";
	        $value = str_ireplace("'","&#039;", $value);
	        $value = "'{$value}'";
	        $values .=  $value . ",";
	    }       
	    
	    $keys = substr($keys, 0, strlen($keys) - 1);
	    $values = substr($values, 0, strlen($values) - 1);
	    $sql = "insert into {$table}({$keys}) values({$values})";

	    return $sql;
	}


	/**
	*	Actualiza el registro en la base de datos
	*   recibe el parametro tabla y el parametro $id utilizado para la actualización
	*   la entrada de datos es recibida por el Array POST, debe equivaler a los campos en la base de datos
	*/

	function update($id, $table){
		$this->cleanPost();

		if(!is_numeric($id))
			return false;
		
		$values = "";
		$values2 = "";
		
		$id_field = "id_{$table}";
		
		while(list($key, $value) = each($this->fields)){
			$value = str_ireplace("'","&#039;",$value);
			
			$values .= "{$key} = '{$value}', ";
		}
		
		$values = substr($values, 0, strlen($values) - 2);
		$sql = "update $table set {$values} where {$id_field} = {$id}";

		return $sql;
	}		
}