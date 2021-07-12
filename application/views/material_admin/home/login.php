<?php
	$logo = NULL;

	if (APP_DOMAIN == 'localhost'):
		$logo = array(
				'src' => 'images/logo/theresiana_sma1.jpg',
				'width' => 280,
				'height' => 262,
		);

	elseif (APP_SUBDOMAIN == 'sma-setiabudhi.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
				'width' => 180,
		);

	elseif (APP_SUBDOMAIN == 'sman8-smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/sma8.jpg',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'sman9-smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/Logo-sma-9-semarang.jpg',
				'width' => 120,
		);
		
	elseif (APP_SUBDOMAIN == 'sman14-smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo-sman14-smg.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'smaterbang.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/sma-terang-bangsa.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'smamichael.smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/Logo SMA santo michael.jpg',
				'width' => 180,
		);
	
	elseif (APP_SUBDOMAIN == 'smk-penerbangan.smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/smk-penerbad.png',
				'width' => 180,
		);
	elseif (APP_SUBDOMAIN == 'smknusaputera1.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo_nusaputera.jpg',
				'width' => 180,
		);
				
	elseif (APP_SUBDOMAIN == 'demo.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo fresto g2.png',
				'width' => 180,
				
		);
		
	endif;
	?>
<!DOCTYPE html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Login | <?php echo APP_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Team Fresto">
	<?php include "/var/www/fresto.co/master_fresto_v2_01/assets/material_admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.php";?> 
    
    <!-- Vendor CSS -->
    <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

    <!-- CSS -->
    <?php include "/var/www/fresto.co/master_fresto_v2_01/assets/material_admin/css/app.php";?>
    <link href="<?php echo base_url("assets/material_admin"); ?>/css/app_1.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets/material_admin"); ?>/css/app_2.min.css" rel="stylesheet">
 
        
 	<style>
	/*div {
		-webkit-animation: mymove 2s infinite; 
		-webkit-animation-delay: 3s; 
		animation: mymove 2s infinite;
		animation-delay: 3s;
	}*/
	</style>
    <body>
        <div class="login-content">
        	
            <div class="lc-block toggled" id="l-login">
                
                 <div class="lcb-form">
                    <form action="<?php echo base_url().$uri;?>"	method="post" accept-charset="utf-8">
                    <!-- Login -->
                        <table width="100%">
                             <tr>
                                <td align="center" style="font-family: roboto;"><div id="title"><h1><?php echo TITLE_LOGIN;?></h1></h1>
                                  </td>
                             </tr>
                             <tr>
                              	<td align="center"><div id="logo"><?=img($logo);?></div></td>
                             </tr>
                        </table>
                    <?php echo alert_get(); ?>
                        <div class="input-group m-b-20">
                            <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                            <div class="fg-line">
                                <input type="text" class="form-control" name="username" placeholder="Username">
                            </div>
                        </div>
    
                        <div class="input-group m-b-20">
                            <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
                            <div class="fg-line">
                                <input type="password" class="form-control" name="password"   placeholder="Password">
                            </div>
                        </div>
    
                        <!--<div class="checkbox">
                            <label>
                                <input type="checkbox" value="">
                                <i class="input-helper"></i>
                                Keep me signed in
                            </label>
                        </div>-->
    
                        <!--<a href="" class="btn btn-login btn-success btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>-->
                        <button id="submit" type="submit" name="submit" data-growl-demo data-type="danger" class="btn btn-login btn-warning btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>
                	</form>
                </div>
                
            </div>
			
        </div>
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/Waves/dist/waves.min.js"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url("assets/material_admin"); ?>/js/app.min.js"></script>
        
    	<script type="text/javascript">
			
			$('#title').addClass('animated zoomInDown');
			function delayAnimation () {
				var animatedEl = document.getElementById('title');
				animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className = 'animated tada';
					setTimeout(delayAnimation, 8000);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			setTimeout(delayAnimation, 3000);
			
			 $('#logo').addClass('animated flip');
			function delayAnimation2 () {
				var animatedEl = document.getElementById('logo');
				animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className = 'animated rubberBand';
					setTimeout(delayAnimation2, 8000);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			setTimeout(delayAnimation2, 5000);
			
			 $('#alert').addClass('animated flip');
			function delayAnimation3 () {
				var animatedEl = document.getElementById('alert');
				animatedEl.className = 'alert alert-danger';
				setTimeout(function () {
					animatedEl.className = 'alert alert-danger animated flipInX';
					setTimeout(delayAnimation3, 8000);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			setTimeout(delayAnimation3, 7000);
			/*
			setTimeout(function(){
						 
                         $('#logo').addClass('animated');
						 $("#logo").removeClass("animated");
						 $("#logo").removeClass("flip");
                    }, 3000);*/
			
			//$('#logo').addClass('animated infinite tada');
		</script>
        
	</body>
</html>