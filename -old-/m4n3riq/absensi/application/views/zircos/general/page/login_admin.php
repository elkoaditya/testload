<!DOCTYPE html>
<?php 
$set_resource = base_url().'resource/material_admin/';
?>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Siswa Daftar Ulang | SMAN 8 SMG</title>
      <link rel="stylesheet" href="<?=base_url()?>resource/third_party/calm-breeze/css/style.css">
</head>

<body>

  <div class="wrapper">
	<div class="container" style="margin-top:-70px">
		<img src="<?=base_url()?>content/images/SMA1.png" width="16%"><br>
		<b><h2>ADMIN DAFTAR ULANG SMAN 1 SEMARANG </h2></b>
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
<script src="<?=$set_resource?>vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script  src="<?=base_url()?>resource/third_party/calm-breeze/js/index.js"></script>


</body>

</html>


