<?php	
header("Access-Control-Allow-Origin: *");

ini_set("memory_limit", -1);
set_time_limit(300);

$host_address = $_SERVER['HTTP_HOST'];

define('LOGO_FRONT', NULL);
define('APP_NAME', 'edu');
define('APP_VERSION', 2);
define('APP_SUBDOMAIN', 'sma_smg2n');
//define('APP_DOMAIN', '45.114.118.248');
define('APP_DOMAIN', 'fresto.biz');
define('APP_ADDRESS', "https://{$host_address}/".APP_SUBDOMAIN."/");
define('SESS_NAME', 'edu_2.1a8');

define('MAILER_ADDRESS', 'no-reply@fresto.co');
define('MAILER_NAME', 'fresto.co');

define('DEFAULT_BROWSER_THEME', 'simple');
define('DEFAULT_MOBILE_THEME', 'simple');
define('DEFAULT_THEME', 'simple');


define('APP_SCOPE', 'sman2smg');
define('THEME', 'bootswatch_cosmo');
//define('THEME', 'material_admin');
define('TITLE_LOGIN', 'SMAN 2 SEMARANG');
define('APP_TITLE', 'SMAN 2');
define('APP_PLACE', 'SMAN 2');
define('APP_SCHOOL', 'SMA Negeri 2 Semarang');

define('APP_SCHOOL_ADDRESS', 'Jl. Cemara Raya Padangsari Banyumanik Semarang 50267');

@date_default_timezone_set('Asia/Jakarta');

//include('/home/risto/public_html/m4n3riq/index.php');
include('/home/risto/public_html/fresto.biz/m4n3riq/index.php');
//echo"a";
?>