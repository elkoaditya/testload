<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;


$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'risto';
$db['default']['password'] = '@Risto423282';
		
if (APP_SUBDOMAIN == 'localhost'):
	$db['default']['database'] = 'fresto_bosko';
	$db['default']['password'] = 'root';

elseif (APP_SUBDOMAIN == 'sma_smg1n'):
	$db['default']['database'] = 'sma_smg1n';
	
elseif (APP_SUBDOMAIN == 'sma_smg2n'):
	$db['default']['database'] = 'sma_smg2n';
	
elseif (APP_SUBDOMAIN == 'sma_smg3n'):
	$db['default']['database'] = 'sma_smg3n';
	
elseif (APP_SUBDOMAIN == 'sma_smg4n'):
	$db['default']['database'] = 'sma_smg4n';

elseif (APP_SUBDOMAIN == 'sma_smg5n'):
	$db['default']['database'] = 'sma_smg5n';

elseif (APP_SUBDOMAIN == 'sma_smg6n'):
	$db['default']['database'] = 'sma_smg6n';
	
elseif (APP_SUBDOMAIN == 'sma_smg7n'):
	$db['default']['database'] = 'sma_smg7n';

elseif (APP_SUBDOMAIN == 'sma_smg8n'):
	$db['default']['database'] = 'sma_smg8n';

elseif (APP_SUBDOMAIN == 'sma_smg9n'):
	$db['default']['database'] = 'sma_smg9n';

elseif (APP_SUBDOMAIN == 'sma_smg10n'):
	$db['default']['database'] = 'sma_smg10n';

elseif (APP_SUBDOMAIN == 'sma_smg11n'):
	$db['default']['database'] = 'sma_smg11n';

elseif (APP_SUBDOMAIN == 'sma_smg12n'):
	$db['default']['database'] = 'sma_smg12n';

elseif (APP_SUBDOMAIN == 'sma_smg13n'):
	$db['default']['database'] = 'sma_smg13n';

elseif (APP_SUBDOMAIN == 'sma_smg14n'):
	$db['default']['database'] = 'sma_smg14n';

elseif (APP_SUBDOMAIN == 'sma_smg15n'):
	$db['default']['database'] = 'sma_smg15n';

elseif (APP_SUBDOMAIN == 'sma_smg16n'):
	$db['default']['database'] = 'sma_smg16n';

elseif (APP_SUBDOMAIN == 'sma_ung2n'):
	$db['default']['database'] = 'sma_ugn2n';

elseif (APP_SUBDOMAIN == 'sma_muh1'):
	$db['default']['database'] = 'sma_muh1';
	
elseif (APP_SUBDOMAIN == 'smapldonbosko'):
	$db['default']['database'] = 'sma_bosko';
	
////// SMK
elseif (APP_SUBDOMAIN == 'smk_smg6n'):
	$db['default']['database'] = 'smk_smg6n';
	
elseif (APP_SUBDOMAIN == 'smk_penerbangan'):
	$db['default']['database'] = 'smk_penerbangan';
	
////// SMP 
elseif (APP_SUBDOMAIN == 'smp_terbang'):
	$db['default']['database'] = 'smp_terbang';
	
endif;
  
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = FALSE;
$db['default']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */