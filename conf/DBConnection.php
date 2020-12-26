<?php
class dbConnection {		
			 
	var $db;	
	var $host;
	var $port;
	var $database;
	var $user;
	var $password;
	var $isnodeuser;
	var $connectString;
    var $config;
    
	public function __construct($dbuser = 'webuser') {
		try
		{
			//$dbconfig = parse_ini_file("config.ini");
            include_once("Cryptic.php");
            
			$this->host = $config['host'];
			$this->port = $config['port'];
			$this->database = $config['database'];
			if($dbuser == 'node')
			{
				$this->user = $config['nodeuser'];
				$this->password = $config['nodeuser_password'];
			}
			else if($dbuser == 'webuser')
			{
				$this->user = $config['user'];
				$this->password = $config['password'];			
			}
			else if($dbuser == 'workflow')
			{
				$this->user = $config['workflowuser'];
				$this->password = $config['workflow_password'];			
			}

			$GLOBALS['service_root'] = $config['service_root'];
				
			$this->connectString = 'host=' . $this->host . ' port=' . $this->port . ' dbname=' . $this->database . ' user=' . $this->user . ' password=' . $this->password;	
            
            $this->db =  pg_connect($this->connectString);			
		}
		catch(Exception $e)
		{
		    die($e->getMessage());
		} 	
	}	
	
	function query($query, $send_assoc=null) {
          if (!pg_prepare('my_query', $query)) {
            die("Can't prepare '$query': " . pg_last_error());
          }
          
		  $result = pg_query($this->db, $query) or die ("invalid query");
          if(isset($send_assoc))
          {
            $data = array();
            while($row = pg_fetch_assoc($result)) {
    		   $data[] = $row;		   
    		}
            return $data;
          }	
          else	  
		      return $result;
	}

	function fetch($query) {
		$data = array();
		$this->db = pg_connect ($this->connectString) or die ("Unable to connect to Database Server");
		$result = $this->query($query);
        //$result = pg_query($this->db, $query) or die ("invalid query");

		while($row = pg_fetch_assoc($result)) {
		   $data[] = $row;		   
		}

		pg_close($this->db);
		return $data;
	} 
    
    function execute($query) {
		$data = array();
		$this->db = pg_connect ($this->connectString) or die ("Unable to connect to Database Server");
		//$result = $this->query($query);
        
        if (!pg_prepare('my_query', $query)) {
            die("Can't prepare '$query': " . pg_last_error());
        }
        $result = pg_execute('my_query', $data);

		while($row = pg_fetch_assoc($result)) {
		   $data[] = $row;		   
		}

		pg_close($this->db);
		return $data;
	}
}
?>