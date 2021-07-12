<?php 
	//$session_user = $this->session->userdata('user');
	$session_user = $_SESSION['user'];
	
	  /// CORE
if (APP_SUBDOMAIN == 'sma_smg1n')
{	$sekolah = 'SMAN 1 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg2n')
{	$sekolah = 'SMAN 2 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg3n')
{	$sekolah = 'SMAN 3 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg4n')
{	$sekolah = 'SMAN 4 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg5n')
{	$sekolah = 'SMAN 5 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg6n')
{	$sekolah = 'SMAN 6 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg7n')
{	$sekolah = 'SMAN 7 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg8n')
{	$sekolah = 'SMAN 8 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg9n')
{	$sekolah = 'SMAN 9 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg10n')
{	$sekolah = 'SMAN 10 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg11n')
{	$sekolah = 'SMAN 11 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg12n')
{	$sekolah = 'SMAN 12 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg13n')
{	$sekolah = 'SMAN 13 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg14n')
{	$sekolah = 'SMAN 14 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg15n')
{	$sekolah = 'SMAN 15 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_smg16n')
{	$sekolah = 'SMAN 16 SEMARANG';		}
elseif(APP_SUBDOMAIN == 'sma_ung2n')
{	$sekolah = 'SMAN 2 UNGARAN';		}	  
	  
elseif(APP_SUBDOMAIN == 'smp_terbang')
{	$sekolah = 'SMP TERBANG';		}		  
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fresto Injek</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo URL_MASTER;?>/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo URL_MASTER;?>/public/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
	
    <!-- DataTables CSS -->
    <link href="<?php echo URL_MASTER;?>/public/css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo URL_MASTER;?>/public/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo URL_MASTER;?>/public/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
    
    <link href="<?php echo URL_MASTER;?>/public/css/jquery-impromptu.css" rel="stylesheet">

	<link href="<?php echo URL_MASTER;?>/public/winmarkltd-BootstrapFormHelpers-0d89ab4/dist/css/bootstrap-formhelpers.min.css" rel="stylesheet" media="screen">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
	<!-- jQuery Version 1.11.0 -->
    <script src="<?php echo URL_MASTER;?>/public/js/jquery-1.11.0.js"></script>

	
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Fresto Injektor ( <?php echo $sekolah;?> )  </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <?=$session_user->user_name;?> 
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo site_url("/user/profile");?>"><i class="fa fa-user fa-fw"></i> User Profile</a> </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a> </li>
                        <li class="divider"></li>
            			<li><a href="<?php echo site_url("/login/logout");?>"><i class="fa fa-power-off"></i> Log Out</a></li>
                        
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
        
        