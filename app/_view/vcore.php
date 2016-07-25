<?php 
class vcore{

	public function __construct(){
		
	} 
	public function loadrender($path,$data = false, $error = false){
		$path = realpath(__DIR__ . '/..')."/_view/$path.php";
		if($data != false) extract($data);
		if(file_exists($path) && is_readable($path))
           include $path;
        else
           die;
	}
	public function partrender($path,$data = false){
		$path = realpath(__DIR__ . '/..')."/_view/$path.php";
		if(file_exists($path) && is_readable($path))
            include $path;
          else
            die;
		
	}
	
}
?>