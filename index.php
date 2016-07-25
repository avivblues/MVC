<?php 
//error_reporting(E_ALL && ~E_NOTICE);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
ob_start("ob_gzhandler");
$path = dirname(__FILE__);
require($path.'/Autoloader.class.php');
Autoloader::setCacheFilePath($path .'/class_path_cache.txt');
Autoloader::excludeFolderNamesMatchingRegex('/^CVS|\..*$/');
Autoloader::setClassPaths(array(
    $path . '/app/',
));
spl_autoload_register(array('Autoloader', 'loadClass'));
if(class_exists($_GET['r'])){
	// Go to controller,.,.
	$ccontroll = new $_GET['r'];
	if(isset($_GET['fnc']))	$prm = explode("/",$_GET['fnc']); else $prm = "-";$xclass = $prm[0];
	if(method_exists($ccontroll,$xclass)){
		//$ccontroll->indexhome("vdemo");
		call_user_func_array(array($ccontroll, $xclass), array($prm,$_POST));
	}else{echo "Method not found !!";}
}else{
header("location:404.html");
//echo "masuk";
}
ob_end_flush();
?>
