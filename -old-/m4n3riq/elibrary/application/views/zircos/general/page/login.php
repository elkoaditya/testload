<!DOCTYPE html>
<?php
if(defined('CHANGE_TITLE')){
	$title = CHANGE_TITLE;
}else{
	$title = 'Perpustakaan Digital';
}

if(defined('UNIQUE_SEKOLAH')){
	$sekolah = UNIQUE_SEKOLAH;
}else{
	$sekolah = SEKOLAH;
}
?>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?=$title?></title>
		<meta name="description" content="Examples for creative website header animations using Canvas and JavaScript" />
		<meta name="keywords" content="header, canvas, animated, creative, inspiration, javascript" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="<?=URL_MASTER?>resource/third_party/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="<?=URL_MASTER?>resource/third_party/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="<?=URL_MASTER?>resource/third_party/css/component.css" />
		<link href='http://fonts.googleapis.com/css?family=Raleway:200,400,800' rel='stylesheet' type='text/css'>
		<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	<!--</head>-->
	<style>
	html,body{
	  margin:0;
	  font-family:'Raleway','Roboto',Helvetica,sans-serif;
	}
	/* Header */
	.large-header {
		position: relative;
		width: 100%;
		background: #333;
		overflow: hidden;
		background-size: cover;
		background-position: center center;
		z-index: 1;
	}

	#large-header {
			background-image: linear-gradient(135deg,#001160 0%,#00ecf4 100%)!important;
	}

	
	input{
	  width:300px;
	  padding:7px;
	  border-radius:3px;
	  border:solid 0.4px #ddd;
	  font-weight:300;
	  font-family:'Roboto',helvetica,sans-serif;
	  
	}
	input[type="submit"]{
	  width:316px;
	  border:0;
	  color:#fff;
	  background:#08f;
	  font-weight:600;
	  box-shadow:0 5px 12px rgba(0,0,0,0.2);
	  -moz-box-shadow:0 5px 12px rgba(0,0,0,0.2);
	  -webkit-box-shadow:0 5px 12px rgba(0,0,0,0.2);
	}
	
	input[type="submit"]:hover{
	  box-shadow:0 5px 8px rgba(0,0,0,0.4);
	  -moz-box-shadow:0 5px 8px rgba(0,0,0,0.4);
	  -webkit-box-shadow:0 5px 8px rgba(0,0,0,0.4);
	}

	
</style>
 <!--</body>
</html>-->
	<body>
		<div class="container demo-1">
			<div class="content">
				<div id="large-header" class="large-header">
					<canvas id="demo-canvas"></canvas>
					<div class="main-title">
						
							<img src="<?=URL_MASTER?>content/images/<?=LOGO_SEKOLAH?>" width="20%"><br>
							<h2><?=strtoupper($title)?> <?=$sekolah?></h2>
							<p class="thin">Log in to your account </p><p id="demo"></p>
						
						  <form id="form_login" name="form_login" action="<?=base_url();?>dashboard/login/verifikasi" method="post">
							<p><input placeholder="username" name="username" type="text" id="username" class="field"/></p>
							<p><input placeholder="password" name="password" type="password" id="password" class="field"/></p>
							<p><input value="submit" type="submit"></p>
						  </form>
					</div>
				</div>
			  
			  <!--<small class="thin">Not a member yet? <a href="#">Sign in</a></small>-->
			</div>
		</div>
	
	
		<script src="<?=URL_MASTER?>resource/third_party/js/TweenLite.min.js"></script>
		<script src="<?=URL_MASTER?>resource/third_party/js/EasePack.min.js"></script>
		<script src="<?=URL_MASTER?>resource/third_party/js/rAF.js"></script>
		<script src="<?=URL_MASTER?>resource/third_party/js/demo-1.js"></script>
	<!-- </body></html> -->
	
	</BODY>
</html>


