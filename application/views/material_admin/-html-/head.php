<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['user_id'])||$user['id']!="")
{
	if($_SESSION['user_id'] != $user['id'])
	{
		if(($_SESSION['user_id']>0) && ($user['id']>0))
		{	header("Refresh:0");	}
		header("Location: ".base_url()."logout");
		//header(base_url()."logout");
	}
	
}

$d = $this->d; 
if (isset($title))
	$title .= ' | ' . APP_TITLE;
else
	$title = APP_TITLE;
?>
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <meta name="description" content="E-learning SMA SMK SMP Evaluasi Materi Pembelajaran">
        <meta name="author" content="Fredy Nurman Saleh">
        <meta name="author" content="Dhin Aristo">
        <meta name="author" content="Dwi Setyawan">
        <meta name="author" content="Yusuf FS">

        <!-- Vendor CSS -->
        <?php include APP_ROOT."assets/material_admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.php";?> 
        <!--
        <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
        -->
        <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
        <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">

        <!-- CSS -->
    	<?php include APP_ROOT."assets/material_admin/css/app.php";?>
        <?php if(strpos($d['uri'],'kbm/evaluasi_ljs/form')!==FALSE){ ?>
        	<link href="<?php echo base_url("assets/material_admin"); ?>/css/app_1_form.min.css" rel="stylesheet">
        <?php }else{ ?>
        	<link href="<?php echo base_url("assets/material_admin"); ?>/css/app_1.min.css" rel="stylesheet">
        <?php } ?>
        <link href="<?php echo base_url("assets/material_admin"); ?>/css/app_2.min.css" rel="stylesheet">
        
        <!-- Following CSS codes are used only fore demo purposes thus you can remove anytime -->
        <link href="<?php echo base_url("assets/material_admin"); ?>/css/demo.css" rel="stylesheet">
        
        <!-- Tinymce Font -->
        <?php include "/var/www/fresto.co/master_fresto_v2_01/assets/tinymce_4.0.2/skins/lightgray/skin.min.php";?> 
		<style>
		table {
			font-size: 14px;
		}
		</style>
    </head>
    <body>
    
    <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>Please wait...</p>
            </div>
        </div>
        
    <header id="header" class="clearfix" style="background-color:#FF4500">
            <ul class="h-inner">
                <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>

                <li class="hi-logo hidden-xs">
                    <a href="index.html"><b><?php echo APP_TITLE; ?></b></a>
                </li>

                <li class="pull-right">
                    <ul class="hi-menu">

                        <li data-ma-action="search-open">
                            <a href=""><i class="him-icon zmdi zmdi-search"></i></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url("logout"); ?>"><i class="him-icon zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Top Search Content -->
            <div class="h-search-wrap">
                <div class="hsw-inner">
                    <i class="hsw-close zmdi zmdi-arrow-left" data-ma-action="search-close"></i>
                    <input type="text">
                </div>
            </div>
        </header>
