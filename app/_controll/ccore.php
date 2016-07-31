<?php 
class ccore{
	protected $fpdo; 
	public function __construct(){
		$this->fpdo = new spdo();
		$qk = $this->fpdo->xquery("select * from mstr_item");
		print_r($qk);
		
	}
	protected function load($path,$data = false){
		$path = realpath(__DIR__ . '/..')."/_view/$path.php";
		if($data != false) extract($data);
		if(file_exists($path) && is_readable($path)){
			//Require the file
			ob_start();
			require($path);
			// Return the string
			$strView = ob_get_contents();
			ob_end_clean();
			print_r($strView);
		}
        else{
           echo "error";
		}
	}
	protected function partrender($path,$data = false){
		$path = realpath(__DIR__ . '/..')."/_view/$path.php";
		if(file_exists($path) && is_readable($path))
            include $path;
          else
            die;
		
	}
	/**
     *  clone will not duplicate object
    */
    public function __clone() 
    {

        die(__CLASS__ . ' class cant be instantiated.');

    }
}
?>