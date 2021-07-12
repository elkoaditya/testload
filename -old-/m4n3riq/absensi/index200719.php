<?php

//// CORE
	if(APP_SUBDOMAIN =='sma_smg1n')
	{	
		define('SEKOLAH', 'SMA NEGERI 1 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_1_Semarang.png');	
		define('APP_SCOPE', 'sman1smg');
	}

	elseif(APP_SUBDOMAIN =='sma_smg2n')
	{	
		define('SEKOLAH', 'SMA NEGERI 2 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_2_Semarang.png');	
		define('APP_SCOPE', 'sman2smg');
	}

	elseif(APP_SUBDOMAIN =='sma_smg3n')
	{	
		define('SEKOLAH', 'SMA NEGERI 3 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_3_Semarang.png');	
		define('APP_SCOPE', 'sman3smg');
	}

	elseif(APP_SUBDOMAIN =='sma_smg4n')
	{	
		define('SEKOLAH', 'SMA NEGERI 4 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_4_Semarang.png');	
		define('APP_SCOPE', 'sman4smg');
	}

	elseif(APP_SUBDOMAIN =='sma_smg5n')
	{	
		define('SEKOLAH', 'SMA NEGERI 5 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_5_Semarang.png');
		define('APP_SCOPE', 'sman5smg');		
	}
	
	elseif(APP_SUBDOMAIN =='sma_smg6n')
	{	
		define('SEKOLAH', 'SMA NEGERI 6 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_6_Semarang.png');	
		define('APP_SCOPE', 'sman6smg');
	}

	elseif(APP_SUBDOMAIN =='sma_smg7n')
	{	
		define('SEKOLAH', 'SMA NEGERI 7 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_7_Semarang.png');	
		define('APP_SCOPE', 'sman7smg');
	}
	
	elseif(APP_SUBDOMAIN =='sma_smg8n')
	{	
		define('SEKOLAH', 'SMA NEGERI 8 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_8_Semarang.png');	
		define('APP_SCOPE', 'sman8smg');
	}

	elseif(APP_SUBDOMAIN =='sma_smg9n')
	{	
		define('SEKOLAH', 'SMA NEGERI 9 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_9_Semarang.png');	
		define('APP_SCOPE', 'sman9smg');
	}

	elseif(APP_SUBDOMAIN =='sma_smg10n')
	{	
		define('SEKOLAH', 'SMA NEGERI 10 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_10_Semarang.png');	
		define('APP_SCOPE', 'sman10smg');
	}
	
	elseif(APP_SUBDOMAIN =='sma_smg11n')
	{	
		define('SEKOLAH', 'SMA NEGERI 11 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_11_Semarang.png');	
		define('APP_SCOPE', 'sman11smg');
	}
	
	elseif(APP_SUBDOMAIN =='sma_smg12n')
	{	
		define('SEKOLAH', 'SMA NEGERI 12 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_12_Semarang.png');	
		define('APP_SCOPE', 'sman12smg');
	}
	
	elseif(APP_SUBDOMAIN =='sma_smg13n')
	{	
		define('SEKOLAH', 'SMA NEGERI 13 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_13_Semarang.png');	
		define('APP_SCOPE', 'sman13smg');
	}
	
	elseif(APP_SUBDOMAIN =='sma_smg14n')
	{	
		define('SEKOLAH', 'SMA NEGERI 14 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_14_Semarang.png');	
		define('APP_SCOPE', 'sman14smg');
	}
	
	elseif(APP_SUBDOMAIN =='sma_smg15n')
	{	
		define('SEKOLAH', 'SMA NEGERI 15 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_15_Semarang.png');
		define('APP_SCOPE', 'sman15smg');		
	}
	
	elseif(APP_SUBDOMAIN =='sma_smg16n')
	{	
		define('SEKOLAH', 'SMA NEGERI 16 SEMARANG');
		define('LOGO_SEKOLAH', 'SMAN_16_Semarang.png');	
		define('APP_SCOPE', 'sman16smg');
	}
	
	elseif(APP_SUBDOMAIN =='sma_ung2n')
	{	
		define('SEKOLAH', 'SMA NEGERI 2 UNGARAN');
		define('LOGO_SEKOLAH', 'SMAN_2_Ungaran.png');	
		define('APP_SCOPE', 'sman2ung');
	}
	
	elseif(APP_SUBDOMAIN =='smk_smg6n')
	{	
		define('SEKOLAH', 'SMK NEGERI 6 SEMARANG');
		define('LOGO_SEKOLAH', 'SMKN_6_Semarang.png');	
		define('APP_SCOPE', 'smk_smg6n');
	}
	
	elseif(APP_SUBDOMAIN =='smapldonbosko')
	{	
		define('SEKOLAH', 'SMA PL DON BOSKO');
		define('LOGO_SEKOLAH', 'SMA_PL_DonBosko.png');	
		define('APP_SCOPE', 'smapldonbosko');
	}

//define('URL_MASTER','http://fresto.co/master_fresto_v2_01/absensi/');
//define('APP_ROOT', '/var/www/fresto.co/master_fresto_v2_01/absensi/');

//define('URL_MASTER','http://45.114.118.225/m4n3riq/absensi/');
define('URL_MASTER','http://'.$_SERVER['HTTP_HOST'].'/m4n3riq/absensi/');
define('APP_ROOT', '/home/risto/public_html/m4n3riq/absensi/');

@date_default_timezone_set('Asia/Jakarta');
/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
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
	//define('ENVIRONMENT', 'production');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
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
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 *
 */
	$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
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
//$path = "/var/www/fresto.co/master_fresto_v2_01/absensi/";
$path = "/home/risto/public_html/m4n3riq/absensi/";
	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (realpath($system_path) !== FALSE)
	{
		//$system_path = realpath($system_path).'/';
	}

	// ensure there's a trailing slash
	$system_path = $path.$system_path."/";

	$system_path = rtrim($system_path, '/').'/';
	
	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
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
	if (is_dir($application_folder))
	{
		define('APPPATH', $application_folder.'/');
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
require_once BASEPATH.'core/CodeIgniter.php';

/* End of file index.php */
/* Location: ./index.php */