<?php
    include("Cryptic.php");
    
	function exception_error_handler($errno, $errstr, $errfile, $errline ) {
		throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
	}
	set_error_handler("exception_error_handler");

	$db;	
	$host;
	$port;
	$user;
	$password;
	$connectString;
	
	try
	{
		//$dbconfig = parse_ini_file("config.ini");
	
		$host = $config['host'];
		$port = $config['port'];
		$db = $config['database'];
		$user = $config['user'];
		$password = $config['password'];
		$connectString = 'host=' . $host . ' port=' . $port . ' dbname=' . $db . ' user=' . $user . ' password=' . $password;
		$conn = pg_connect ($connectString) or die ("Unable to connect to Database Server");		
	}
	catch(Exception $e)
	{
		die($e->getMessage());
	}
?>