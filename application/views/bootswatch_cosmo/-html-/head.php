<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/*
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
*/
//echo $_SESSION['user_id']."<br>";
	//echo $user['id'];
if (isset($title))
	$title .= ' | ' . APP_TITLE;
else
	$title = APP_TITLE;
header('Access-Control-Allow-Origin: *'); 	
?>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=TITLE_LOGIN?>">
	<meta name="author" content="TEAM <?=APP_TITLE?>">

	<!--[if lt IE 9]>
		<script src="<?php echo base_url("assets/bootswatch_cosmo"); ?>/html5.js"></script>
	<![endif]-->
	<?php include APP_ROOT."/assets/bootswatch_cosmo/font-awesome.php";?> 
    
	<link href="<?php echo base_url("assets/bootswatch_cosmo") . ((APP_DOMAIN == 'localhost') ? '/bootstrap.min.local.css' : '/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url("assets/bootswatch_cosmo"); ?>/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="<?php echo base_url("assets/bootswatch_cosmo"); ?>/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url("assets/bootswatch_cosmo"); ?>/bootswatch.css" rel="stylesheet">
	<link href="<?php echo base_url("assets/bootswatch_cosmo"); ?>/table-responsive.css" rel="stylesheet">

	<style>
		.select option { color: black; }
		.empty { color: #bbb; }
	</style>
	<?php include APP_ROOT."/assets/tinymce_4.0.2/skins/lightgray/skin.min.php";?> 
	
	
</head>