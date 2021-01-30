<?php

//define("ENCRYPTION_KEY", "grand@3716");
$secret_key = 'ajantha_iwmi_hydro';
$secret_iv = 'my_simple_secret_iv'; 
$encrypted_ini_path = $_SERVER['DOCUMENT_ROOT'] . "/conf/config.ini"; //localhost
//$encrypted_ini_path = $_SERVER['DOCUMENT_ROOT'] . "/applications/l_irri/conf/config.ini"; //aurra

$config = array();
if ($file = fopen($encrypted_ini_path, "r")) {
    while(!feof($file)) {
        $line = fgets($file);
        //$string_decrypted = decrypt(rtrim($line), ENCRYPTION_KEY);
        $string_decrypted = my_simple_crypt($secret_key, $secret_iv, rtrim($line), 'd');
        list($key, $val) = explode(' = ', $string_decrypted);
    
        if(!isset($config[$key])) {
            $config[$key] = array();
        }
        $config[$key] = rtrim($val);
    }
}


//echo $conf_vals['host']; 
/**
 * Returns an encrypted & AES-256-CBC encoded
 */
function my_simple_crypt($secret_key, $secret_iv, $string, $action = 'e') {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}

?>