<?php
    include("Cryptic.php");
    
	if(!isset($GLOBALS['service_root']))
	{
		//$globalconfig = parse_ini_file("config.ini");
		$GLOBALS['service_root'] = $config['service_root'];
		//$GLOBALS['oai_service_root'] = $config['oai_service_root'];
		//$GLOBALS['app_root'] = $config['app_root'];
	}

?>