<?php	
@date_default_timezone_set('Asia/Jakarta');
header("Access-Control-Allow-Origin: *");

define('APP_SUBDOMAIN', 'sma_smg3n');

$host_address = "https://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];

if( isset($_SERVER['HTTPS'] ) ) {
	
}else{
	//echo APP_ADDRESS;
	header("Location: ".$host_address);
}

//include('/var/www/fresto.co/master_fresto_v2_01/injektor/index.php');
include('/home/risto/public_html/fresto.biz/m4n3riq/injektor/index.php');
?>