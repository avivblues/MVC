<?php
 /*
 * File Name: crudpdo.php
 * Date: July 25 2016
 * Author: M.aviv S.
 * email : avivblues@gmail.com
 */
 //https://gist.github.com/tony-landis/31464
if(defined('__NOT_DIRECT')){
    /*
        not authorized for direct access file
    */
    die('not authorized action!!');
}
class spdo 
{  
    /**
     * The singleton instance
     * 
     */
    static private $_instance; 
     
  	public function __construct() 
    {
        if(!self::$_instance) { 
	        try {
                $cnfg = parse_ini_file("config/dbconfig.ini");
                $dns = $cnfg['engine'].':host='.$cnfg['host'].';dbname='.$cnfg['database'];
			    self::$_instance = new PDO($dns,$cnfg['user'],$cnfg['pass']); 
                self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) { 
			   die("PDO CONNECTION ERROR: " . $e->getMessage() . "<br/>");
			}
    	}
      	return self::$_instance;    	    	
    }
	 
  	/**
  	 * Initiates a transaction
  	 *
  	 * @return bool
  	 */
	public function beginTransaction() {
		return self::$_instance->beginTransaction();
	}
        
	/**
	 * Commits a transaction
	 *
	 * @return bool
	 */
	public function commit() {
		return self::$_instance->commit();
	}
	
	/**
	 * Fetch the SQLSTATE associated with the last operation on the database handle
	 * 
	 * @return string 
	 */
    public function errorCode() {
    	return self::$_instance->errorCode();
    }
    
    /**
     * Fetch extended error information associated with the last operation on the database handle
     *
     * @return array
     */
    public function errorInfo() {
    	return self::$_instance->errorInfo();
    }
    
    /**
     * Execute an SQL statement and return the number of affected rows
     *
     * @param string $statement
     */
    public function exec($statement) {
    	return self::$_instance->exec($statement);
    }
    
    /**
     * Retrieve a database connection attribute
     *
     * @param int $attribute
     * @return mixed
     */
    public function getAttribute($attribute) {
    	return self::$_instance->getAttribute($attribute);
    }

    /**
     * Return an array of available PDO drivers
     *
     * @return array
     */
    public function getAvailableDrivers(){
    	return Self::$_instance->getAvailableDrivers();
    }
    
    /**
     * Returns the ID of the last inserted row or sequence value
     *
     * @param string $name Name of the sequence object from which the ID should be returned.
     * @return string
     */
	public function lastInsertId($name) {
		return self::$_instance->lastInsertId($name);
	}
        
   	/**
     * Prepares a statement for execution and returns a statement object 
     *
     * @param string $statement A valid SQL statement for the target database server
     * @param array $driver_options Array of one or more key=>value pairs to set attribute values for the PDOStatement obj 
returned  
     * @return PDOStatement
     */
    public function prepare ($statement, $driver_options=false) {
    	if(!$driver_options) $driver_options=array();
    	return self::$_instance->prepare($statement, $driver_options);
    }
    
    /**
     * Executes an SQL statement, returning a result set as a PDOStatement object
     *
     * @param string $statement
     * @return PDOStatement
     */
    public function query($statement) {
    	return self::$_instance->query($statement);
    }
    
    /**
     * Execute query and return all rows in assoc array
     *
     * @param string $statement
     * @return array
     */
    public function queryFetchAllAssoc($statement) {
    	return self::$_instance->query($statement)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Execute query and return one row in assoc array
     *
     * @param string $statement
     * @return array
     */
    public function queryFetchRowAssoc($statement) {
    	return self::$_instance->query($statement)->fetch(PDO::FETCH_ASSOC);    	
    }
    
    /**
     * Execute query and select one column only 
     *
     * @param string $statement
     * @return mixed
     */
    public function queryFetchColAssoc($statement) {
    	return self::$_instance->query($statement)->fetchColumn();    	
    }
    
    /**
     * Quotes a string for use in a query
     *
     * @param string $input
     * @param int $parameter_type
     * @return string
     */
    public function quote ($input, $parameter_type=0) {
    	return self::$_instance->quote($input, $parameter_type);
    }
    
    /**
     * Rolls back a transaction
     *
     * @return bool
     */
    public function rollBack() {
    	return self::$_instance->rollBack();
    }      
    
    /**
     * Set an attribute
     *
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    public function setAttribute($attribute, $value  ) {
    	return self::$_instance->setAttribute($attribute, $value);
    }
}
?>