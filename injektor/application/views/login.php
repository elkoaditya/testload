<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Fresto Login Form</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		
        <link href="<?php echo base_url("public/css/bootstrap.css")?>" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
        <link href="<?php echo base_url("public/css/styles.css")?>" rel="stylesheet">
		
	</head>
	<body>
<!--login modal-->
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
          <div align="center">FRESTO INJEK</div>
      </div>
      <?php 
	  if($false==1)
	  {
	  ?>
          <div  class="alert alert alert-dismissable alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <p>Kesalahan Username atau Password</p>
          </div>
      <?php 
	  }
	  ?>
      <div class="modal-body">
          <form class="form col-md-12 center-block" action="<?php echo site_url("/login");?>" method="post">
            <div class="form-group">
              <input type="text" name="user" class="form-control input-lg" placeholder="Username or Email">
            </div>
            <div class="form-group">
              <input type="password" name="pass" class="form-control input-lg" placeholder="Password">
            </div>
            <div class="form-group">
              <input type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="Sign In" />
              <!-- <span class="pull-right"><a href="#">Register</a></span><span><a href="#">Need help?</a></span> -->
            </div>
          </form>
      </div>
  
      <div class="modal-footer">
      	 <img width="110px" src=<?php echo base_url("public/img/Logo_ori2.png");?> />
          <!--	<div class="col-md-12">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		  </div>	-->
      </div>
  </div>
  </div>
</div>
	<!-- script references -->
		
		<script src="<?php echo base_url("public/js/jquery-1.10.2.js")?>"></script>
        <script src="<?php echo base_url("public/js/bootstrap.js")?>"></script>
		
	</body>
</html>