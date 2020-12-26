<?php
//$service_url = "http://starr.lk/mis-system/vendor/slim/slim/index.php/";
$service_url = "http://starr.lk/mis-test/vendor/slim/slim/index.php/";
//$service_url = "http://localhost/phase2/vendor/slim/slim/index.php/";
function callService($service_url_part)
{
    $service_root = "";
    $config = "";
    include_once("conf/Cryptic.php");
    
    if(!isset($GLOBALS['z']))
        $GLOBALS['z'] = $config['service_root'];
    //$service_url = $GLOBALS['z'] . $service_url_part;
    $service_url = $GLOBALS['service_url'] . $service_url_part;
    
    $name = mt_rand(10,100);
    $id = mt_rand(100,1000);
    $opts = array( 'http'=>array( 'method'=>"GET",
                  'header'=>"Authorization: Basic " . base64_encode("root:t00r1"),
                   "Cookie: ".$name."=".$id."\r\n" ) );
    
    $context = stream_context_create($opts);
    $response = "";
    
    try {
    //$response = file_get_contents($GLOBALS['service_root'] . $service ,false,$context);
    //echo $service_url;
    $response = file_get_contents($service_url ,false,$context);
    
    } catch(Exception $e) {
        return '{"error":{"text":'. $e->getMessage() .'}}';
    }
    
    return json_decode($response);
    
}

function callService2($service_url_part)
{
    $service_root = "";
    $config = "";
    include_once("conf/Cryptic.php");
    
    if(!isset($GLOBALS['z']))
        $GLOBALS['z'] = $config['service_root'];
    $service_url = $GLOBALS['z'] . $service_url_part;
    
    $name = mt_rand(10,100);
    $id = mt_rand(100,1000);
    $opts = array( 'http'=>array( 'method'=>"GET",
                  'header'=>"Connection: close: en\r\n" .
                   "Cookie: ".$name."=".$id."\r\n" ) );
    
    $context = stream_context_create($opts);
    //session_write_close();   // this is the key
    $response = "";
    try {
    //$response = file_get_contents($GLOBALS['service_root'] . $service ,false,$context);
    $response = file_get_contents($service_url ,false,$context);
    
    } catch(Exception $e) {
        return '{"error":{"text":'. $e->getMessage() .'}}';
    }
    
    return json_decode($response);
    
}
function postService($service_url_part, $postData)
{
    $service_root = "";
    $config = "";
    include_once("conf/Cryptic.php");
    
    if(!isset($GLOBALS['z']))
        $GLOBALS['z'] = $config['service_root'];
    //$service_url = $GLOBALS['z'] . $service_url_part;
    $service_url = $GLOBALS['service_url'] . $service_url_part;
    
    $opts = array('http' => array(
        'method' => "POST",
        'header' =>
            "Content-Type: application/x-www-form-urlencoded\r\n".
            "Authorization: Basic " . base64_encode("root:t00r1"),
        'content' => $postData
    ));

    $context  = stream_context_create($opts);
    
    $response = "";
    
    try {
        $response = file_get_contents($service_url, false, $context);
        
    } catch(Exception $e) {
        return '{"error":{"text":'. $e->getMessage() .'}}';
    }
    
    return $response;
} 

function getSectionAccess($section)
{
    $section_access = array();
    if(isset($_SESSION['access_obj']))
    {
        $access_obj = unserialize($_SESSION['access_obj']);
        
        $access_arr = get_object_vars($access_obj);
        
        if(isset($access_arr[$section]))
            $section_access = $access_arr[$section]; //get given section auth objects
    }
    return $section_access;
}
function GetSectionAccessAuth($section, $access) //used at refresh content
{
    $section_access = getSectionAccess($section);
    $ret_val = false;
    if(isset($section_access->$access))
        $ret_val = ($section_access->$access=='Y' ? true : false);
    return $ret_val;
}

function getUniqAuthorizations($auth_arr)
{
    $uniq_auth_arr = array();
    $permit_granted_arr = array();
    foreach ($auth_arr as $obj) {
        if($obj->value == "Y")
        {
            unset($obj->sys_role_id);
            array_push($permit_granted_arr, $obj);
        }
    }

	//echo'<h3>Before:</h3>';
	//print_r($permit_granted_arr);

	//echo'<h3>After:</h3>';
	$uniq_auth_arr = array_map("unserialize", array_unique(array_map("serialize", $permit_granted_arr)));
    //print_r($uniq_auth_arr);
    
    return $uniq_auth_arr; 
}
function isPermitedFor($needle, $needle_field, $haystack, $strict = false) { 
    if ($strict) { 
        foreach ($haystack as $item) 
            if (isset($item->$needle_field) && $item->$needle_field === $needle) 
                return true; 
    } 
    else { 
        foreach ($haystack as $item) 
            if (isset($item->$needle_field) && $item->$needle_field == $needle) 
                return true; 
    } 
    return false; 
}
?>