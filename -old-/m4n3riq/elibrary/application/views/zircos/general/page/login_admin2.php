<!DOCTYPE html>
<?php 
define('APP_ROOT_ABSENSI',"http://fresto.co/master_fresto_v2_01/absensi/");
?>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Perpustakaan Digital</title>
      <link rel="stylesheet" href="<?=URL_MASTER?>resource/third_party/calm-breeze/css/style.css">
</head>

<body>

  <div class="wrapper">
	<div class="container" style="margin-top:-70px">
		<img src="<?=URL_MASTER?>content/images/<?=LOGO_SEKOLAH?>" width="20%"><br>
		<b><h2>ADMIN PERPUSTAKAAN DIGITAL <?=SEKOLAH?></h2></b>
		<form class="form" id="form_login" name="form_login" action="<?=base_url();?>dashboard/login_admin/verifikasi" method="post" style="margin-top:-10px">
			<input type="text" placeholder="Username" id="username" name="username">
			<input type="password" placeholder="Password" id="password" name="password">
			<button type="submit" id="button" class="btn-login">Login</button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
  <!--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->
<!--<script src="<?=$set_resource?>vendors/bower_components/jquery/dist/jquery.min.js"></script>-->
<script src="<?=URL_MASTER?>assets/js/jquery.min.js"></script>
    <script  src="<?=URL_MASTER?>resource/third_party/calm-breeze/js/index.js"></script>


<!-- </body></html> -->

</html>


