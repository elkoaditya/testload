<?php
/*
	///REDIRECT
	
	$array = rand(1,9);	
	
	$surl[1] = 'sr1.smagaku.xyz';	
	$surl[2] = 'sr1.smagaku.xyz';	
	$surl[3] = '';		
	
	$surl[4] = 'sr2.smagaku.xyz';	
	$surl[5] = 'sr2.smagaku.xyz';	
	$surl[6] = '';		
	
	$surl[7] = '';	
	$surl[8] = '';	
	$surl[9] = '';		
	$url = $surl[$array];	
	
	if($url!=''){	
		header("Location: https://".$url."/");
	}
*/
define('VIDCALL_JITSI','https://meet.jit.si');

define('API_KEY_ZOOM','eB_IeeObTXmHGXM3pPYlww');
define('API_KEY_SECRET_ZOOM','nrvAEzRy32NCriushNQCm8gWip1y1V3duI0o');

define('VIDCALL_ZOOM',"https://zoom.fresto.top/CDN/".
"meeting.html?name=aaa&mn=meeting_id&email=meeting_email&pwd=password&role=0&lang=en-US&".
"signature=kode_signature&".
"china=0&apiKey=api_key");

define('VIDCALL_ZOOM_APK','https://us02web.zoom.us/j/meeting_id?pwd=encrypted_password');

header("Access-Control-Allow-Origin: *");

ini_set("memory_limit", -1);
set_time_limit(300);

$host_address = $_SERVER['HTTP_HOST'];
$host_address = str_replace("www.","",$host_address);

define('LOGO_FRONT', NULL);
define('APP_NAME', 'edu');
define('APP_VERSION', 2);
define('APP_SUBDOMAIN', 'sma_smg3n');
//define('APP_DOMAIN', '45.114.118.248');
define('APP_DOMAIN', $host_address);
define('APP_ADDRESS', "https://{$host_address}/");
define('SESS_NAME', 'edu_2.1a8');

define('MAILER_ADDRESS', 'no-reply@fresto.co');
define('MAILER_NAME', 'fresto.co');

define('DEFAULT_BROWSER_THEME', 'simple');
define('DEFAULT_MOBILE_THEME', 'simple');
define('DEFAULT_THEME', 'simple');


define('APP_SCOPE', 'sman3smg');
define('THEME', 'bootswatch_cosmo');
//define('THEME', 'material_admin');
define('TITLE_LOGIN', 'EVALUASI SMAGAKU');
define('APP_TITLE', 'E-SMAGAKU');
define('APP_PLACE', 'E-SMAGAKU');
define('APP_SCHOOL', 'SMA Negeri 3 Semarang');

define('APP_SCHOOL_ADDRESS', 'Jl. -');

@date_default_timezone_set('Asia/Jakarta');

if( isset($_SERVER['HTTPS'] ) ) {
	
}else{
	header("Location: https://".$_SERVER[HTTP_HOST]."");
}

header("Access-Control-Allow-Origin: *");

// var saya
define('VIDCALL','https://meet.jit.si');
define('URL_MASTER',$_SERVER['HTTP_HOST']."/");
//define('APP_ROOT', '/home/risto/public_html/fresto.biz/m4n3riq/');
define('APP_ROOT', '/home/'.$host_address.'/public_html/');
/*
 * ---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 * ---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
define('ENVIRONMENT', 'development');
/*
 * ---------------------------------------------------------------
 * ERROR REPORTING
 * ---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
			break;

		case 'testing':
		case 'production':
			error_reporting(0);
			break;

		default:
			exit('The application environment is not set correctly.');
	}
}

/*
 * ---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 * ---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 *
 */
$system_path = 'system';

/*
 * ---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 * ---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
$application_folder = 'application';

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here.  For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 *
 */
// The directory name, relative to the "controllers" folder.  Leave blank
// if your controller is not in a sub-folder within the "controllers" folder
// $routing['directory'] = '';
// The controller class file name.  Example:  Mycontroller
// $routing['controller'] = '';
// The controller function you wish to be called.
// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 *
 */
// $assign_to_config['name_of_config_item'] = 'value of config item';
// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
//$path = "/home/risto/public_html/fresto.biz/m4n3riq/";
$path = APP_ROOT;

if (defined('STDIN'))
{
	chdir(dirname(__FILE__));
}

if (realpath($system_path) !== FALSE)
{
	//$system_path = realpath($system_path) . '/';
}

//EDIT DWI
	$system_path = $path.$system_path."/";
	
// ensure there's a trailing slash
$system_path = rtrim($system_path, '/') . '/';

// Is the system path correct?
if (!is_dir($system_path))
{
	exit($system_path." Your system folder path does not appear to be set correctly. Please open the following file and correct this: " . pathinfo(__FILE__, PATHINFO_BASENAME));
}



/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// The PHP file extension
// this global constant is deprecated.
define('EXT', '.php');

// Path to the system folder
define('BASEPATH', str_replace("\\", "/", $system_path));

// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));

// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));


// The path to the "application" folder
//exit(','.BASEPATH . $application_folder . '/,');
if (is_dir($application_folder))
{
	define('APPPATH', $application_folder . '/');
}
else
{
	/*
	if (!is_dir(BASEPATH . $application_folder . '/'))
	{
		exit("2 Your application folder path does not appear to be set correctly. Please open the following file and correct this: " . SELF);
	}

	define('APPPATH', BASEPATH . $application_folder . '/');
	*/
	define('APPPATH', $path . $application_folder . '/');
}

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once BASEPATH . 'core/CodeIgniter.php';

/* End of file index.php */
/* Location: ./index.php */