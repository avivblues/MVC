<?php
 /*
 * File Name: crudpdo.php
 * Date: August 29 2015
 * Author: M.aviv S.
 * email : avivblues@gmail.com
 */
if(defined('__NOT_DIRECT')){
	/*
		not authorized for direct access file
	*/
	die('not authorized action!!');
}
class cpdo{
    protected static $_instance;
    final private function __construct() {}
    /*
	Get an instance of the Database
	@return Instance
	*/
	public static function instance(){
	    if (!(self::$_instance)) {
		    $cnfg = parse_ini_file("config/dbconfig.ini");
			$dns = $cnfg['engine'].':host='.$cnfg['host'].';dbname='.$cnfg['database'];
			try {
				self::$_instance = new PDO($dns,$cnfg['user'],$cnfg['pass']); 
			 	self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				echo 'Connected </br>';
	        } catch (PDOException $e) {
	    		print "Error PDO : " . $e->getMessage() . "<br/>";die();
			}
	      
	    }
	    return self::$_instance;
	}
   	/*
    * Selects information from the database.
    */
	public static function select($tabel,$rows, $where = null, $order = null, $limit= null){
	    $command = 'SELECT '.$rows.' FROM '.$tabel;
        if($where != null) $command .= ' WHERE '.$where;
        if($order != null) $command .= ' ORDER BY '.$order;            
        if($limit != null) $command .= ' LIMIT '.$limit;
		$query = self::instance()->prepare($command);
		$query->execute();
		$posts = array();
		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			 $posts[] = $row;
		}
		//echo $command;
		return json_encode($posts);
		//return $this->result = $command;
	}
    /**
     *  clone will not duplicate object
    */
    public function __clone() 
    {

        die(__CLASS__ . ' class cant be instantiated.');

    }
	/*
    * Insert values into the table
    */
	public function insert($rows=null){
		$command = 'INSERT INTO '.$this->table;
		$row = null; $value=null;
		foreach ($rows as $key => $nilainya){
		  $row	.=",".$key;$value .=", :".$key;
		}	
		$command .="(".substr($row,1).")";$command .="VALUES(".substr($value,1).")";
		$stmt =  self::prepare($command);$stmt->execute($rows);$rowcount = $stmt->rowCount();
		return $this->result = $rowcount;
	}
	/* 	MultiInsert for isert multi data
		@param 	$table 	= destination table
				$data		= data in array
	*/
	public function MultiInsert($data,$xtabel){
		$rowsSQL = array();$toBind = array();$columnNames = array_keys($data[0]);
		//Loop through our $data array.
		foreach($data as $arrayIndex => $row){
			$params = array();
			foreach($row as $columnName => $columnValue){
				$param = ":" . $columnName . $arrayIndex;
				$params[] = $param;$toBind[$param] = $columnValue; 
			}
			$rowsSQL[] = "(" . implode(", ", $params) . ")";
		}
		//Construct our SQL statement
		$sql = "INSERT INTO ".$xtabel." (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);
	 	//Prepare our PDO statement.
		$pdoStatement = self::prepare($sql);
		//Bind our values.
		foreach($toBind as $param => $val){
			$pdoStatement->bindValue($param, $val);
		}
		//Execute our statement (i.e. insert the data).
		return $this->result = $pdoStatement->execute();
	}
	/*
    * Delete records from the database.
    */
	public function delete($tabel,$where=null){
		$command = 'DELETE FROM '.$tabel;
		$list = Array(); $parameter = null;
		foreach ($where as $key => $value) 
		{
		  $list[] = "$key = :$key";$parameter .= ', ":'.$key.'":"'.$value.'"';
		} 
		$command .= ' WHERE '.implode(' AND ',$list);
	    $json = "{".substr($parameter,1)."}";$param = json_decode($json,true);
		$query = self::prepare($command);$query->execute($param);
		$rowcount = $query->rowCount();return $this->result = $rowcount;
	}
	/*
    * Update Record
    */
	public function update($tabel,$fild = null,$where = null){
		 $update = 'UPDATE '.$tabel.' SET ';
		 $set=null; $value=null;
		 foreach($fild as $key => $values)
		 {
			$set .= ', '.$key. ' = :'.$key;
			$value .= ', ":'.$key.'":"'.$values.'"';
		 }
		 $update .= substr(trim($set),1);
		 $json = '{'.substr($value,1).'}';
		 $param = json_decode($json,true);
		 
		 if($where != null)
		 {
		    $update .= '  WHERE '.$where;
		 }
		 $query = self::prepare($update);
		 //return $update;
		 $query->execute($param);
		 $rowcount = $query->rowCount();
         return $this->result = $rowcount; //$rowcount;
    }
	/* 
		update for concat value's of fields
	*/
	public function updateconcat($field = null ,$where = null){
		 $update = 'UPDATE '.$this->tabel.' SET ';
		 $set=null; $value=null;
		 foreach($field as $key => $values)
		 {
			$set .= ', '.$key. ' = concat('.$key.', '.':'.$key.')';
			$value .= ', ":'.$key.'":"'.$values.'"';
		 }
		 $update .= substr(trim($set),1);
		 $json = '{'.substr($value,1).'}';
		 $param = json_decode($json,true);
		 
		 if($where != null)
		 {
		    $update .= ' WHERE '.$where;
		 }
		 //("UPDATE table SET name = concat(name, ',', :name) WHERE id = :id");
		 $query = self::prepare($update);
		 //return $update;
		 $query->execute($param);
		 $rowcount = $query->rowCount();
         return $this->result = $rowcount;
    }
	
	/* 	custom pdo query for fetch rows result
		@param $sql = query
		@return true for successfully submit
	*/
	public function cquery($command){
		$sq = self::query($command);
		$posts = array();
		while($row = $sq->fetch(PDO::FETCH_ASSOC)){
			 $posts[] = $row;
		}
		return $this->result = json_encode($posts);
	}
	public function CRUDtable($sql){
		$sq = self::query($sql);
		if ($sq){
			$this->result = '1';
		}else{
			$this->result = $sq;
		}
		//return $sql;
	}
	/*	Insert new record from another table row
		@param 	$to 	= destination table
				$from	= source table
				$fieldto= destination field
			$fieldfrom	= source field
			$where 		= condition without 'where' command
	*/
	public function copyduplicate($tableto,$tablefrom,$fieldto,$fieldfrom, $where=null){
		$command = 'INSERT INTO '.$tableto.' ('.$fieldto.')'.'SELECT '.$fieldfrom.' FROM '.$tablefrom; 
		if($where != null){
            $command .= ' WHERE '.$where;
		}
		$send = self::exec($command);
		if ($send) return $this->result = true; else return $this->result = $send;
	}
    /* 	Count record
		@param $from = table
		return number of rows
	*/
    public function countrows($where=null){
		$command = "SELECT count(*) as 'hasil' FROM ".$this->tabel; 
		if($where != null){
            $command .= ' WHERE '.$where;
		}
		$this->cquery($command);
    }
	public function existtable(){
		$command = "SELECT 1 FROM " .$this->tabel. " LIMIT 1"; 
		$test = self::query($command);
		if($test){
			return $this->result = 1; //Table exists
		}else{
			return $this->result = 0; //No table in database
		}
	}
	public function gettablelist(){
		$comm = "SHOW TABLES";
		return $comm;
		//$this->cquery($comm);
	}
	public function countcharinstring($field,$where=null){
		$command = "select LENGTH(".$field.") - LENGTH(REPLACE(".$field.", '.', '')) as 'hasil' from ".$this->tabel;
		if($where != null){
            $command .= ' WHERE '.$where;
		}
		$this->cquery($command);
	}
	public function getnamerows($table){
		$connt = mysqli_connect($this->host,$this->user,$this->pass,$this->database);
		// if (mysqli_connect_errno()) {
			// die('Connect Error: '.$mysqli->connect_error);
		// }
		if ($connt->connect_error) {
			die('Connect Error, '. $connt->connect_errno . ': ' . $connt->connect_error);
		}
		$command = "SHOW COLUMNS FROM ".$table;
		$result = mysqli_query($connt,$command) or die(mysql_error());
		$aa = array();
		while($row = mysqli_fetch_array($result)) {
		   $aa[] = $row;
		}
		return $this->result = json_encode($aa);
		//mysqli_close($connt);
	}
	public function gettablecolumn($tabel){
		$sq = self::prepare("DESCRIBE ".$tabel);
		$sq->execute();$posts = array();
		while($row = $sq->fetch(PDO::FETCH_COLUMN)){$posts[] = $row;}
		return $this->result = json_encode($posts);
	}
}
?>